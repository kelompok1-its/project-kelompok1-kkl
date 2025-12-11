@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="text-center mb-4">
        <h3 class="fw-bold p-3 rounded" style="background:#d8e2d2;">
            Data Kelas – Akademik
        </h3>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('kelas.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari kelas / kode MK / nama MK..."
                        value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold p-2 rounded mb-3" style="background:#d8e2d2;">
                Daftar Kelas
            </h5>

            <table class="table table-hover align-middle">
                <thead style="background:#8db388; color:white;">
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Kode MK</th>
                        <th>Nama MK</th>
                        <th style="width:130px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kelas as $mk)
                    <tr>
                        <td>{{ $mk->kelas }}</td>
                        <td>{{ $mk->kode_mk }}</td>
                        <td>{{ $mk->nama_mk }}</td>

                        <td>
                            <a href="{{ route('kelas.edit', $mk->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('kelas.destroy', $mk->id) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus data kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data kelas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection