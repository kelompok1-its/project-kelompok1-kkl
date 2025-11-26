<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD Akademik</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Poppins -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: #111827;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            color: white;
            padding-top: 20px;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 18px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: #374151;
            color: #fff;
        }

        .sidebar i {
            margin-right: 10px;
        }

        /* KONTEN KANAN */
        .content {
            margin-left: 250px;
            padding: 25px;
            min-height: 100vh;
        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4>SIAKAD - Akademik</h4>

        <a href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('matakuliah.index') }}">
            <i class="bi bi-book"></i> Data Mata Kuliah
        </a>

        <a href="#">
            <i class="bi bi-people"></i> Jumlah Kelas
        </a>

        <a href="#">
            <i class="bi bi-journal-text"></i> SK Mengajar
        </a>

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>


    <!-- KONTEN HALAMAN -->
    <div class="content">
        @yield('content')
    </div>

</body>

</html>