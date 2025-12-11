@extends('layouts.app')

@section('content')

<div class="content-area" style="margin-top:18px;">
    <!-- Spacer (jarak dari header) -->
    <div style="height:6px"></div>

    <!-- Statistik (tiga kartu) -->
    <<div class="stats-row" aria-hidden="false">
        <div class="stat-card" role="region" aria-label="Jumlah Mata Kuliah">
            <h3>Jumlah Mata Kuliah</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="Kelas Aktif">
            <h3>Kelas Aktif</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>

        <div class="stat-card" role="region" aria-label="Surat Keputusan">
            <h3>Surat Keputusan</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>
</div>


<!-- Notifikasi / Aktivitas Akademik -->
<div class="notif-box" style="margin-top:26px;">
    <h3>Aktivitas Akademik</h3>
    <ul style="margin:10px 0 0 18px; color:#374151;">
        <li>👨‍🏫 Update kurikulum</li>
        <li>📝 Input mata kuliah baru</li>
        <li>📄 Generate SK mengajar setelah WR1 menyetujui</li>
    </ul>
</div>
</div>
@endsection