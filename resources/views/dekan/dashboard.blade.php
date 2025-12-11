@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <div class="header-title">Dashboard Dekan</div>

    <p style="margin-top:12px;">Halo Dekan — Anda bisa memeriksa ploting dari Kaprodi, memberikan persetujuan, atau mengembalikan untuk revisi.</p>

    <div class="stats" style="margin-top:18px;">
        <div class="card-stat">
            <h3>Ploting Menunggu</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>
        <div class="card-stat">
            <h3>SK Menunggu TTD</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>
        <div class="card-stat">
            <h3>Notifikasi</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>
    </div>

    <div class="notif-box" style="margin-top:22px;">
        <h3>Tindakan Dekan</h3>
        <ul>
            <li>🔎 Review ploting</li>
            <li>✅ Approve / Tolak ploting</li>
            <li>📬 Kirim revisi ke Kaprodi</li>
        </ul>
    </div>
</div>
@endsection