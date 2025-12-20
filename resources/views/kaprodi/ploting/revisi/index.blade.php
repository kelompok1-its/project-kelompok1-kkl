@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Revisi Ploting</h3>
    <p class="text-muted">Lihat dan perbaiki revisi dari Dekan.</p>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="alert alert-warning">
        <strong>Revisi Diperlukan</strong><br>
        Terdapat {{ $plotings->count() }} revisi dari Dekan yang perlu diperbaiki.
    </div>

    @foreach($plotings as $ploting)
    <div class="card mb-3">
        <div class="card-body" style="background-color: #fff9e6;">
            <h5>Mata Kuliah: {{ $ploting->matakuliah->kode_mk }} - {{ $ploting->matakuliah->nama }} (Kelas {{ $ploting->kelas_id }})</h5>
            <p><strong>Catatan Dekan:</strong> {{ $ploting->catatan }}</p>

            <form method="POST" action="{{ route('kaprodi.ploting.revisi.update', $ploting->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="dosen_id" class="form-label">Dosen Pengganti</label>
                    <select name="dosen_id" id="dosen_id" class="form-select" required>
                        <option value="">-- Pilih Dosen Pengganti --</option>
                        @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" @if($ploting->dosen_id == $dosen->id) selected @endif>
                            {{ $dosen->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Simpan Perbaikan</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection