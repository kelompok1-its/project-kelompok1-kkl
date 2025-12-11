@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="fw-bold mb-4 p-3 rounded" style="background:#d8e2d2;">
        Edit Mata Kuliah
    </h3>

    <div class="card shadow-sm p-4">

        <form action="{{ route('matakuliah.update', $matakuliah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- KURIKULUM --}}
                <div class="col-md-3">
                    <label>Kurikulum</label>
                    <select name="kurikulum" class="form-select" required>
                        <option value="">Pilih Kurikulum</option>
                        <option value="2022" {{ $matakuliah->kurikulum == '2022' ? 'selected' : '' }}>Kurikulum 2022</option>
                        <option value="2023" {{ $matakuliah->kurikulum == '2023' ? 'selected' : '' }}>Kurikulum 2023</option>
                    </select>
                </div>

                {{-- KODE MK --}}
                <div class="col-md-3">
                    <label>Kode MK</label>
                    <input type="text" name="kode_mk" class="form-control" value="{{ $matakuliah->kode_mk }}" required>
                </div>

                {{-- NAMA MK --}}
                <div class="col-md-4">
                    <label>Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" class="form-control" value="{{ $matakuliah->nama_mk }}" required>
                </div>

                {{-- SKS --}}
                <div class="col-md-2">
                    <label>SKS</label>
                    <input type="number" name="sks" class="form-control" value="{{ $matakuliah->sks }}" required>
                </div>

                {{-- KELAS --}}
                <div class="col-md-3">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" value="{{ $matakuliah->kelas }}" placeholder="Contoh: RA-1 / SA-2" required>
                </div>

                {{-- FAKULTAS --}}
                <div class="col-md-4">
                    <label>Fakultas</label>
                    <select name="fakultas" class="form-select" id="fakultasSelect" required>
                        <option value="">Pilih Fakultas</option>
                        <option value="Fakultas Ekonomi dan Bisnis" {{ $matakuliah->fakultas == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                        <option value="Fakultas Sistem Teknologi dan Informasi" {{ $matakuliah->fakultas == 'Fakultas Sistem Teknologi dan Informasi' ? 'selected' : '' }}>Fakultas Sistem Teknologi dan Informasi</option>
                    </select>
                </div>

                {{-- PRODI --}}
                <div class="col-md-3">
                    <label>Program Studi</label>
                    <select name="prodi" class="form-select" id="prodiSelect" required>
                        <option value="">Pilih Prodi</option>
                    </select>
                </div>

                {{-- KODE PRODI --}}
                <div class="col-md-2">
                    <label>Kode Prodi</label>
                    <input type="text" name="kode_prodi" id="kodeProdi" class="form-control" value="{{ $matakuliah->kode_prodi }}" readonly required>
                </div>

                {{-- STATUS --}}
                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Aktif" {{ $matakuliah->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $matakuliah->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                {{-- BUTTON --}}
                <div class="col-12 mt-3">
                    <button class="btn btn-success w-100">Update Mata Kuliah</button>
                </div>

            </div>
        </form>

    </div>
</div>

{{-- SCRIPT: PRODI & KODE PRODI OTOMATIS --}}
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

    // Fungsi update dropdown prodi
    function updateProdi() {
        const fakultas = fakultasSelect.value;
        const currentProdi = "{{ $matakuliah->prodi }}";
        prodiSelect.innerHTML = '<option value="">Pilih Prodi</option>';

        if (dataProdi[fakultas]) {
            for (const prodi in dataProdi[fakultas]) {
                const option = document.createElement("option");
                option.value = prodi;
                option.textContent = prodi;
                if (prodi === currentProdi) option.selected = true;
                prodiSelect.appendChild(option);
            }

            kodeProdi.value = dataProdi[fakultas][currentProdi] || "";
        } else {
            kodeProdi.value = "";
        }
    }

    // Event saat fakultas berubah
    fakultasSelect.addEventListener("change", function() {
        const fakultas = this.value;
        prodiSelect.innerHTML = '<option value="">Pilih Prodi</option>';
        kodeProdi.value = "";
        if (dataProdi[fakultas]) {
            for (const prodi in dataProdi[fakultas]) {
                const option = document.createElement("option");
                option.value = prodi;
                option.textContent = prodi;
                prodiSelect.appendChild(option);
            }
        }
    });

    // Event saat prodi berubah → update kode_prodi
    prodiSelect.addEventListener("change", function() {
        const fakultas = fakultasSelect.value;
        const prodi = this.value;
        kodeProdi.value = (dataProdi[fakultas] && dataProdi[fakultas][prodi]) ? dataProdi[fakultas][prodi] : "";
    });

    // Trigger saat load page untuk set prodi & kode_prodi saat edit
    if (fakultasSelect.value) {
        updateProdi();
    }
</script>

@endsection