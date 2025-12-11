@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4 p-3 rounded" style="background:#d8e2d2;">
        Tambah SK Mengajar Baru
    </h3>

    <div class="card shadow-sm p-4">
        <form action="{{ route('sk_mengajar.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Nomor SK</label>
                    <input type="text" name="nomor_sk" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Tahun Akademik</label>
                    <input type="text" name="tahun_akademik" class="form-control" placeholder="2024/2025" required>
                </div>
                <div class="col-md-3">
                    <label>Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" class="form-control" required>
                </div>
                <div class="col-md-8">
                    <label>Nama Dosen</label>
                    <input type="text" name="dosen_nama" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Mata Kuliah</label>
                    <input type="text" name="mata_kuliah" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>SKS</label>
                    <input type="number" name="sks" class="form-control" required>
                </div>
                <div class="col-md-12">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="Draft">Draft</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditandatangani">Ditandatangani</option>
                    </select>
                </div>
                <div class="col-12">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-12 mt-3">
                    <button class="btn btn-success w-100">Simpan SK</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection