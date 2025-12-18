@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Approval (Dekan)</h4>
        <small class="text-muted">Pusat approval untuk semua entitas yang perlu persetujuan Dekan</small>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('dekan.ploting.index') }}" class="card text-decoration-none text-dark h-100">
                <div class="card-body">
                    <h5 class="card-title">Ploting Dosen</h5>
                    <p class="card-text">Verifikasi dan final approval untuk ploting yang dibuat Kaprodi.</p>
                    <span class="badge bg-warning text-dark">Pending: {{ $counts['ploting_pending'] ?? 0 }}</span>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('sk_mengajar.index') }}" class="card text-decoration-none text-dark h-100">
                <div class="card-body">
                    <h5 class="card-title">SK Mengajar</h5>
                    <p class="card-text">Approval SK Mengajar (jika proses approval ada pada modul ini).</p>
                    <span class="badge bg-warning text-dark">Pending: {{ $counts['sk_mengajar_pending'] ?? 0 }}</span>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Lainnya</h5>
                    <p class="card-text">Tambahkan entitas approval lain di sini (mis. laporan, cuti, dsb).</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">Kelola</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection