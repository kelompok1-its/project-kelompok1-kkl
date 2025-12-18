@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Detail Ploting</h4>

    <div class="mb-3">
        <p><strong>Dosen:</strong> {{ $ploting->dosen->name ?? '-' }}</p>
        <p><strong>Mata Kuliah:</strong> {{ $ploting->matakuliah->nama ?? $ploting->matakuliah_id }}</p>
        <p><strong>Kelas:</strong> {{ $ploting->kelas->nama ?? $ploting->kelas_id ?? '-' }}</p>
        <p><strong>Semester:</strong> {{ $ploting->semester ?? '-' }}</p>
        <p><strong>Tahun:</strong> {{ $ploting->tahun_akademik ?? '-' }}</p>
        <p><strong>Status:</strong> <span class="fw-bold">{{ ucfirst($ploting->status) }}</span></p>
        <p><strong>Catatan:</strong> {{ $ploting->remarks ?? '-' }}</p>
    </div>

    <div class="mb-4">
        @if($ploting->status !== 'approved')
        <form action="{{ route('dekan.ploting.approve', $ploting->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="mb-2">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="remarks" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-success">Setujui</button>
        </form>
        @endif

        @if($ploting->status !== 'rejected')
        <form action="{{ route('dekan.ploting.reject', $ploting->id) }}" method="POST" onsubmit="return confirm('Tolak ploting ini?')">
            @csrf
            <div class="mb-2">
                <label class="form-label">Alasan penolakan (wajib)</label>
                <textarea name="remarks" class="form-control" rows="3" required></textarea>
            </div>
            <button class="btn btn-danger">Tolak & Kembalikan ke Kaprodi</button>
        </form>
        @endif
    </div>

    <a href="{{ route('dekan.ploting.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection