@extends('layouts.app')

@section('content')


<div class="content-area">
    <div class="container" style="max-width: 800px; margin-top:20px;">

        <div class="mb-4">
            <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Tambah Kelas Baru</h2>
            <p class="text-muted" style="font-size:14px;">Isi form di bawah untuk menambahkan pengaturan kelas</p>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4">
                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Kode Mata Kuliah</label>
                        <input type="text" name="kode" class="form-control form-control-lg @error('kode') is-invalid @enderror"
                            placeholder="Contoh: TI101" value="{{ old('kode') }}" required>
                        @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Mata Kuliah</label>
                        <input type="text" name="nama" class="form-control form-control-lg @error('nama') is-invalid @enderror"
                            placeholder="Contoh: Algoritma & Pemrograman" value="{{ old('nama') }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Jumlah Kelas</label>
                            <input type="number" name="jumlah_kelas" class="form-control form-control-lg @error('jumlah_kelas') is-invalid @enderror"
                                placeholder="3" value="{{ old('jumlah_kelas') }}" min="1" required>
                            @error('jumlah_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Kapasitas per Kelas</label>
                            <input type="number" name="kapasitas" class="form-control form-control-lg @error('kapasitas') is-invalid @enderror"
                                placeholder="40" value="{{ old('kapasitas') }}" min="1" required>
                            @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Kelas (pisahkan dengan koma)</label>
                        <input type="text" name="nama_kelas" class="form-control form-control-lg @error('nama_kelas') is-invalid @enderror"
                            placeholder="A, B, C atau Pagi, Siang, Malam" value="{{ old('nama_kelas') }}" required>
                        <small class="text-muted">Contoh: A, B, C atau Pagi, Siang, Malam</small>
                        @error('nama_kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Semester</label>
                        <select name="semester" class="form-select form-select-lg @error('semester') is-invalid @enderror">
                            <option value="">Pilih Semester</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                        </select>
                        @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                            rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lg rounded-pill" style="background: linear-gradient(135deg, #2d604a 0%, #1b5c2e 100%); border:none; color:white; font-weight:600;">
                            <i class="bi bi-save me-2"></i>Simpan Kelas
                        </button>
                        <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection