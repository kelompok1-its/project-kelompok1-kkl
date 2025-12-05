@extends('layouts.app')

@section('content')


<div class="content-area">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4" style="margin-top:12px;">
        <div>
            <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Pengaturan Jumlah Kelas</h2>
            <p class="text-muted mb-0" style="font-size:14px;">Tentukan jumlah kelas untuk setiap mata kuliah</p>
        </div>
        <a href="{{ route('kelas.create') }}" class="btn px-4 py-2 rounded-pill shadow-sm"
            style="background: linear-gradient(135deg, #2d604a 0%, #1b5c2e 100%); border:none; color:white; font-weight:600;">
            <i class="bi bi-people-fill me-2"></i>Tambah Kelas
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #10b981; background-color:#d1fae5; color:#065f46;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead style="background-color: #dce8d8; border-bottom: 2px solid #c5d9bd;">
                        <tr>
                            <th class="px-4 py-3" style="font-weight:600; color:#1b5c2e; font-size:14px;">Mata Kuliah</th>
                            <th class="px-4 py-3 text-center" style="font-weight:600; color:#1b5c2e; font-size:14px;">Jumlah Kelas</th>
                            <th class="px-4 py-3 text-center" style="font-weight:600; color:#1b5c2e; font-size:14px;">Nama Kelas</th>
                            <th class="px-4 py-3 text-center" style="font-weight:600; color:#1b5c2e; font-size:14px;">Kapasitas/Kelas</th>
                            <th class="px-4 py-3 text-center" style="font-weight:600; color:#1b5c2e; font-size:14px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $k)
                        <tr style="border-bottom: 1px solid #f1f3f5;">
                            <td class="px-4 py-4">
                                <span class="fw-medium" style="color:#1f2937;">{{ $k->kode }} - {{ $k->nama }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #c5d9bd; color: #1b5c2e; font-weight:600; font-size:13px;">
                                    {{ $k->jumlah_kelas ?? 0 }} Kelas
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    @php
                                    $namaKelas = !empty($k->nama_kelas) ? explode(',', $k->nama_kelas) : [];
                                    @endphp
                                    @if(count($namaKelas) > 0)
                                    @foreach($namaKelas as $nama)
                                    <span class="badge rounded-circle"
                                        style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; 
                                                         background-color: #e8f2ea; color: #2d604a; font-weight:600; font-size:13px;">
                                        {{ trim($nama) }}
                                    </span>
                                    @endforeach
                                    @else
                                    <span class="text-muted" style="font-size:13px;">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span style="color:#1f2937; font-weight:500;">{{ $k->kapasitas }} mhs</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #d1fae5; color: #065f46; font-weight:600; font-size:13px;">
                                    {{ ($k->kapasitas ?? 0) * ($k->jumlah_kelas ?? 0) }} mhs
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('kelas.edit', $k) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 me-2"
                                    style="font-size:13px; font-weight:500; color:#2d604a; border-color:#7cae7a;">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <form action="{{ route('kelas.destroy', $k) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        style="font-size:13px; font-weight:500;">
                                        <i class="bi bi-trash3 me-1"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity:0.3;"></i>
                                    <p class="mt-3 mb-0">Belum ada data kelas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8fdf9;
        transition: all 0.2s ease;
    }

    .btn-outline-success:hover {
        background-color: #2d604a !important;
        border-color: #2d604a !important;
        color: white !important;
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .badge {
        font-weight: 600 !important;
        letter-spacing: 0.3px;
    }

    .card {
        transition: box-shadow 0.3s ease;
    }
</style>

@endsection