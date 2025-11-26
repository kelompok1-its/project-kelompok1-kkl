@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- TITLE --}}
    <div class="text-center mb-4">
        <h3 class="fw-bold p-3 rounded" style="background:#d8e2d2;">
            Data Mata Kuliah – Akademik
        </h3>
    </div>

    {{-- FORM TAMBAH DATA --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <label class="fw-bold">Tahun</label>
                    <select class="form-select">
                        <option value="">Kurikulum</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Tambah Data Mata Kuliah</h5>

            <form action="{{ route('matakuliah.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-3">
                        <label>Kode MK</label>
                        <input type="text" name="kode_mk" class="form-control" placeholder="Misal: IF101" required>
                    </div>

                    <div class="col-md-4">
                        <label>Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" class="form-control" placeholder="Misal: Algoritma dan Pemrograman" required>
                    </div>

                    <div class="col-md-2">
                        <label>SKS</label>
                        <input type="number" name="sks" class="form-control" placeholder="3" required>
                    </div>

                    <div class="col-md-2">
                        <label>Semester</label>
                        <select name="semester" class="form-select" required>
                            <option value="">Pilih Semester</option>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn w-100"
                            style="background:#7cae7a; color:white;">
                            Simpan Mata Kuliah
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    {{-- TABLE DATA MATA KULIAH --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold p-2 rounded mb-3" style="background:#d8e2d2;">
                Data Mata Kuliah – Akademik
            </h5>

            <!-- Search -->
            <input type="text" class="form-control mb-3" placeholder="Cari mata kuliah...">

            <table class="table table-hover">
                <thead style="background:#8db388; color:white;">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($matakuliah as $mk)
                    <tr>
                        <td>{{ $mk->kode_mk }}</td>
                        <td>{{ $mk->nama_mk }}</td>
                        <td>{{ $mk->sks }}</td>
                        <td>{{ $mk->semester }}</td>
                        <td class="fw-bold" style="color: green;">
                            {{ $mk->status }}
                        </td>

                        <td>
                            <a href="{{ route('matakuliah.edit', $mk->id) }}" class="btn btn-success btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Hapus Mata Kuliah?')"
                                    class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada data mata kuliah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <small class="text-muted">
                Selamat sore! Silakan cari mata kuliah.
            </small>

        </div>
    </div>

</div>
@endsection