<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Akademik</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #204d3a, #2d604a);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1d3b2e;
        }

        .subtitle {
            font-size: 13px;
            color: #777;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .btn {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background: #204d3a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: #888;
        }

        a {
            text-decoration: none;
            color: #204d3a;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="title">Login Sistem Akademik</div>
        <div class="subtitle">Silakan masuk menggunakan akun Anda</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" name="email" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" class="btn">Masuk</button>
        </form>

        <div style="margin-top:15px;">
            Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </div>

        <div class="footer">© 2025 Sistem Akademik ITS Mandala</div>
    </div>

</body>

</html>