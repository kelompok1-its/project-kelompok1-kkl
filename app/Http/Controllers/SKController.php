<?php

namespace App\Http\Controllers;

use App\Models\Ploting;
use App\Models\SuratKeputusan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SKController extends Controller
{
    /**
     * Tampilkan daftar Ploting yang final_status nya dianggap "disetujui WR1"
     * dan belum memiliki surat keputusan.
     */
    public function index()
    {
        // variasi nilai final_status yang kita anggap sebagai "disetujui"
        $acceptedFinalStatuses = [
            'approved',
            'disetujui',
            'disetujui_wr1',
            'disetujui_dekan',
            'approved_wr1'
        ];

        // Ambil semua plotings yang memenuhi syarat lalu hapus duplikat berdasarkan kombinasi
        $plotings = Ploting::with(['prodi', 'matakuliah', 'dosen', 'kelas'])
            ->whereIn('final_status', $acceptedFinalStatuses)
            ->whereDoesntHave('suratKeputusan')
            ->orderByDesc('final_at')
            ->get()
            ->unique(function ($item) {
                return $item->prodi_id . '-' . $item->matakuliah_id . '-' . $item->dosen_id;
            })
            ->values();

        if ($plotings->isEmpty()) {
            // log sample untuk membantu debugging kenapa kosong
            Log::info('SKController@index: tidak ada ploting yang memenuhi syarat untuk dibuat SK.', [
                'sample_final_status' => Ploting::select('id', 'final_status', 'status')->orderByDesc('updated_at')->limit(10)->get()->toArray()
            ]);
        }

        return view('wr1.generate-sk.index', compact('plotings'));
    }

    /**
     * Buat record SuratKeputusan untuk satu ploting.
     * Route: POST /wr1/sk/store/{ploting}
     */
    public function store($plotingId)
    {
        $acceptedFinalStatuses = [
            'approved',
            'disetujui',
            'disetujui_wr1',
            'disetujui_dekan',
            'approved_wr1'
        ];

        $ploting = Ploting::with(['matakuliah', 'dosen', 'kelas'])->find($plotingId);

        if (! $ploting) {
            return redirect()->back()->with('error', 'Ploting tidak ditemukan.');
        }

        // Pastikan ploting sudah disetujui WR1 (final_status)
        if (! in_array($ploting->final_status, $acceptedFinalStatuses)) {
            return redirect()->back()->with('error', 'Ploting belum disetujui WR1. Tidak bisa membuat SK.');
        }

        // Cek apakah SK sudah ada
        if ($ploting->suratKeputusan()->exists()) {
            return redirect()->back()->with('error', 'SK untuk ploting ini sudah dibuat.');
        }

        try {
            DB::beginTransaction();

            $nomorSk = 'SK-' . date('Ymd') . '-' . $ploting->id;

            $sk = SuratKeputusan::create([
                'ploting_id'   => $ploting->id,
                'nomor_sk'     => $nomorSk,
                'tanggal_sk'   => now()->toDateString(),
                // set status_dekan berdasar status/approved flag (fallback ke 'disetujui')
                'status_dekan' => in_array($ploting->status, ['approved', 'disetujui', 'disetujui_dekan']) ? 'disetujui' : ($ploting->status ?? 'disetujui'),
                'status_warek1' => 'disetujui',
                'created_by'   => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('sk.generate', $sk->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('SKController@store: gagal membuat SuratKeputusan', [
                'error' => $e->getMessage(),
                'ploting_id' => $plotingId
            ]);
            return redirect()->back()->with('error', 'Gagal membuat SK: ' . $e->getMessage());
        }
    }

    /**
     * Generate & download PDF SK.
     * Route: GET /wr1/sk/download/{sk}
     */
    public function generateSK($id)
    {
        $sk = SuratKeputusan::with(['ploting.matakuliah', 'ploting.dosen', 'ploting.kelas'])->find($id);

        if (! $sk) {
            return redirect()->back()->with('error', 'SK tidak ditemukan.');
        }

        try {
            $pdf = Pdf::loadView('wr1.generate-sk.template', compact('sk'))
                ->setPaper('a4', 'portrait');

            return $pdf->download('SK_' . $sk->nomor_sk . '.pdf');
        } catch (\Throwable $e) {
            Log::error('SKController@generateSK: gagal generate PDF', [
                'error' => $e->getMessage(),
                'sk_id' => $id
            ]);
            return redirect()->back()->with('error', 'Gagal generate SK: ' . $e->getMessage());
        }
    }

    // di SKController.php (paste ke dalam class SKController)
    public function list()
    {
        // Hanya WR1 (opsional) — jika menggunakan session role check:
        if (session('current_role_slug') !== 'wr1') {
            // atau: abort(403);
            // tapi biasanya WR1 sudah di-restrict via middleware pada route
        }

        // Ambil semua SK, eager-load ploting + anaknya
        $sks = SuratKeputusan::with(['ploting.matakuliah', 'ploting.dosen', 'ploting.kelas', 'ploting.prodi'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('wr1.generate-sk.list', compact('sks'));
    }
}
