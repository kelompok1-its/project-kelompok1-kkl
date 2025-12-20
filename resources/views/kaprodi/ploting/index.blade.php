@extends('layouts.app')

@section('content')
<div class="card p-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Ploting Dosen</h4>
        <a href="{{ route('kaprodi.ploting.create') }}" class="btn btn-success">
            Tambah Ploting
        </a>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- FILTER --}}
    <form method="GET" class="mb-3">
        <div class="row g-2 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Dosen</label>
                <select name="dosen_id" class="form-control">
                    <option value="">Semua Dosen</option>
                    @foreach($dosens as $d)
                    <option value="{{ $d->id }}"
                        {{ request('dosen_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Mata Kuliah</label>
                <select name="matakuliah_id" class="form-control">
                    <option value="">Semua Mata Kuliah</option>
                    @foreach($matakuliahs as $m)
                    <option value="{{ $m->id }}"
                        {{ request('matakuliah_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->kode_mk }} - {{ $m->nama_mk }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Tahun Akademik</label>
                <input type="text"
                    name="tahun_akademik"
                    class="form-control"
                    placeholder="contoh: 2024/2025"
                    value="{{ request('tahun_akademik') }}">
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary w-100">
                    Filter
                </button>
            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Tahun Akademik</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse($plotings as $p)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration + ($plotings->currentPage() - 1) * $plotings->perPage() }}
                    </td>

                    <td>{{ $p->dosen->name ?? '-' }}</td>

                    <td>
                        {{ $p->matakuliah->kode_mk ?? '-' }} <br>
                        <small class="text-muted">
                            {{ $p->matakuliah->nama_mk ?? '-' }}
                        </small>
                    </td>

                    <td class="text-center">
                        {{ $p->kelas_id ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $p->semester ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $p->tahun_akademik ?? '-' }}
                    </td>

                    <td class="text-center">
                        @if($p->status == 'draft')
                        <span class="badge bg-secondary">Draft</span>
                        @elseif($p->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($p->status == 'approved')
                        <span class="badge bg-success">Disetujui</span>
                        @elseif($p->status == 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                        @else
                        <span class="badge bg-light text-dark">-</span>
                        @endif
                    </td>

                    <td class="text-center">
                        @if(in_array($p->status, ['draft', 'pending']))
                        <form action="{{ route('kaprodi.ploting.destroy', $p->id) }}" method="POST">


                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Belum ada data ploting
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $plotings->withQueryString()->links() }}
    </div>

</div>
@endsection