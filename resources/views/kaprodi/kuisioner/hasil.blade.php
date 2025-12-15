@extends('layouts.app')

@section('content')

<div class="card p-4">
    <h4 class="fw-bold">Hasil Kuisioner Dosen</h4>

    @foreach ($hasil as $p)
    <div class="border rounded p-3 mb-3">
        <h5>{{ $p->pertanyaan }}</h5>
        <ul>
            @forelse ($p->jawaban as $j)
            <li>{{ $j->jawaban }}</li>
            @empty
            <li class="text-muted">Belum ada jawaban.</li>
            @endforelse
        </ul>
    </div>
    @endforeach
</div>

@endsection