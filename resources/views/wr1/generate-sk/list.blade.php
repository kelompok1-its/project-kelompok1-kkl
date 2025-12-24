@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Daftar SK yang Sudah Dibuat</h4>
        <a href="{{ route('wr1.sk.index') }}" class="btn btn-outline-secondary btn-sm">Kembali ke Generate</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Prodi</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Kelas</th>
                    <th>Nomor SK</th>
                    <th>Tanggal</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sks as $i => $sk)
                <tr>
                    <td>{{ $sks->firstItem() + $i }}</td>
                    <td>{{ optional($sk->ploting->prodi)->nama ?? '-' }}</td>
                    <td>{{ optional($sk->ploting->matakuliah)->nama ?? optional($sk->ploting)->matakuliah_id ?? '-' }}</td>
                    <td>{{ optional($sk->ploting->dosen)->name ?? '-' }}</td>
                    <td>{{ optional($sk->ploting->kelas)->nama ?? $sk->ploting->kelas ?? $sk->ploting->kelas_id ?? '-' }}</td>
                    <td>{{ $sk->nomor_sk ?? '-' }}</td>
                    <td>{{ optional($sk->tanggal_sk)->format('d-m-Y') ?? optional($sk->created_at)->format('d-m-Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('sk.generate', $sk->id) }}" class="btn btn-sm btn-outline-primary">Download</a>
                            <a href="{{ route('sk_mengajar.show', $sk->id) ?? '#' }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Tidak ada SK.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>Menampilkan {{ $sks->firstItem() ?? 0 }} - {{ $sks->lastItem() ?? 0 }} dari {{ $sks->total() }} entri</div>
        <div>{{ $sks->withQueryString()->links() }}</div>
    </div>
</div>
@endsection