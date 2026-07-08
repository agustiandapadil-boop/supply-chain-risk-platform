<!DOCTYPE html>
<html>
<head>

    <title>Register</title>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body{
            background:#ffffff;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .auth-card{
            width:450px;
            background:white;
            padding:40px;
            border-radius:20px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,.08);
        }

        .brand{
            color:#6d071a;
            font-size:28px;
            font-weight:700;
            text-align:center;
        }

        .subtitle{
            text-align:center;
            color:#888;
            margin-bottom:30px;
        }

        .btn-maroon{
            background:#6d071a;
            color:white;
        }

    </style>

</head>

<body>

<div class="auth-card">

    <div class="brand">
        Supply Chain Risk Platform
    </div>

    <div class="subtitle">
        Create Account
    </div>

    <form
        method="POST"
        action="/register"
    >

        @csrf

        <div class="mb-3">

            <label>
                Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                required
            >

        </div>

        <div class="mb-3">

            <label>
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                required
            >

        </div>

        <div class="mb-4">

            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                required
            >

        </div>

        <button
            class="btn btn-maroon w-100"
        >
            Register
        </button>

    </form>

    <div class="text-center mt-3">

        <a href="/login">
            Already have account?
        </a>

    </div>

</div>

</body>
</html>