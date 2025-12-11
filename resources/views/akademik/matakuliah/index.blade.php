@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4" style="margin-top:12px;">
        <div>
            <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Manajemen Mata Kuliah</h2>
            <p class="text-muted mb-0" style="font-size:14px;">Kelola data mata kuliah untuk keperluan akademik</p>
        </div>

        <a href="{{ route('matakuliah.create') }}"
            class="btn px-4 py-2 rounded-pill shadow-sm"
            style="background: linear-gradient(135deg, #2d604a 0%, #1b5c2e 100%); border:none; color:white; font-weight:600;">
            <i class="bi bi-plus-circle me-2"></i>Tambah Mata Kuliah
        </a>
    </div>


    {{-- TABLE DATA --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold p-2 rounded mb-3" style="background:#d8e2d2;">
                Data Mata Kuliah – Akademik
            </h5>

            {{-- SEARCH + VOICE --}}
            <div class="input-group mb-3" style="max-width: 400px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari mata kuliah..." autocomplete="off">

                <button class="btn btn-outline-secondary" type="button" id="voiceBtn">
                    <i class="bi bi-mic-fill" style="font-size:1.2rem;"></i>
                </button>
            </div>

            {{-- TABLE --}}
            <table class="table table-hover">
                <thead style="background:#8db388; color:white;">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Kelas</th>
                        <th>Fakultas</th>
                        <th>Prodi</th>
                        <th>Status</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @forelse($matakuliah as $mk)
                    <tr>
                        <td>{{ $mk->kode_mk }}</td>
                        <td>{{ $mk->nama_mk }}</td>
                        <td>{{ $mk->sks }}</td>
                        <td>{{ $mk->kelas }}</td>
                        <td>{{ $mk->fakultas }}</td>
                        <td>{{ $mk->prodi }}</td>
                        <td class="fw-bold" style="color: green;">{{ $mk->status }}</td>

                        <td>
                            <a href="{{ route('matakuliah.edit', $mk->id) }}"
                                class="btn btn-success btn-sm">Edit</a>

                            <form action="{{ route('matakuliah.destroy', $mk->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus Mata Kuliah?')"
                                    class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Belum ada data mata kuliah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="noResultAlert" class="alert alert-warning mt-2" style="display:none;">
                Mata kuliah tidak ditemukan.
            </div>

        </div>
    </div>

</div>

{{-- =====================================================
     SCRIPT : Voice Search + Filter
===================================================== --}}
<script>
    const searchInput = document.getElementById("searchInput");
    const voiceBtn = document.getElementById("voiceBtn");
    const noResultAlert = document.getElementById("noResultAlert");

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (SpeechRecognition) {
        const recognition = new SpeechRecognition();
        recognition.lang = "id-ID";
        recognition.continuous = false;

        voiceBtn.onclick = () => {
            recognition.start();
            voiceBtn.innerHTML = '<i class="bi bi-mic-mute-fill" style="font-size:1.2rem; color:red;"></i>';
        };

        recognition.onresult = event => {
            const text = event.results[0][0].transcript;
            searchInput.value = text;
            filterTable();
        };

        recognition.onerror = () => {
            alert("Gagal mengenali suara. Coba lagi.");
        };

        recognition.onend = () => {
            voiceBtn.innerHTML = '<i class="bi bi-mic-fill" style="font-size:1.2rem;"></i>';
        };

    } else {
        voiceBtn.disabled = true;
        voiceBtn.title = "Browser tidak mendukung Voice Recognition";
    }

    searchInput.addEventListener("input", filterTable);

    function filterTable() {
        const keyword = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("table tbody tr");
        let visibleCount = 0;

        rows.forEach(row => {
            const match = row.textContent.toLowerCase().includes(keyword);
            row.style.display = match ? "" : "none";
            if (match) visibleCount++;
        });

        noResultAlert.style.display = (visibleCount === 0) ? "block" : "none";
    }
</script>

@endsection