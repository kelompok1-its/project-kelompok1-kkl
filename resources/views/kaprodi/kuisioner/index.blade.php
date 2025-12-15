@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4 class="fw-bold">Daftar Pertanyaan (Kaprodi)</h4>

    <p><a href="{{ route('kaprodi.kuisioner.create') }}" class="btn btn-sm btn-success">Buat Kuisioner Baru</a>
        <a href="{{ route('kaprodi.kuisioner.hasil') }}" class="btn btn-sm btn-primary">Lihat Semua Hasil</a>
    </p>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(isset($kuisioner) && (count($kuisioner) > 0))
    <h5>Debug list (mentah):</h5>
    <ul>
        @foreach($kuisioner as $item)
        <li>
            <strong>Judul:</strong> {{ $item->judul ?? '(null)' }} |
            <strong>Pertanyaan:</strong> {{ $item->pertanyaan ?? '(kosong)' }} |
            <small>{{ $item->created_at }}</small>
        </li>
        @endforeach
    </ul>
    @else
    <p>Tidak ada pertanyaan.</p>
    @endif
</div>
@endsection