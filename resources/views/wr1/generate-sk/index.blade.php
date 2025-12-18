@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Generate Surat Keputusan (WR1)</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prodi</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plotings as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->prodi->nama ?? '-' }}</td>
                        <td>{{ $p->matakuliah->nama ?? '-' }}</td>
                        <td>{{ $p->dosen->name ?? '-' }}</td>
                        <td>{{ $p->kelas->nama ?? '-' }}</td>
                        <td>
                            <form action="{{ route('wr1.sk.store', $p->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-primary">
                                    Generate SK
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Tidak ada data siap dibuat SK
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
