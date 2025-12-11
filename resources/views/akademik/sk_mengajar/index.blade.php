@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="text-center mb-4">
        <h3 class="fw-bold p-3 rounded" style="background:#d8e2d2;">
            Data SK Mengajar – Akademik
        </h3>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold">Total SK: {{ $jumlah_sk }}</h5>
                <a href="{{ route('sk_mengajar.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah SK Baru
                </a>
            </div>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="input-group mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari SK...">
            </div>

            <table class="table table-hover">
                <thead style="background:#8db388; color:white;">
                    <tr>
                        <th>Nomor SK</th>
                        <th>Tahun</th>
                        <th>Semester</th>
                        <th>Dosen</th>
                        <th>Mata Kuliah</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($sk_mengajar as $sk)
                    <tr>
                        <td>{{ $sk->nomor_sk }}</td>
                        <td>{{ $sk->tahun_akademik }}</td>
                        <td>{{ $sk->semester }}</td>
                        <td>{{ $sk->dosen_nama }}</td>
                        <td>{{ $sk->mata_kuliah }}</td>
                        <td>{{ $sk->kelas }}</td>
                        <td>
                            <span class="badge 
                                @if($sk->status == 'Draft') bg-secondary
                                @elseif($sk->status == 'Disetujui') bg-warning
                                @elseif($sk->status == 'Ditandatangani') bg-success
                                @else bg-danger
                                @endif">
                                {{ $sk->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('sk_mengajar.show', $sk->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('sk_mengajar.edit', $sk->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('sk_mengajar.destroy', $sk->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus SK ini?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada data SK Mengajar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll("#tableBody tr");

        rows.forEach(row => {
            const match = row.textContent.toLowerCase().includes(keyword);
            row.style.display = match ? "" : "none";
        });
    });
</script>

@endsection