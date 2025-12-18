@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4 class="fw-bold mb-3">Tambah Ploting Dosen</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('kaprodi.ploting.store') }}">
        @csrf

        {{-- DOSEN --}}
        <div class="mb-3">
            <label class="form-label">Dosen</label>
            <select name="dosen_id" class="form-control" required>
                <option value="">-- Pilih Dosen --</option>
                @foreach($dosens as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- MATA KULIAH --}}
        <div class="mb-3">
            <label class="form-label">Mata Kuliah</label>
            <select name="matakuliah_id" class="form-control" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach($matakuliahs as $m)
                <option value="{{ $m->id }}">
                    {{ $m->kode_mk ?? '-' }} - {{ $m->nama_mk ?? $m->nama }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- KELAS --}}
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <input type="text"
                name="kelas_id"
                class="form-control"
                placeholder="Contoh: A / B / A,B"
                required>
        </div>

        {{-- SEMESTER --}}
        <div class="mb-3">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-control" required>
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>

        {{-- TAHUN AKADEMIK --}}
        <div class="mb-3">
            <label class="form-label">Tahun Akademik</label>
            <input type="text"
                name="tahun_akademik"
                class="form-control"
                placeholder="Contoh: 2024/2025"
                required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Simpan & Kirim ke Dekan
            </button>
            <a href="{{ route('kaprodi.ploting.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection