@extends('layouts.app')

@section('content')
@include('partials.role_dropdown')

<div class="content-wrapper">
    <div class="header-title">Dashboard Kaprodi</div>

    <p style="margin-top:12px;">Halo Kaprodi — di sini Anda bisa membuat kuisioner, melihat hasil kuisioner, dan melakukan ploting dosen.</p>

    <div class="stats" style="margin-top:18px;">
        <div class="card-stat">
            <h3>Jumlah Mata Kuliah</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>
        <div class="card-stat">
            <h3>Dosen Tersedia</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>
        <div class="card-stat">
            <h3>Ploting Belum Selesai</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>
    </div>

    <div class="notif-box" style="margin-top:22px;">
        <h3>Tindakan Cepat</h3>
        <ul>
            <li>✉️ Kirim kuisioner ke dosen</li>
            <li>🧭 Mulai ploting otomatis/semi-otomatis</li>
            <li>🔁 Revisi ploting bila perlu</li>
        </ul>
    </div>
</div>
@endsection