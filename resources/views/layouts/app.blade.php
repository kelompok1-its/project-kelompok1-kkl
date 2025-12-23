<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title','SIAKAD Akademik')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Poppins -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">

    <style>
        /* === CORE LAYOUT === */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #0b1320;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            color: white;
            padding-top: 20px;
            box-sizing: border-box;
        }

        .sidebar h4 {
            text-align: left;
            margin: 0 0 20px 24px;
            font-weight: 700;
            font-size: 16px;
            color: #fff;
        }

        .sidebar nav {
            padding-top: 6px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #cbd5dc;
            text-decoration: none;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: #17202a;
            color: #fff;
        }

        /* MAIN CONTENT (to right of sidebar) */
        .main {
            margin-left: 220px;
            /* same as sidebar width */
            padding: 28px 32px;
            box-sizing: border-box;
            width: calc(100% - 220px);
            min-height: 100vh;
        }

        /* Centered content area with fixed max width so header and stats align */
        .content-inner {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        /* HEADER BAR (big green centered bar) */
        .header-bar {
            background: #dce8d8;
            border-radius: 10px;
            padding: 14px 20px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: #1b5c2e;
            position: relative;
            /* for profile icon to anchor inside */
        }

        /* small profile icon at right inside the header-bar */
        .profile-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .profile-icon svg {
            width: 18px;
            height: 18px;
        }

        /* === STATS LAYOUT (below header) === */
        .stats-row {
            display: flex;
            gap: 18px;
            margin-top: 22px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .stat-card {
            background: #e8f2ea;
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 6px 14px rgba(15, 23, 32, 0.04);
            text-align: center;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 15px;
            color: #2d3b34;
            font-weight: 600;
        }

        .stat-card p {
            margin: 16px 0 0 0;
            font-size: 26px;
            color: #124028;
            font-weight: 700;
        }

        /* Notification box full-width (within content-inner) */
        .notif-box {
            background: #fff;
            padding: 20px;
            margin-top: 26px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(15, 23, 32, 0.04);
        }

        .notif-box h3 {
            margin: 0 0 10px 0;
            color: #175b2e;
            font-weight: 700;
            font-size: 16px;
        }

        /* Dropdown (profile menu) */
        .profile-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            min-width: 220px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(16, 24, 40, 0.12);
            padding: 8px;
            display: none;
            z-index: 1200;
        }

        .profile-dropdown.show {
            display: block;
        }

        .profile-dropdown .role-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
        }

        .profile-dropdown .role-item:hover {
            background: #f3f7f3;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 64px;
            }

            .main {
                margin-left: 64px;
                width: calc(100% - 64px);
                padding: 16px;
            }

            .content-inner {
                padding: 0 6px;
            }

            .stat-card {
                width: 100%;
            }

            .header-bar {
                font-size: 18px;
                padding: 12px;
            }

            .profile-icon {
                right: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="app-shell">
        <aside class="sidebar">
            <h4>SIAKAD - Mandala</h4>
            <nav>
                <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>

                @php
                $role = session('current_role_slug', 'akademik');
                @endphp

                @if($role === 'akademik')
                {{-- Menu Akademik (Read-only SK) --}}
                <a href="{{ route('matakuliah.index') }}"><i class="bi bi-book"></i> Data Mata Kuliah</a>
                <a href="{{ route('kelas.index') }}"><i class="bi bi-people"></i> Jumlah Kelas</a>
                <a href="{{ route('sk_mengajar.index') }}"><i class="bi bi-journal-text"></i> Lihat SK</a>

                {{-- KAPRODI --}}
                @elseif($role === 'kaprodi')
                <a href="{{ route('kaprodi.kuisioner.index') }}"><i class="bi bi-clipboard-check"></i> <span>Kuisioner</span></a>
                <a href="{{ route('kaprodi.ploting.index') }}"><i class="bi bi-diagram-3"></i> <span>Ploting Dosen</span></a>
                <a href="{{ route('kaprodi.ploting.revisi.index') }}"><i class="bi bi-arrow-repeat"></i> <span>Revisi Ploting</span></a> <!-- Menu baru -->
                <a href="{{ route('matakuliah.index') }}"><i class="bi bi-book"></i> <span>Data MK</span></a>

                @elseif($role === 'dekan')
                {{-- Menu Dekan --}}
                <a href="{{ route('dekan.ploting.index') }}"><i class="bi bi-check-circle"></i> <span>Verifikasi Ploting</span></a>
                <a href="{{ route('dekan.approval.index') }}"><i class="bi bi-clipboard-check"></i> Approval</a>


                @elseif($role === 'wr1')
                {{-- Menu WR1 --}}
                <a href="{{ route('wr1.sk.index') }}">
                    <i class="bi bi-pen"></i> Generate SK
                </a>

                <a href="{{ route('wr1.approval.index') }}">
                    <i class="bi bi-shield-check"></i> Final Approval
                </a>

                <a href="#">
                    <i class="bi bi-file-earmark-pdf"></i> Publikasi
                </a>


                @elseif($role === 'dosen')
                {{-- Menu Dosen --}}
                <a href="{{ route('dosen.kuisioner.index') }}"><i class="bi bi-card-checklist"></i> Isi Kuisioner</a>
                <a href="#"><i class="bi bi-calendar-check"></i> Jadwal Mengajar</a>
                <a href="{{ route('sk_mengajar.index') }}"><i class="bi bi-file-earmark-pdf"></i> SK Saya</a>

                @endif

                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </nav>
        </aside>

        <main class="main">
            <div class="content-inner">

                @include('layouts.header') {{-- ← TOP BAR BERADA DI SINI --}}

                @yield('content')

            </div>
        </main>


        <script>
            // Click outside handler for dropdown (global)
            document.addEventListener('click', function(e) {
                const dd = document.querySelector('.profile-dropdown');
                const btn = document.querySelector('.profile-icon');
                if (!dd || !btn) return;
                if (!btn.contains(e.target) && !dd.contains(e.target)) {
                    dd.classList.remove('show');
                }
            });
        </script>
</body>

</html>