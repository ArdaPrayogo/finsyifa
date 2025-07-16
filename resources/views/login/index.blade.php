<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/img/logo.ico" type="image/x-icon">
    <title>Login | Finsyifa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- Google Fonts: Lexend -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet" />

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Lexend', sans-serif;
        }

        .bg-overlay {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('/img/img_login.jpg') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            display: flex;
            gap: 3rem;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 2rem 3rem;
            border-radius: 20px;
            flex-wrap: wrap;
            max-width: 1000px;
            width: 100%;
        }

        .logo-area {
            text-align: center;
            flex: 1 1 300px;
        }

        .logo-area img {
            width: 300px;
            height: auto;
        }

        .logo-area h5 {
            color: #fff;
            margin-top: 1rem;
        }

        .visi-text {
            color: #f1f1f1;
            font-size: 14px;
            margin-top: 1rem;
            text-align: center;
            max-width: 300px;
            margin-inline: auto;
        }

        .login-box {
            padding: 2rem;
            border-radius: 16px;
            background-color: #ffffff;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            flex: 1 1 350px;
            max-width: 420px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #3b82f6;
        }

        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .brand {
            font-weight: 600;
            font-size: 24px;
            color: #3b82f6;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                padding: 1.5rem;
                gap: 2rem;
            }

            .visi-text {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-overlay">
        <div class="login-container">
            <!-- Kiri: Logo + Visi -->
            <div class="logo-area">
                <img src="/img/logo.png" alt="Logo RA Radlatul Athfal" />
                <h5>RA Raudlatul Athfal</h5>
                <p class="visi-text">
                    Menjadi lembaga pendidikan anak usia dini yang unggul dalam pembentukan karakter Islami, cerdas, dan
                    mandiri.
                </p>
            </div>

            <!-- Kanan: Login Box -->
            <div class="login-box bg-white">
                <div class="text-center mb-4">
                    <i class="bi bi-cash-coin fs-1 text-primary"></i>
                    <div class="brand">Finsyifa</div>
                    <div class="text-muted small">Sistem Keuangan RA Syifaul Qolbi</div>
                </div>

                <!-- Alerts -->
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="/login" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="name@example.com" required autofocus
                            value="{{ old('email') }}" />
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Password" required />
                        <label for="password">Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
