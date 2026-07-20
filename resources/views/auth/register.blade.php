<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register - SCRM</title>
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

        .register-container{
            display:flex;
            width:100%;
            height:100vh;
        }
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
            font-size:2.5rem;
            font-weight:800;
            color:#000;
            margin-bottom:8px;
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
            padding:12px 18px;
            border:1px solid #e0e0e0;
            border-radius:12px;
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

        .btn-register{
            width:100%;
            height:48px;
            border:none;
            border-radius:12px;
            background:#8e101b;
            color:#fff;
            font-size:.95rem;
            font-weight:600;
            margin-top:10px;
            transition:.3s;
            box-shadow:0 4px 12px rgba(142,16,27,.25);
        }

        .btn-register:hover{
            background:#a81422;
        }

        .footer-text{
            text-align:center;
            margin-top:25px;
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

        .right-side{
            flex:1;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            background:#fff;
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

            .register-container{
                flex-direction:column;
            }

            .right-side{
                display:none;
            }

            .left-side{
                height:100vh;
                padding:60px 20px;
            }

            .welcome-title{
                font-size:2rem;
            }
        }
    </style>
</head>
<body>

<div class="register-container">

    <div class="left-side">

        <div class="auth-wrapper">

            <h1 class="welcome-title">
                CREATE ACCOUNT
            </h1>

            <p class="welcome-subtitle">
                Create your account to continue.
            </p>

            <form method="POST" action="/register">
                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control-custom"
                        placeholder="Enter your full name"
                        required>
                </div>

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
                        placeholder="Enter your password"
                        required>
                </div>

                <button type="submit" class="btn-register">
                    Create Account
                </button>

                <div class="footer-text">
                    Already have an account?
                    <a href="/login">
                        Sign In
                    </a>
                </div>

            </form>

        </div>

    </div>
    <div class="right-side">

        <img
            src="{{ asset('img/login1.png') }}"
            alt="Ship"
            class="ship-image">

    </div>

</div>

</body>
</html>