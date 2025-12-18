@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Detail Ploting - Final Approval</h4>

    <div class="mb-3">
        <p><strong>Prodi:</strong> {{ $ploting->prodi->nama ?? '-' }}</p>
        <p><strong>Mata Kuliah:</strong> {{ $ploting->matakuliah->nama ?? '-' }}</p>
        <p><strong>Dosen:</strong> {{ $ploting->dosen->name ?? '-' }}</p>
        <p><strong>Kelas:</strong> {{ $ploting->kelas->nama ?? '-' }}</p>
        <p><strong>Status Dekan:</strong> {{ $ploting->status }}</p>
        <p><strong>Catatan Dekan / Kaprodi:</strong> {{ $ploting->remarks ?? '-' }}</p>
    </div>

    <div class="mb-4">
        @if($ploting->final_status !== 'approved')
        <form action="{{ route('wr1.approval.approve', $ploting->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="mb-2">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="final_remarks" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-success">Final Setujui & Generate SK</button>
        </form>
        @endif

        @if($ploting->final_status !== 'rejected')
        <form action="{{ route('wr1.approval.reject', $ploting->id) }}" method="POST" onsubmit="return confirm('Tolak ploting ini?')">
            @csrf
            <div class="mb-2">
                <label class="form-label">Alasan Penolakan (wajib)</label>
                <textarea name="final_remarks" class="form-control" rows="3" required></textarea>
            </div>
            <button class="btn btn-danger">Tolak → Kembalikan ke Dekan</button>
        </form>
        @endif
    </div>

    <a href="{{ route('wr1.approval.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection