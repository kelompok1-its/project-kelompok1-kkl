@extends('layouts.app')

@section('content')

<div class="content-area" style="margin-top:18px;">
    <!-- Spacer -->
    <div style="height:6px"></div>

    <!-- Statistik (tiga kartu) -->
    <div class="stats-row" aria-hidden="false">

        <div class="stat-card" role="region" aria-label="Ploting Final">
            <h3>Ploting Final</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="SK untuk Ditandatangani">
            <h3>SK untuk Ditandatangani</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="Status Publikasi">
            <h3>Status Publikasi</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>

    </div>

    <!-- Notifikasi / Aktivitas WR1 -->
    <div class="notif-box" style="margin-top:26px;">
        <h3>Tindakan WR1</h3>
        <ul style="margin:10px 0 0 18px; color:#374151;">
            <li>✍️ Tanda tangan SK</li>
            <li>🔐 Finalisasi ploting dosen</li>
            <li>📣 Publikasi SK</li>
        </ul>
    </div>
</div>

@endsection
