@extends('layouts.app')

@section('content')

<div class="content-area" style="margin-top:18px;">
    <!-- Spacer -->
    <div style="height:6px"></div>

    <!-- Statistik (tiga kartu) -->
    <div class="stats-row" aria-hidden="false">

        <div class="stat-card" role="region" aria-label="Jumlah Mata Kuliah">
            <h3>Jumlah Mata Kuliah</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="Dosen Tersedia">
            <h3>Dosen Tersedia</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="Ploting Belum Selesai">
            <h3>Ploting Belum Selesai</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>

    </div>

    <!-- Notifikasi / Aktivitas Kaprodi -->
    <div class="notif-box" style="margin-top:26px;">
        <h3>Tindakan Cepat</h3>
        <ul style="margin:10px 0 0 18px; color:#374151;">
            <li>📋 Buat & kirim kuisioner ke dosen</li>
            <li>📌 Lakukan ploting dosen</li>
            <li>🔁 Revisi ploting yang ditolak Dekan / WR1</li>
        </ul>
    </div>
</div>

@endsection