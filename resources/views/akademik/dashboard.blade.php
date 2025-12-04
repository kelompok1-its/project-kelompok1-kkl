@extends('layouts.app')

@section('content')
@include('partials.role_dropdown')

<div class="content-area">
    <p style="margin-top:12px;">Halo Akademik — Anda dapat mengelola kurikulum, input MK, dan generate SK di halaman ini.</p>

    <div class="stats" style="margin-top:18px;">
        <div class="card-stat">
            <h3>Jumlah Mata Kuliah</h3>
            <p>{{ $jumlah_mk }}</p>
        </div>
        <div class="card-stat">
            <h3>Kelas Aktif</h3>
            <p>{{ $kelas_aktif }}</p>
        </div>
        <div class="card-stat">
            <h3>Surat Keputusan</h3>
            <p>{{ $jumlah_sk }}</p>
        </div>
    </div>

    <div class="notif-box" style="margin-top:22px;">
        <h3>Aktivitas Akademik</h3>
        <ul>
            <li>👨‍🏫 Update kurikulum</li>
            <li>📝 Input mata kuliah baru</li>
            <li>📄 Generate SK mengajar setelah WR1 menyetujui</li>
        </ul>
    </div>
</div>
@endsection