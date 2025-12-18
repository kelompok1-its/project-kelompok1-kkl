@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">Detail Ploting — Final Approval WR1</h4>

            {{-- INFORMASI PLOTTING --}}
            <table class="table table-bordered mb-4">
                <tr>
                    <th width="30%">Program Studi</th>
                    <td>{{ $ploting->prodi->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Mata Kuliah</th>
                    <td>{{ $ploting->matakuliah->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Dosen Pengampu</th>
                    <td>{{ $ploting->dosen->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $ploting->kelas->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status Dekan</th>
                    <td>
                        <span class="badge bg-success">
                            Disetujui
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Catatan Dekan / Kaprodi</th>
                    <td>{{ $ploting->remarks ?? '-' }}</td>
                </tr>
            </table>

            {{-- STATUS FINAL WR1 --}}
            <div class="mb-4">
                <strong>Status Final WR1:</strong>
                @if($ploting->final_status === 'approved')
                    <span class="badge bg-success ms-2">Disetujui</span>
                @elseif($ploting->final_status === 'rejected')
                    <span class="badge bg-danger ms-2">Ditolak</span>
                @else
                    <span class="badge bg-warning text-dark ms-2">Menunggu Persetujuan</span>
                @endif
            </div>

            {{-- FORM FINAL APPROVAL --}}
            @if($ploting->final_status !== 'approved')
                <form action="{{ route('wr1.approval.approve', $ploting->id) }}" method="POST" class="mb-4">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Catatan WR1 (opsional)</label>
                        <textarea
                            name="final_remarks"
                            class="form-control"
                            rows="3"
                            placeholder="Catatan tambahan (jika ada)"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success"
                        onclick="return confirm('Setujui ploting ini dan generate SK?')">
                        <i class="bi bi-check-circle"></i>
                        Final Setujui & Generate SK
                    </button>
                </form>
            @endif

            {{-- FORM PENOLAKAN --}}
            @if($ploting->final_status !== 'rejected')
                <form action="{{ route('wr1.approval.reject', $ploting->id) }}" method="POST"
                      onsubmit="return confirm('Tolak ploting ini dan kembalikan ke Dekan?')">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea
                            name="final_remarks"
                            class="form-control"
                            rows="3"
                            required
                            placeholder="Wajib diisi jika menolak"></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle"></i>
                        Tolak & Kembalikan ke Dekan
                    </button>
                </form>
            @endif

            <hr>

            {{-- NAVIGASI --}}
            <a href="{{ route('wr1.approval.index') }}" class="btn btn-secondary">
                ← Kembali ke Daftar Approval
            </a>

        </div>
    </div>
</div>
@endsection
