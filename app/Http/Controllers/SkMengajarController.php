<?php

namespace App\Http\Controllers;

use App\Models\SuratKeputusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class SkMengajarController extends Controller
{
    /**
     * Tampilkan daftar SK (dilihat oleh Akademik & Dosen).
     */
    public function index(Request $request)
    {
        // Optional: filter berdasarkan prodi, tahun, atau dosen
        $query = SuratKeputusan::with(['ploting.matakuliah', 'ploting.dosen', 'ploting.kelas'])
            ->orderByDesc('created_at');

        if ($request->filled('prodi_id')) {
            $query->whereHas('ploting', function ($q) use ($request) {
                $q->where('prodi_id', $request->prodi_id);
            });
        }

        if ($request->filled('dosen_id')) {
            $query->whereHas('ploting', function ($q) use ($request) {
                $q->where('dosen_id', $request->dosen_id);
            });
        }

        $sks = $query->paginate(15);

        return view('akademik.sk_mengajar.index', compact('sks'));
    }

    /**
     * Tampilkan detail SK / atau langsung download PDF.
     */
    public function show($id)
    {
        $sk = SuratKeputusan::with(['ploting.matakuliah', 'ploting.dosen', 'ploting.kelas'])->findOrFail($id);

        // Jika ingin menampilkan halaman detail:
        return view('akademik.sk_mengajar.show', compact('sk'));

        // Atau langsung download PDF:
        // return $this->downloadPdf($sk);
    }

    /**
     * Download PDF SK (dipanggil dari tombol Download).
     */
    public function download($id)
    {
        $sk = SuratKeputusan::with(['ploting.matakuliah', 'ploting.dosen', 'ploting.kelas'])->findOrFail($id);

        try {
            $pdf = Pdf::loadView('wr1.generate-sk.template', compact('sk'))->setPaper('a4', 'portrait');
            return $pdf->download('SK_' . $sk->nomor_sk . '.pdf');
        } catch (\Throwable $e) {
            Log::error('SkMengajarController@download error', ['error' => $e->getMessage(), 'sk_id' => $id]);
            return redirect()->back()->with('error', 'Gagal mendownload SK: ' . $e->getMessage());
        }
    }

    /**
     * Hapus SK — hanya untuk user Akademik (atau sesuai kebijakan).
     */
    public function destroy($id)
    {
        $sk = SuratKeputusan::findOrFail($id);

        // Cek peran: izinkan hanya Akademik (sesuaikan dengan implementasi role Anda)
        $role = session('current_role_slug', Auth::user()->role ?? null);
        if ($role !== 'akademik') {
            return redirect()->back()->with('error', 'Anda tidak berwenang menghapus SK.');
        }

        try {
            $sk->delete();
            return redirect()->route('sk_mengajar.index')->with('success', 'SK berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('SkMengajarController@destroy error', ['error' => $e->getMessage(), 'sk_id' => $id]);
            return redirect()->back()->with('error', 'Gagal menghapus SK: ' . $e->getMessage());
        }
    }
}
