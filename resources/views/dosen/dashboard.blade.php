@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="header-title">Dashboard Dosen</div>

    <p style="margin-top:12px;">Halo Dosen — lengkapi kuisioner keahlian dan cek penugasan mengajar Anda di sini.</p>

    <div class="stats" style="margin-top:18px;">
        <div class="card-stat">
            <h3>Kuisioner Terkirim</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>
        <div class="card-stat">
            <h3>Pengampu Saat Ini</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>
        <div class="card-stat">
            <h3>SK Anda</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>
    </div>

    <div class="notif-box" style="margin-top:22px;">
        <h3>Aksi Dosen</h3>
        <ul>
            <li>📝 Isi / edit kuisioner sebelum deadline</li>
            <li>📋 Lihat hasil ploting setelah approval</li>
            <li>📥 Unduh SK mengajar</li>
        </ul>
    </div>
</div>
@endsection