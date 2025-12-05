@extends('layouts.app')

@section('content')

<div class="content-area">
    <div class="container" style="max-width: 800px; margin-top:20px;">

        <div class="mb-4">
            <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Edit Kelas</h2>
            <p class="text-muted" style="font-size:14px;">Perbarui data pengaturan kelas</p>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4">
                <form action="{{ route('kelas.update', $kelas) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Kode Mata Kuliah</label>
                        <input type="text" name="kode" class="form-control form-control-lg"
                            value="{{ $kelas->kode }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Mata Kuliah</label>
                        <input type="text" name="nama" class="form-control form-control-lg"
                            value="{{ $kelas->nama }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Jumlah Kelas</label>
                            <input type="number" name="jumlah_kelas" class="form-control form-control-lg"
                                value="{{ $kelas->jumlah_kelas }}" min="1" required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold" style="color:#1b5c2e;">Kapasitas per Kelas</label>
                            <input type="number" name="kapasitas" class="form-control form-control-lg"
                                value="{{ $kelas->kapasitas }}" min="1" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control form-control-lg"
                            value="{{ $kelas->nama_kelas }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Semester</label>
                        <select name="semester" class="form-select form-select-lg">
                            <option value="">Pilih Semester</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ $kelas->semester == $i ? 'selected' : '' }}>
                                Semester {{ $i }}
                                </option>
                                @endfor
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ $kelas->keterangan }}</textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lg rounded-pill" style="background: linear-gradient(135deg, #2d604a 0%, #1b5c2e 100%); border:none; color:white; font-weight:600;">
                            <i class="bi bi-save me-2"></i>Update Kelas
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