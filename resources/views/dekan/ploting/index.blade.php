@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Verifikasi Ploting Dosen (Dekan)</h4>
        <div>
            <a href="{{ route('dekan.ploting.index', ['status'=>'pending']) }}" class="btn btn-outline-secondary btn-sm">Pending</a>
            <a href="{{ route('dekan.ploting.index', ['status'=>'approved']) }}" class="btn btn-outline-success btn-sm">Approved</a>
            <a href="{{ route('dekan.ploting.index', ['status'=>'rejected']) }}" class="btn btn-outline-danger btn-sm">Rejected</a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <form method="GET" class="mb-3 row g-2">
        <div class="col-auto">
            <input class="form-control" name="tahun_akademik" placeholder="Tahun akademik" value="{{ request('tahun_akademik') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Ditambahkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plotings as $p)
                <tr>
                    <td>{{ $loop->iteration + ($plotings->currentPage()-1)*$plotings->perPage() }}</td>
                    <td>{{ $p->dosen->name ?? '-' }}</td>
                    <td>{{ $p->matakuliah->nama ?? $p->matakuliah_id }}</td>
                    <td>{{ $p->kelas->nama ?? $p->kelas_id ?? '-' }}</td>
                    <td>{{ $p->semester ?? '-' }}</td>
                    <td>{{ $p->tahun_akademik ?? '-' }}</td>
                    <td>
                        @if($p->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($p->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                        @elseif($p->status === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $p->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('dekan.ploting.show', $p->id) }}" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">Tidak ada ploting.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $plotings->withQueryString()->links() }}
</div>
@endsection