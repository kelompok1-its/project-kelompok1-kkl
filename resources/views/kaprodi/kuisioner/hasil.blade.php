@extends('layouts.app')

@section('content')

<div class="card p-4">
    <h4 class="fw-bold">Hasil Kuisioner Dosen</h4>

    <!-- Filter by judul -->
    <form method="GET" action="{{ route('kaprodi.kuisioner.hasil') }}" class="mb-3">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <select name="judul" class="form-select">
                    <option value="">-- Semua Judul --</option>
                    @foreach($juduls as $j)
                    <option value="{{ $j }}" {{ request('judul') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('kaprodi.kuisioner.hasil') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    @foreach ($hasil as $p)
    <div class="border rounded p-3 mb-3">
        <h5>{{ $p->pertanyaan }}</h5>
        <ul>
            @forelse ($p->jawaban as $j)
            <li>
                <strong>{{ optional($j->dosen)->name ?? 'Dosen tidak diketahui' }}:</strong>
                {{ $j->jawaban }}
            </li>
            @empty
            <li class="text-muted">Belum ada jawaban.</li>
            @endforelse
        </ul>
    </div>
    @endforeach
</div>

@endsection