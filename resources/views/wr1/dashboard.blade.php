@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <div class="header-title">Dashboard Wakil Rektor I</div>

    <p style="margin-top:12px;">Halo WR1 — ini panel final approval dan penandatanganan SK. Pastikan distribusi beban mengajar sesuai kebijakan universitas.</p>

    <div class="stats" style="margin-top:18px;">
        <div class="card-stat">
            <h3>Ploting Final</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>
        <div class="card-stat">
            <h3>SK untuk Ditandatangani</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>
        <div class="card-stat">
            <h3>Status Publikasi</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>
    </div>

    <div class="notif-box" style="margin-top:22px;">
        <h3>Tindakan WR1</h3>
        <ul>
            <li>✍️ Tanda tangan SK</li>
            <li>🔐 Finalisasi ploting</li>
            <li>📣 Publikasi SK</li>
        </ul>
    </div>
</div>
@endsection