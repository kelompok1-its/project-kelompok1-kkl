@extends('layouts.app')

@section('content')

<div class="content-area">
    <div class="container" style="max-width: 800px; margin-top:20px;">

        <div class="mb-4">
            <h2 class="fw-bold mb-2" style="color:#1b5c2e;">Tambah Mata Kuliah Baru</h2>
            <p class="text-muted" style="font-size:14px;">Isi form berikut untuk menambahkan data mata kuliah</p>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4">

                <form action="{{ route('matakuliah.store') }}" method="POST">
                    @csrf

                    {{-- KURIKULUM --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Kurikulum</label>
                        <select name="kurikulum" class="form-select form-select-lg" required>
                            <option value="">Pilih Kurikulum</option>
                            <option value="2022">Kurikulum 2022</option>
                            <option value="2023">Kurikulum 2023</option>
                        </select>
                    </div>

                    {{-- KODE MK --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Kode Mata Kuliah</label>
                        <input type="text" name="kode_mk"
                            class="form-control form-control-lg"
                            placeholder="Contoh: IF101" required>
                    </div>

                    {{-- NAMA MK --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk"
                            class="form-control form-control-lg"
                            placeholder="Contoh: Algoritma dan Pemrograman"
                            required>
                    </div>

                    {{-- SKS --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">SKS</label>
                        <input type="number" name="sks"
                            class="form-control form-control-lg"
                            placeholder="3"
                            required>
                    </div>

                    {{-- SEMESTER --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Semester</label>
                        <select name="semester" class="form-select form-select-lg" required>
                            <option value="">Pilih Semester</option>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                        </select>
                    </div>


                    {{-- KELAS --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Kelas</label>
                        <input type="text" name="kelas"
                            class="form-control form-control-lg"
                            placeholder="Contoh: RA-1 / SA-2 / MA-3" required>
                    </div>

                    {{-- FAKULTAS --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Fakultas</label>
                        <select name="fakultas" class="form-select form-select-lg" id="fakultasSelect" required>
                            <option value="">Pilih Fakultas</option>
                            <option value="Fakultas Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                            <option value="Fakultas Sistem Teknologi dan Informasi">Fakultas Sistem Teknologi dan Informasi</option>
                        </select>
                    </div>

                    {{-- PRODI --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Program Studi</label>
                        <select name="prodi" class="form-select form-select-lg" id="prodiSelect" required>
                            <option value="">Pilih Prodi</option>
                        </select>
                    </div>

                    {{-- KODE PRODI --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Kode Prodi</label>
                        <input type="text" name="kode_prodi"
                            id="kodeProdi"
                            class="form-control form-control-lg"
                            placeholder="Otomatis berdasarkan prodi"
                            readonly required>
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#1b5c2e;">Status</label>
                        <select name="status" class="form-select form-select-lg">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-grid gap-2">
                        <button type="submit"
                            class="btn btn-lg rounded-pill"
                            style="background: linear-gradient(135deg, #2d604a 0%, #1b5c2e 100%); color:white; font-weight:600;">
                            Simpan Mata Kuliah
                        </button>

                        <a href="{{ route('matakuliah.index') }}"
                            class="btn btn-outline-secondary btn-lg rounded-pill">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

{{-- SCRIPT PRODI & KODE PRODI OTOMATIS --}}
<script>
    const fakultasSelect = document.getElementById("fakultasSelect");
    const prodiSelect = document.getElementById("prodiSelect");
    const kodeProdi = document.getElementById("kodeProdi");

    const dataProdi = {
        "Fakultas Ekonomi dan Bisnis": {
            "Keuangan dan Perbankan": "DA",
            "Magister Manajemen": "MM",
            "Ekonomi Pembangunan": "EA",
            "Akuntansi": "AA",
            "Manajemen": "MA"
        },
        "Fakultas Sistem Teknologi dan Informasi": {
            "Sistem & Teknologi Informasi": "SA",
            "Rekayasa Perangkat Lunak": "RA"
        }
    };

    fakultasSelect.addEventListener("change", function() {
        const selectedFakultas = this.value;
        prodiSelect.innerHTML = '<option value="">Pilih Prodi</option>';
        kodeProdi.value = "";

        if (selectedFakultas && dataProdi[selectedFakultas]) {
            for (const prodi in dataProdi[selectedFakultas]) {
                const option = document.createElement("option");
                option.value = prodi;
                option.textContent = prodi;
                prodiSelect.appendChild(option);
            }
        }
    });

    prodiSelect.addEventListener("change", function() {
        const fakultas = fakultasSelect.value;
        const prodi = this.value;

        if (dataProdi[fakultas] && dataProdi[fakultas][prodi]) {
            kodeProdi.value = dataProdi[fakultas][prodi];
        } else {
            kodeProdi.value = "";
        }
    });
</script>

@endsection