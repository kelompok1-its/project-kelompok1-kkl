<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title','SIAKAD Akademik')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Font --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
            margin: 0;
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 220px;
            background: #0b1320;
            position: fixed;
            height: 100vh;
            color: #fff;
            padding-top: 20px;
        }

        .sidebar h4 {
            margin-left: 22px;
            margin-bottom: 24px;
            font-weight: 700;
            font-size: 16px;
        }

        .sidebar a {
            display: block;
            padding: 12px 22px;
            color: #cbd5dc;
            text-decoration: none;
            font-size: 14px;
        }

        .sidebar a i {
            margin-right: 8px;
        }

        .sidebar a:hover {
            background: #17202a;
            color: #fff;
        }

        /* ===== MAIN ===== */
        .main {
            margin-left: 220px;
            padding: 28px 32px;
            width: calc(100% - 220px);
        }

        .content-inner {
            max-width: 1100px;
            margin: auto;
        }

        /* ===== HEADER BAR ===== */
        .header-bar {
            background: #dce8d8;
            border-radius: 10px;
            padding: 14px 20px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: #1b5c2e;
            position: relative;
        }

        .profile-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
        }

        /* ===== PROFILE DROPDOWN ===== */
        .profile-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            min-width: 220px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            padding: 8px;
            display: none;
            z-index: 999;
        }

        .profile-dropdown.show {
            display: block;
        }

        .profile-dropdown button {
            width: 100%;
            border: none;
            background: transparent;
            padding: 10px;
            text-align: left;
            border-radius: 6px;
        }

        .profile-dropdown button:hover {
            background: #f3f7f3;
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width: 900px) {
            .sidebar {
                width: 64px;
            }

            .sidebar h4 {
                display: none;
            }

            .sidebar a span {
                display: none;
            }

            .main {
                margin-left: 64px;
                width: calc(100% - 64px);
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="app-shell">

        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <h4>SIAKAD Mandala</h4>

            @php
            $role = session('current_role_slug', 'akademik');
            @endphp

            <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>

            {{-- AKADEMIK --}}
            @if($role === 'akademik')
            <a href="{{ route('matakuliah.index') }}"><i class="bi bi-book"></i> <span>Mata Kuliah</span></a>
            <a href="{{ route('kelas.index') }}"><i class="bi bi-people"></i> <span>Kelas</span></a>
            <a href="{{ route('sk_mengajar.index') }}"><i class="bi bi-journal-text"></i> <span>SK Mengajar</span></a>

            {{-- KAPRODI --}}
            @elseif($role === 'kaprodi')
            <a href="{{ route('kaprodi.kuisioner.index') }}"><i class="bi bi-clipboard-check"></i> <span>Kuisioner</span></a>
            <a href="#"><i class="bi bi-diagram-3"></i> <span>Ploting Dosen</span></a>
            <a href="{{ route('matakuliah.index') }}"><i class="bi bi-book"></i> <span>Data MK</span></a>

            {{-- DEKAN --}}
            @elseif($role === 'dekan')
            <a href="#"><i class="bi bi-check-circle"></i> <span>Verifikasi</span></a>
            <a href="#"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>

            {{-- WR1 --}}
            @elseif($role === 'wr1')
            <a href="{{ route('sk_mengajar.index') }}"><i class="bi bi-pen"></i> <span>Kelola SK</span></a>
            <a href="#"><i class="bi bi-shield-check"></i> <span>Final Approval</span></a>

            {{-- DOSEN --}}
            @elseif($role === 'dosen')
            <a href="{{ route('dosen.kuisioner.index') }}"><i class="bi bi-card-checklist"></i> <span>Isi Kuisioner</span></a>
            <a href="{{ route('sk_mengajar.index') }}"><i class="bi bi-file-earmark-pdf"></i> <span>SK Saya</span></a>
            @endif

            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </a>

            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form>
        </aside>

        {{-- MAIN --}}
        <main class="main">
            <div class="content-inner">

                {{-- HEADER --}}
                @include('layouts.header')

                {{-- PAGE CONTENT --}}
                @yield('content')

            </div>
        </main>

    </div>

    <script>
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.profile-dropdown');
            const btn = document.querySelector('.profile-icon');
            if (!dropdown || !btn) return;
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

</body>

</html>