@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4 class="fw-bold">Tambah Ploting Dosen</h4>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('kaprodi.ploting.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Mata Kuliah</label>
            <select name="matakuliah_id" class="form-control" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach($matakuliahs as $m)
                <option value="{{ $m->id }}">{{ $m->nama ?? $m->title ?? $m->nama_matakuliah }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Pilih Dosen (boleh pilih lebih dari 1)</label>
            <select name="dosen_id[]" class="form-control" multiple size="8" required>
                @foreach($dosens as $d)
                <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->email ?? '-' }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Kelas (opsional)</label>
            <select name="kelas_id" class="form-control">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama ?? $k->kode ?? $k->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="row g-2 mb-3">
            <div class="col">
                <label>Semester</label>
                <input type="text" name="semester" class="form-control" placeholder="contoh: ganjil">
            </div>
            <div class="col">
                <label>Tahun Akademik</label>
                <input type="text" name="tahun_akademik" class="form-control" placeholder="contoh: 2024/2025">
            </div>
        </div>

        <button class="btn btn-success">Simpan Ploting</button>
        <a href="{{ route('kaprodi.ploting.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection