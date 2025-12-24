@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Ploting Dosen</h4>
        <a href="{{ route('kaprodi.ploting.create') }}" class="btn btn-success">Tambah Ploting</a>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('kaprodi.ploting.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <select name="dosen_id" class="form-select">
                    <option value="">Semua Dosen</option>
                    @foreach($dosens as $d)
                    <option value="{{ $d->id }}" {{ request('dosen_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="matakuliah_id" class="form-select">
                    <option value="">Semua Mata Kuliah</option>
                    @foreach($matakuliahs as $m)
                    <option value="{{ $m->id }}" {{ request('matakuliah_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->kode_mk ?? $m->nama ?? $m->id }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="text" name="tahun_akademik" class="form-control" placeholder="contoh: 2024/2025"
                    value="{{ request('tahun_akademik') }}">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('kaprodi.ploting.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Tahun Akademik</th>
                    <th>Status</th>
                    <th style="width:180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plotings as $i => $ploting)
                @php
                if (!empty($ploting->final_status)) {
                if ($ploting->final_status === 'rejected' || $ploting->final_status === 'ditolak') {
                $badgeText = 'Ditolak WR1';
                $badgeClass = 'danger';
                } elseif ($ploting->final_status === 'approved') {
                $badgeText = 'Disetujui WR1';
                $badgeClass = 'success';
                } else {
                $badgeText = ucfirst($ploting->final_status);
                $badgeClass = 'secondary';
                }
                } else {
                switch ($ploting->status) {
                case 'pending':
                $badgeText = 'Pending';
                $badgeClass = 'warning';
                break;
                case 'approved':
                case 'disetujui_dekan':
                $badgeText = 'Disetujui';
                $badgeClass = 'success';
                break;
                case 'revisi':
                $badgeText = 'Revisi Kaprodi';
                $badgeClass = 'info';
                break;
                case 'draft':
                $badgeText = 'Draft';
                $badgeClass = 'secondary';
                break;
                default:
                $badgeText = ucfirst($ploting->status ?? 'Unknown');
                $badgeClass = 'secondary';
                }
                }
                @endphp
                <tr>
                    <td>{{ $plotings->firstItem() + $i }}</td>
                    <td>{{ optional($ploting->dosen)->name ?? '—' }}</td>
                    <td>
                        <strong>{{ optional($ploting->matakuliah)->kode_mk ?? '-' }}</strong><br>
                        <small class="text-muted">{{ optional($ploting->matakuliah)->nama ?? '-' }}</small>
                    </td>

                    <!-- KELAS: prioritas tampilkan relasi kelas->nama, lalu kolom kelas (string), lalu kelas_id -->
                    <td>
                        @if(optional($ploting->kelas)->nama)
                        {{ $ploting->kelas->nama }}
                        @elseif(!empty($ploting->kelas))
                        {{ $ploting->kelas }}
                        @elseif(!empty($ploting->kelas_id))
                        {{-- tampilkan nama relasi jika tersedia, atau id sebagai fallback --}}
                        {{ optional($ploting->kelas)->nama ?? $ploting->kelas_id }}
                        @else
                        -
                        @endif
                    </td>

                    <td>{{ $ploting->semester ?? '-' }}</td>
                    <td>{{ $ploting->tahun_akademik ?? '-' }}</td>
                    <td><span class="badge bg-{{ $badgeClass }}">{{ $badgeText }}</span></td>

                    <td>
                        <div class="d-flex gap-2">
                            {{-- Tombol Hapus untuk draft/pending --}}
                            @if(in_array($ploting->status, ['draft','pending']))
                            <form action="{{ route('kaprodi.ploting.destroy', $ploting->id) }}" method="POST" onsubmit="return confirm('Hapus ploting ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                            </form>
                            @endif

                            {{-- Jika ploting status = revisi atau final_status = rejected: tampilkan Revisi + Hapus --}}
                            @if($ploting->status === 'revisi' || in_array($ploting->final_status, ['rejected','ditolak']))
                            <a href="{{ route('kaprodi.ploting.revisi.index') }}" class="btn btn-sm btn-outline-primary">Revisi</a>

                            {{-- Hapus juga muncul untuk opsi penghapusan revisi/ditolak --}}
                            <form action="{{ route('kaprodi.ploting.destroy', $ploting->id) }}" method="POST" onsubmit="return confirm('Hapus ploting yang ditolak/revisi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                            </form>
                            @endif

                            {{-- Detail jika ada --}}
                            @if (Route::has('kaprodi.ploting.show'))
                            <a href="{{ route('kaprodi.ploting.show', $ploting->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Tidak ada data ploting.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Menampilkan {{ $plotings->firstItem() ?? 0 }} - {{ $plotings->lastItem() ?? 0 }} dari {{ $plotings->total() }} entri
        </div>
        <div>
            {{ $plotings->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection