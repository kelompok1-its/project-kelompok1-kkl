@extends('layouts.app')

@section('content')

<div class="content-area">
    <div class="container" style="max-width: 800px; margin-top:20px;">

        <div class="mb-4">
            <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Edit Kelas</h2>
            <p class="text-muted" style="font-size:14px;">Perbarui data kelas yang terhubung dengan mata kuliah</p>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4">
                <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- KODE MK --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Kode Mata Kuliah</label>
                        <input type="text" name="kode_mk" 
                               class="form-control form-control-lg"
                               value="{{ $kelas->kode_mk }}" required>
                    </div>

                    {{-- NAMA MK --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" 
                               class="form-control form-control-lg"
                               value="{{ $kelas->nama_mk }}" required>
                    </div>

                    {{-- NAMA KELAS --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Kelas</label>
                        <input type="text" name="kelas"
                               class="form-control form-control-lg"
                               value="{{ $kelas->kelas }}" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" 
                                class="btn btn-lg rounded-pill" 
                                style="background: linear-gradient(135deg, #2d604a 0%, #1b5c2e 100%); border:none; color:white; font-weight:600;">
                            <i class="bi bi-save me-2"></i>Update Kelas
                        </button>

                        <a href="{{ route('kelas.index') }}" 
                           class="btn btn-outline-secondary btn-lg rounded-pill">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection
