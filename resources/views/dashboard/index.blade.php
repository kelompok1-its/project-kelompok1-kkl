@extends('layouts.app')

@section('content')
@include('partials.role_dropdown')

<div class="content-area">
    <div style="margin-top:12px; margin-bottom:6px;">
        <h2 style="margin:0 0 12px 0; font-weight:600; color:#1f2937;">Dashboard Umum</h2>
    </div>

    <p>Selamat datang — pilih aktor (ikon pojok kanan atas) untuk melihat dashboard khusus per aktor.</p>

    <div class="stats" style="margin-top:18px;">
        <div class="card-stat">
            <h3>Jumlah Mata Kuliah</h3>
            <p>{{ $jumlah_mk ?? '-' }}</p>
        </div>
        <div class="card-stat">
            <h3>Kelas Aktif</h3>
            <p>{{ $kelas_aktif ?? '-' }}</p>
        </div>
        <div class="card-stat">
            <h3>Surat Keputusan</h3>
            <p>{{ $jumlah_sk ?? '-' }}</p>
        </div>
    </div>

    <div class="notif-box" style="margin-top:22px;">
        <h3>Notifikasi Terbaru</h3>
        <ul>
            <li>✅ Validasi Dekan telah disetujui untuk Semester Ganjil</li>
            <li>📅 Jadwal publikasi akan dilakukan pada 12 Oktober</li>
            <li>⚠️ 2 mata kuliah belum memiliki dosen pengampu</li>
        </ul>
    </div>
</div>
@endsection