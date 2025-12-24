@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">Laporan Final Ploting Dosen (WR1)</h4>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Prodi</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Kelas</th>
                            <th>Status Final</th>
                            <th>Catatan WR1</th>
                            <th>Tanggal Keputusan</th>
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
                                    @if($p->final_status === 'approved')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($p->final_status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>{{ $p->final_remarks ?? '-' }}</td>
                                <td>
                                    {{ $p->final_at
                                        ? \Carbon\Carbon::parse($p->final_at)->format('d-m-Y')
                                        : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada data laporan
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
