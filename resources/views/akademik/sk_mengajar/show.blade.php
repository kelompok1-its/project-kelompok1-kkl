@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4>Detail SK - {{ $sk->nomor_sk }}</h4>

    <table class="table">
        <tr>
            <th>Nomor SK</th>
            <td>{{ $sk->nomor_sk }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ optional($sk->tanggal_sk)->format('d-m-Y') ?? '-' }}</td>
        </tr>
        <tr>
            <th>Mata Kuliah</th>
            <td>{{ optional($sk->ploting->matakuliah)->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dosen</th>
            <td>{{ optional($sk->ploting->dosen)->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ optional($sk->ploting->kelas)->nama ?? $sk->ploting->kelas ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status Dekan</th>
            <td>{{ $sk->status_dekan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status WR1</th>
            <td>{{ $sk->status_warek1 ?? '-' }}</td>
        </tr>
    </table>

    <a href="{{ route('sk_mengajar.download', $sk->id) }}" class="btn btn-primary">Download PDF</a>
    <a href="{{ route('sk_mengajar.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection