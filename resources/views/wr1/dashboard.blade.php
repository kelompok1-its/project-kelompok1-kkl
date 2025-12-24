@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Judul -->
    <h4 class="mb-3">Dashboard Wakil Rektor I – Final Approval SK</h4>
    <p class="text-muted">
        Halo WR1 — ini panel final approval dan penandatanganan SK.
        Pastikan distribusi beban mengajar sesuai kebijakan universitas.
    </p>

    <!-- Statistik -->
    <div class="row mt-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background:#eaf6ea">
                <div class="card-body text-center">
                    <h6 class="text-muted">Ploting Final</h6>
                    <h2 class="fw-bold">{{ $jumlah_mk }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background:#eaf6ea">
                <div class="card-body text-center">
                    <h6 class="text-muted">SK untuk Ditandatangani</h6>
                    <h2 class="fw-bold">{{ $kelas_aktif }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background:#eaf6ea">
                <div class="card-body text-center">
                    <h6 class="text-muted">Status Publikasi</h6>
                    <h2 class="fw-bold">{{ $jumlah_sk }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold text-success mb-3">Aktivitas Wakil Rektor I</h6>
            <ul class="mb-0">
                <li>✍️ Tanda tangan SK</li>
                <li>🔐 Finalisasi ploting</li>
                <li>📣 Publikasi SK</li>
            </ul>
        </div>
    </div>

</div>
@endsection
