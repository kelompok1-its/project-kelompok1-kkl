@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Ploting Dosen — Sederhana</h3>
    <p class="text-muted">Pilih dosen untuk setiap mata kuliah. Gunakan "Save Draft" untuk menyimpan progres. Klik "Submit All" untuk mengirim ke Dekan.</p>

    <form id="bulk-submit-form" method="POST" action="{{ route('kaprodi.ploting.store') }}">
        @csrf

        <div class="mb-3">
            <button type="button" id="btn-mass-assign" class="btn btn-outline-primary btn-sm">Mass Assign</button>
            <button type="button" id="btn-save-draft" class="btn btn-secondary btn-sm">Save Draft (AJAX)</button>
            <button type="submit" class="btn btn-success btn-sm">Submit All ke Dekan</button>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width:40px"><input type="checkbox" id="check-all"></th>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Kelas (pisah koma jika >1)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matakuliahs as $m)
                @php
                $existingRow = isset($existing) ? $existing->firstWhere('matakuliah_id', $m->id) : null;
                @endphp
                <tr data-matkul-id="{{ $m->id }}">
                    <td>
                        <input type="checkbox"
                            class="row-check"
                            name="plotings[{{ $loop->index }}][selected]"
                            value="1">
                    </td>

                    <td>{{ $m->kode_mk }}</td>
                    <td>{{ $m->nama_mk }}</td>
                    <td>
                        <select name="plotings[{{ $loop->index }}][dosen_id]"
                            class="form-select form-select-sm dosen-select">
                            <option value="">-- pilih dosen --</option>
                            @foreach($dosens as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>

                        <input type="hidden"
                            name="plotings[{{ $loop->index }}][matakuliah_id]"
                            value="{{ $m->id }}">
                    </td>
                    <td>
                        <input type="text"
                            name="plotings[{{ $loop->index }}][kelas]"
                            class="form-control form-control-sm kelas-input"
                            placeholder="Contoh: 5SA,3RB">
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('check-all');
        const rowChecks = document.querySelectorAll('.row-check');
        checkAll?.addEventListener('change', function() {
            rowChecks.forEach(c => c.checked = this.checked);
        });

        // Mass assign button: pilih dosen untuk semua baris yang tercentang
        document.getElementById('btn-mass-assign').addEventListener('click', function() {
            const selectedRows = Array.from(document.querySelectorAll('tr[data-matkul-id]')).filter(r => r.querySelector('.row-check').checked);
            if (!selectedRows.length) {
                alert('Pilih minimal 1 baris.');
                return;
            }
            const dosenId = prompt('Masukkan ID dosen untuk assign (atau kosong untuk batal).');
            if (!dosenId) return;
            selectedRows.forEach(r => {
                const select = r.querySelector('.dosen-select');
                if (select) select.value = dosenId;
            });
        });

        // Save draft via AJAX: kumpulkan semua baris tercentang dan kirim per row
        document.getElementById('btn-save-draft').addEventListener('click', async function() {
            const rows = Array.from(document.querySelectorAll('tr[data-matkul-id]')).filter(r => r.querySelector('.row-check').checked);
            if (!rows.length) {
                alert('Pilih minimal 1 baris untuk disimpan draft.');
                return;
            }

            for (const r of rows) {
                const matkulId = r.dataset.matkulId;
                const dosenId = r.querySelector('.dosen-select').value;
                const kelas = r.querySelector('.kelas-input').value || '';
                if (!dosenId) continue; // skip yang belum ada dosen
                try {
                    const resp = await fetch("{{ route('kaprodi.ploting.save_draft') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            plot: {
                                matakuliah_id: matkulId,
                                dosen_id: dosenId,
                                kelas: kelas
                            }
                        })
                    });
                    const json = await resp.json();
                    // kamu bisa tunjukkan toast / alert per row atau kumpulkan hasil
                } catch (e) {
                    console.error(e);
                }
            }
            alert('Draft disimpan (untuk baris yang punya dosen).');
        });
    });
</script>
@endsection