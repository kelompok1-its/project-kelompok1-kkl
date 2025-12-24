@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">Laporan Monitoring Ploting Dosen (Dekan)</h4>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Prodi</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Kelas</th>
                            <th>Status Dekan</th>
                            <th>Status WR1</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plotings as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->prodi->nama ?? '-' }}</td>
                                <td>{{ $p->matakuliah->nama ?? '-' }}</td>
                                <td>{{ $p->dosen->name ?? '-' }}</td>
                                <td>{{ $p->kelas->nama ?? '-' }}</td>
                                <td>
                                    @if($p->status === 'approved')
                                        <span class="badge bg-success">Disetujui Dekan</span>
                                    @elseif($p->status === 'rejected')
                                        <span class="badge bg-danger">Ditolak Dekan</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->final_status === 'approved')
                                        <span class="badge bg-success">Disetujui WR1</span>
                                    @elseif($p->final_status === 'rejected')
                                        <span class="badge bg-danger">Ditolak WR1</span>
                                    @else
                                        <span class="badge bg-secondary">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $p->final_remarks ?? $p->remarks ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
