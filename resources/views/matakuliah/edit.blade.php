@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="fw-bold mb-4 p-3 rounded" style="background:#d8e2d2;">
        Edit Mata Kuliah
    </h3>

    <div class="card shadow-sm p-4">

        <form action="{{ route('matakuliah.update', $matakuliah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                
                <div class="col-md-3">
                    <label>Kode MK</label>
                    <input type="text" name="kode_mk" class="form-control" value="{{ $matakuliah->kode_mk }}">
                </div>

                <div class="col-md-4">
                    <label>Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" class="form-control" value="{{ $matakuliah->nama_mk }}">
                </div>

                <div class="col-md-2">
                    <label>SKS</label>
                    <input type="number" name="sks" class="form-control" value="{{ $matakuliah->sks }}">
                </div>

                <div class="col-md-2">
                    <label>Semester</label>
                    <select name="semester" class="form-select">
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" 
                                {{ $matakuliah->semester == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-1">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="Aktif" {{ $matakuliah->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $matakuliah->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-12 mt-3">
                    <button class="btn btn-success w-100">Update Mata Kuliah</button>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection
