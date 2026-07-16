<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register - SCRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: url('/img/background1.png') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            margin: 0;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .left-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5% 8%;
            position: relative;
            z-index: 2;
        }

        .left-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.15;
            color: #5c0616; 
            max-width: 600px;
            margin: 0;
        }

        .right-side {
            width: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            z-index: 2;
            margin-right: 40px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.92);
            border: 3px solid #5c0616;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .brand-title {
            color: #111;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            font-size: 1.1rem;
        }

        .input-group-custom .form-control {
            padding-left: 45px;
            height: 48px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: transparent;
        }

        .input-group-custom .form-control:focus {
            border-color: #5c0616;
            box-shadow: 0 0 0 0.25rem rgba(92, 6, 22, 0.15);
        }

        .btn-maroon {
            background: #8a1d2e;
            color: white;
            height: 48px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: background 0.2s ease;
        }

        .btn-maroon:hover {
            background: #5c0616;
            color: white;
        }

        .card-footer-text {
            text-align: center;
            font-size: 0.9rem;
            color: #555;
            margin-top: 25px;
        }

        .card-footer-text a {
            color: #8a1d2e;
            font-weight: 600;
            text-decoration: none;
        }

        .card-footer-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            body {
                flex-direction: column;
                overflow-y: auto;
                background-position: left center;
            }
            .left-side {
                padding: 40px 20px 20px 20px;
                align-items: center;
                text-align: center;
            }
            .left-content h1 {
                font-size: 2.5rem;
            }
            .right-side {
                width: 100%;
                padding: 20px;
                margin-right: 0;
                margin-bottom: 40px;
            }
        }
    </style>
</head>
<body>

<div class="left-side">
    <div class="left-content">
        <h1>Supply chain risk management</h1>
    </div>
</div>

<div class="right-side">
    <div class="auth-card">

        <div class="brand-title">
            Daftar Akun
        </div>

        <form method="POST" action="/register">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <div class="input-group-custom">
                    <i class="bi bi-person-vcard"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group-custom">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Alamat Email" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>

            <button class="btn btn-maroon w-100 d-flex align-items-center justify-content-center gap-2">
                Daftar <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <div class="card-footer-text">
            Sudah punya akun? <a href="/login">Masuk</a>
        </div>

    </div>
</div>

</body>
</html>