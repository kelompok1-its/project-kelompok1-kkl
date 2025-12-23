@extends('layouts.app')

@section('content')

<div class="content-area" style="margin-top:18px;">
    <!-- Spacer -->
    <div style="height:6px"></div>

    <!-- Statistik (tiga kartu) -->
    <div class="stats-row">
        <div class="stat-card" role="region" aria-label="Ploting Menunggu">
            <h3>Ploting Menunggu</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="Kelas Aktif">
            <h3>Kelas Aktif</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="SK Menunggu TTD">
            <h3>SK Menunggu TTD</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>
    </div>

    <!-- Notifikasi / Aktivitas Dekan -->
    <div class="notif-box" style="margin-top:26px;">
        <h3>Aktivitas Dekan</h3>
        <ul style="margin:10px 0 0 18px; color:#374151;">
            <li>🔎 Review ploting dari Kaprodi</li>
            <li>✅ Setujui atau tolak ploting</li>
            <li>📬 Kirim revisi ke Kaprodi</li>
        </ul>
    </div>
</div>

@endsection