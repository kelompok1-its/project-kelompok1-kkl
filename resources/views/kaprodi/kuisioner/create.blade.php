@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h4 class="fw-bold">Buat Kuisioner Dosen</h4>

    <form action="{{ route('kaprodi.kuisioner.store') }}" method="POST">
        @csrf

        <label>Judul Kuisioner</label>
        <input type="text" name="judul" class="form-control mb-3">

        <div id="pertanyaanList">
            <div class="mb-3">
                <label>Pertanyaan 1</label>
                <input type="text" name="pertanyaan[]" class="form-control">
            </div>
        </div>

        <button type="button" onclick="addQ()" class="btn btn-secondary mb-3">+ Pertanyaan</button>

        <button class="btn btn-success">Simpan Kuisioner</button>
    </form>
</div>

<script>
    function addQ() {
        let html = `
        <div class="mb-3">
            <label>Pertanyaan Baru</label>
            <input type="text" name="pertanyaan[]" class="form-control">
        </div>`;
        document.getElementById('pertanyaanList').insertAdjacentHTML('beforeend', html);
    }
</script>

@endsection