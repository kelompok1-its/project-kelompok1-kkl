@extends('layouts.app')

@section('content')
@include('partials.role_dropdown')

<div class="content-area">
    <div class="container" style="max-width: 900px; margin-top:20px;">

        <div class="mb-4">
            <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Edit SK Mengajar</h2>
            <p class="text-muted" style="font-size:14px;">Perbarui data Surat Keputusan Mengajar</p>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4">
                <form action="{{ route('sk_mengajar.update', $skMengajar) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Nomor SK</label>
                            <input type="text" name="nomor_sk" class="form-control form-control-lg @error('nomor_sk') is-invalid @enderror"
                                value="{{ old('nomor_sk', $skMengajar->nomor_sk) }}" required>
                            @error('nomor_sk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" class="form-control form-control-lg @error('tahun_akademik') is-invalid @enderror"
                                value="{{ old('tahun_akademik', $skMengajar->tahun_akademik) }}" placeholder="2024/2025" required>
                            @error('tahun_akademik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Semester</label>
                            <select name="semester" class="form-select form-select-lg @error('semester') is-invalid @enderror" required>
                                <option value="Ganjil" {{ old('semester', $skMengajar->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester', $skMengajar->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" class="form-control form-control-lg @error('tanggal_terbit') is-invalid @enderror"
                            value="{{ old('tanggal_terbit', $skMengajar->tanggal_terbit->format('Y-m-d')) }}" required>
                        @error('tanggal_terbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Dosen</label>
                        <input type="text" name="dosen_nama" class="form-control form-control-lg @error('dosen_nama') is-invalid @enderror"
                            value="{{ old('dosen_nama', $skMengajar->dosen_nama) }}" required>
                        @error('dosen_nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Mata Kuliah</label>
                            <input type="text" name="mata_kuliah" class="form-control form-control-lg @error('mata_kuliah') is-invalid @enderror"
                                value="{{ old('mata_kuliah', $skMengajar->mata_kuliah) }}" required>
                            @error('mata_kuliah')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Kelas</label>
                            <input type="text" name="kelas" class="form-control form-control-lg @error('kelas') is-invalid @enderror"
                                value="{{ old('kelas', $skMengajar->kelas) }}" required>
                            @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">SKS</label>
                            <input type="number" name="sks" class="form-control form-control-lg @error('sks') is-invalid @enderror"
                                value="{{ old('sks', $skMengajar->sks) }}" min="1" required>
                            @error('sks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Status</label>
                        <select name="status" class="form-select form-select-lg @error('status') is-invalid @enderror" required>
                            <option value="Draft" {{ old('status', $skMengajar->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Disetujui" {{ old('status', $skMengajar->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditandatangani" {{ old('status', $skMengajar->status) == 'Ditandatangani' ? 'selected' : '' }}>Ditandatangani</option>
                            <option value="Dibatalkan" {{ old('status', $skMengajar->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                            rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $skMengajar->keterangan) }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lg rounded-pill" style="background: linear-gradient(135deg, #2d604a 0%, #1b5c2e 100%); border:none; color:white; font-weight:600;">
                            <i class="bi bi-save me-2"></i>Update SK Mengajar
                        </button>
                        <a href="{{ route('sk_mengajar.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection