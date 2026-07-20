<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Login - SCRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .left-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #fafafa; 
        }

        .auth-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .welcome-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #000000;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .welcome-subtitle {
            font-size: 0.95rem;
            color: #777777;
            margin-bottom: 35px;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            height: 48px;
            padding: 12px 20px;
            font-size: 0.95rem;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            background-color: #ffffff;
            color: #333333;
            outline: none;
            transition: border-color 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .form-control-custom:focus {
            border-color: #e63946;
        }

        .form-control-custom::placeholder {
            color: #b0b0b0;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.88rem;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #444444;
            font-weight: 500;
            cursor: pointer;
        }

        .remember-me input {
            accent-color: #e63946;
            width: 16px;
            height: 16px;
        }

        .forgot-password {
            color: #000000;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-signin {
            width: 100%;
            height: 48px;
            background-color: #8e101bff;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(230, 57, 70, 0.2);
        }

        .btn-signin:hover {
            background-color: #d62839;
        }

        .btn-google {
            width: 100%;
            height: 48px;
            background-color: #ffffff;
            color: #000000;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 30px;
        }

        .btn-google:hover {
            background-color: #f8f9fa;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }

        .footer-text {
            text-align: center;
            font-size: 0.88rem;
            color: #666666;
        }

        .footer-text a {
            color: #e63946;
            font-weight: 600;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        .right-side {
            flex: 1;
            background: url('/img/login1.png') no-repeat center center;
            background-size: cover;
        }

        @media (max-width: 992px) {
            body {
                overflow-y: auto;
            }
            .login-container {
                flex-direction: column;
                height: auto;
            }
            .right-side {
                display: none; 
            }
            .left-side {
                padding: 60px 20px;
                height: 100vh;
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    <div class="left-side">
        <div class="auth-wrapper">
            
            <h1 class="welcome-title">WELCOME</h1>
            <p class="welcome-subtitle">Admin.</p>

            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-4" style="font-size: 0.9rem; border-radius: 8px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/admin/login">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control-custom" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="/forgot-password" class="forgot-password">Forgot password</a>
                </div>

                <button type="submit" class="btn-signin">Sign in</button>
                
            </form>


        </div>
    </div>

    <div class="right-side"></div>

</div>

</body>
</html>