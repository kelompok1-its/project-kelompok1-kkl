@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f7f7f7;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }


    .menu a {
        display: block;
        padding: 12px 10px;
        margin: 8px 0;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
    }

    .menu a:hover {
        background: #333;
    }

    .content-wrapper {
        margin-left: 25px;
        padding: 25px;
    }

    .header-title {
        background: #dce8d8;
        padding: 15px;
        border-radius: 10px;
        font-size: 22px;
        text-align: center;
        font-weight: 600;
        color: #175b2e;
    }

    .stats {
        display: flex;
        gap: 20px;
        margin-top: 25px;
    }

    .card-stat {
        background: #e3efe1;
        padding: 25px;
        border-radius: 12px;
        width: 30%;
        text-align: center;
        box-shadow: 0 0 6px #ccc;
    }

    .card-stat h3 {
        margin: 0;
        font-size: 16px;
        color: #444;
        font-weight: 500;
    }

    .card-stat p {
        margin-top: 12px;
        font-size: 26px;
        font-weight: bold;
        color: #333;
    }

    .notif-box {
        background: white;
        padding: 25px;
        margin-top: 30px;
        border-radius: 12px;
        box-shadow: 0 0 10px #ddd;
    }

    .notif-box h3 {
        margin-bottom: 15px;
        font-size: 18px;
        color: #175b2e;
        font-weight: 600;
    }

    .notif-box ul {
        padding-left: 20px;
    }

    .notif-box ul li {
        margin-bottom: 8px;
        font-size: 14px;
    }
</style>

<!-- Main Content -->
<div class="content-wrapper">

    <div class="header-title">Dashboard Pengelolaan Mata Kuliah & Ploting Dosen</div>

    <!-- Stats -->
    <div class="stats">

        <div class="card-stat">
            <h3>Jumlah Mata Kuliah</h3>
            <p>{{ $jumlah_mk ?? 24 }}</p>
        </div>

        <div class="card-stat">
            <h3>Kelas Aktif</h3>
            <p>{{ $kelas_aktif ?? 12 }}</p>
        </div>

        <div class="card-stat">
            <h3>Surat Keputusan</h3>
            <p>{{ $jumlah_sk ?? 1 }}</p>
        </div>

    </div>

    <!-- Notification -->
    <div class="notif-box">
        <h3>Notifikasi Terbaru</h3>

        <ul>
            <li>✅ Validasi Dekan telah disetujui untuk Semester Ganjil</li>
            <li>📅 Jadwal publikasi akan dilakukan pada 12 Oktober</li>
            <li>⚠️ 2 mata kuliah belum memiliki dosen pengampu</li>
        </ul>
    </div>

</div>

@endsection