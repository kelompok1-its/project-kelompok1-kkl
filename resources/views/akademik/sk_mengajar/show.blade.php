@extends('layouts.app')

@section('content')
@include('partials.role_dropdown')

<div class="content-area">
    <div class="container" style="max-width: 900px; margin-top:20px;">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Detail SK Mengajar</h2>
                <p class="text-muted mb-0" style="font-size:14px;">Informasi lengkap Surat Keputusan Mengajar</p>
            </div>
            <div>
                <a href="{{ route('sk_mengajar.edit', $skMengajar) }}" class="btn btn-warning btn-sm rounded-pill px-3 me-2">
                    <i class="bi bi-pencil-square me-1"></i>Edit
                </a>
                <a href="{{ route('sk_mengajar.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>

        {{-- STATUS BADGE --}}
        <div class="mb-4">
            <span class="badge px-4 py-2 rounded-pill" style="font-size:14px; font-weight:600;
                @if($skMengajar->status == 'Draft') background-color: #e5e7eb; color: #4b5563;
                @elseif($skMengajar->status == 'Disetujui') background-color: #fef3c7; color: #92400e;
                @elseif($skMengajar->status == 'Ditandatangani') background-color: #d1fae5; color: #065f46;
                @else background-color: #fee2e2; color: #991b1b;
                @endif">
                {{ $skMengajar->status }}
            </span>
        </div>

        {{-- INFORMASI SK --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color:#1b5c2e; border-bottom: 2px solid #dce8d8; padding-bottom:10px;">
                    <i class="bi bi-file-earmark-text me-2"></i>Informasi SK
                </h5>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Nomor SK</label>
                            <div class="fw-semibold" style="font-size:15px; color:#1f2937;">{{ $skMengajar->nomor_sk }}</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Tahun Akademik</label>
                            <div class="fw-semibold" style="font-size:15px; color:#1f2937;">{{ $skMengajar->tahun_akademik }}</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Semester</label>
                            <div class="fw-semibold" style="font-size:15px; color:#1f2937;">{{ $skMengajar->semester }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Tanggal Terbit</label>
                            <div class="fw-semibold" style="font-size:15px; color:#1f2937;">
                                <i class="bi bi-calendar3 me-2" style="color:#2d604a;"></i>
                                {{ $skMengajar->tanggal_terbit->format('d F Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Dibuat</label>
                            <div class="fw-medium" style="font-size:14px; color:#6b7280;">
                                {{ $skMengajar->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DATA DOSEN & MATA KULIAH --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color:#1b5c2e; border-bottom: 2px solid #dce8d8; padding-bottom:10px;">
                    <i class="bi bi-person-badge me-2"></i>Data Pengampu
                </h5>

                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Nama Dosen</label>
                            <div class="fw-semibold" style="font-size:16px; color:#1f2937;">{{ $skMengajar->dosen_nama }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Mata Kuliah</label>
                            <div class="fw-semibold" style="font-size:15px; color:#1f2937;">{{ $skMengajar->mata_kuliah }}</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Kelas</label>
                            <div class="badge rounded-circle" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background-color: #e8f2ea; color: #2d604a; font-weight:700; font-size:16px;">
                                {{ $skMengajar->kelas }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Beban SKS</label>
                            <div class="fw-semibold" style="font-size:15px; color:#1f2937;">{{ $skMengajar->sks }} SKS</div>
                        </div>
                    </div>

                    @if($skMengajar->keterangan)
                    <div class="col-md-12">
                        <div class="detail-item">
                            <label class="text-muted d-block mb-1" style="font-size:13px; font-weight:500;">Keterangan</label>
                            <div class="p-3 rounded" style="background-color:#f9fafb; font-size:14px; color:#374151;">
                                {{ $skMengajar->keterangan }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- AKSI LANJUTAN --}}
        <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #e8f2ea 0%, #dce8d8 100%);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-1" style="color:#1b5c2e;">Aksi Lanjutan</h6>
                        <p class="text-muted mb-0" style="font-size:13px;">Kelola SK Mengajar ini</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm rounded-pill px-3" style="background:#2d604a; color:white;">
                            <i class="bi bi-printer me-1"></i>Cetak
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-file-pdf me-1"></i>Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .detail-item {
        padding: 8px 0;
    }
</style>

@endsection