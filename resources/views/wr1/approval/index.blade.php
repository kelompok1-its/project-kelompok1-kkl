@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Final Approval (WR1)</h4>
        <small class="text-muted">Daftar ploting yang sudah disetujui Dekan dan menunggu final approval</small>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Prodi</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Final</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plotings as $p)
            <tr>
                <td>{{ $loop->iteration + ($plotings->currentPage()-1)*$plotings->perPage() }}</td>
                <td>{{ $p->prodi->nama ?? '-' }}</td>
                <td>{{ $p->matakuliah->nama ?? $p->matakuliah_id }}</td>
                <td>{{ $p->dosen->name ?? '-' }}</td>
                <td>{{ $p->kelas->nama ?? '-' }}</td>
                <td>{{ $p->status }}</td>
                <td>
                    @if($p->final_status === 'approved')
                        <span class="badge bg-success">Final Approved</span>
                    @elseif($p->final_status === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark">Waiting</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('wr1.approval.show', $p->id) }}" class="btn btn-sm btn-primary">Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8">Tidak ada ploting menunggu final approval.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{ $plotings->withQueryString()->links() }}
</div>
@endsection