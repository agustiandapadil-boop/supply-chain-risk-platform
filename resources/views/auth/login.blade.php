<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - SCRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{
            box-sizing:border-box;
        }

        body{
            height:100vh;
            margin:0;
            font-family:'Plus Jakarta Sans',sans-serif;
            background:#ffffff;
            overflow:hidden;
        }

        .login-container{
            display:flex;
            height:100vh;
            width:100%;
        }

        /* LEFT SIDE */
        .left-side{
            flex:1;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:40px;
            background:#fafafa;
        }

        .auth-wrapper{
            width:100%;
            max-width:400px;
        }

        .welcome-title{
            font-size:2.7rem;
            font-weight:800;
            color:#000;
            margin-bottom:8px;
            letter-spacing:.5px;
        }

        .welcome-subtitle{
            font-size:.95rem;
            color:#777;
            margin-bottom:35px;
        }

        .form-label{
            font-size:.9rem;
            font-weight:600;
            color:#111;
            margin-bottom:8px;
        }

        .form-control-custom{
            width:100%;
            height:48px;
            border:1px solid #e0e0e0;
            border-radius:12px;
            padding:12px 18px;
            font-size:.95rem;
            outline:none;
            box-shadow:0 2px 4px rgba(0,0,0,.02);
        }

        .form-control-custom:focus{
            border-color:#8e101b;
        }

        .form-control-custom::placeholder{
            color:#b8b8b8;
        }

        .form-options{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
            font-size:.88rem;
        }

        .remember-me{
            display:flex;
            align-items:center;
            gap:8px;
            color:#444;
            font-weight:500;
        }

        .remember-me input{
            width:16px;
            height:16px;
            accent-color:#8e101b;
        }

        .forgot-password{
            text-decoration:none;
            color:#111;
            font-weight:600;
        }

        .forgot-password:hover{
            text-decoration:underline;
        }

        .btn-signin{
            width:100%;
            height:48px;
            border:none;
            border-radius:12px;
            background:#8e101b;
            color:white;
            font-size:.95rem;
            font-weight:600;
            transition:.3s;
            box-shadow:0 4px 12px rgba(142,16,27,.25);
        }

        .btn-signin:hover{
            background:#a81422;
        }

        .btn-google{
            width:100%;
            height:48px;
            margin-top:15px;
            border:1px solid #e0e0e0;
            border-radius:12px;
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            font-size:.95rem;
            font-weight:600;
        }

        .btn-google:hover{
            background:#f8f8f8;
        }

        .btn-google img{
            width:20px;
            height:20px;
        }

        .footer-text{
            margin-top:25px;
            text-align:center;
            font-size:.88rem;
            color:#666;
        }

        .footer-text a{
            color:#8e101b;
            font-weight:600;
            text-decoration:none;
        }

        .footer-text a:hover{
            text-decoration:underline;
        }

        /* RIGHT SIDE */
        .right-side{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#ffffff;
            overflow:hidden;
        }

        .ship-image{
            width:170%;
            max-width:1350px;
            object-fit:contain;
            transform:translateX(40px);
        }

        @media(max-width:992px){

            body{
                overflow-y:auto;
            }

            .login-container{
                flex-direction:column;
                height:auto;
            }

            .right-side{
                display:none;
            }

            .left-side{
                height:100vh;
                padding:60px 20px;
            }

            .welcome-title{
                font-size:2.2rem;
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    <!-- LEFT -->
    <div class="left-side">

        <div class="auth-wrapper">

            <h1 class="welcome-title">
                WELCOME
            </h1>

            <p class="welcome-subtitle">
                Welcome USer.
            </p>

            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control-custom"
                        placeholder="Enter your email"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control-custom"
                        placeholder="********"
                        required>
                </div>

                <div class="form-options">

                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    <a href="/forgot-password" class="forgot-password">
                        Forgot password
                    </a>

                </div>

                <button type="submit" class="btn-signin">
                    Sign in
                </button>

                <div class="footer-text">
                    Don't have an account?
                    <a href="/register">
                        Sign up for free!
                    </a>
                </div>

            </form>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="right-side">

        <img
            src="{{ asset('img/login1.png') }}"
            alt="Ship"
            class="ship-image">

    </div>

</div>

</body>
</html>