@extends('layouts.app')

@section('content')

<div class="card p-4">
    <h4 class="fw-bold">Isi Kuisioner Dosen</h4>

    <form action="{{ route('dosen.kuisioner.jawab') }}" method="POST">
        @csrf

        @foreach ($pertanyaan as $p)
        <div class="mb-3">
            <label class="fw-bold">{{ $p->pertanyaan }}</label>
            <textarea name="jawaban[{{ $p->id }}]" class="form-control"></textarea>
        </div>
        @endforeach

        <button class="btn btn-primary">Kirim Jawaban</button>
    </form>

</div>

@endsection