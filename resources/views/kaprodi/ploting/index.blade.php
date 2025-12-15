@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Ploting Dosen</h4>
        <a href="{{ route('kaprodi.ploting.create') }}" class="btn btn-success">Tambah Ploting</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-auto">
                <select name="dosen_id" class="form-control">
                    <option value="">Semua Dosen</option>
                    @foreach($dosens as $d)
                    <option value="{{ $d->id }}" @if(request('dosen_id')==$d->id) selected @endif>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <select name="matakuliah_id" class="form-control">
                    <option value="">Semua Mata Kuliah</option>
                    @foreach($matakuliahs as $m)
                    <option value="{{ $m->id }}" @if(request('matakuliah_id')==$m->id) selected @endif>{{ $m->nama ?? $m->title ?? $m->nama_matakuliah }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <input type="text" name="tahun_akademik" class="form-control" placeholder="Tahun akademik" value="{{ request('tahun_akademik') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Dosen</th>
                <th>Mata Kuliah</th>
                <th>Kelas</th>
                <th>Semester</th>
                <th>Tahun</th>
                <th>Ditambahkan Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plotings as $p)
            <tr>
                <td>{{ $loop->iteration + ($plotings->currentPage()-1)*$plotings->perPage() }}</td>
                <td>{{ $p->dosen->name ?? '—' }}</td>
                <td>{{ $p->matakuliah->nama ?? $p->matakuliah->title ?? $p->matakuliah_id }}</td>
                <td>{{ $p->kelas->nama ?? $p->kelas_id ?? '-' }}</td>
                <td>{{ $p->semester ?? '-' }}</td>
                <td>{{ $p->tahun_akademik ?? '-' }}</td>
                <td>{{ $p->created_by ?? '-' }}</td>
                <td>
                    <form action="{{ route('kaprodi.ploting.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus ploting ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Belum ada ploting.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $plotings->withQueryString()->links() }}
</div>
@endsection