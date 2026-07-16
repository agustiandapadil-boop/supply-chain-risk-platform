<!DOCTYPE html>
<html>
<head>

    <title>Admin Panel</title>
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
            background: url('/img/background1.png') no-repeat center center fixed;
            background-size: cover;
            font-family:
                Segoe UI,
                sans-serif;
        }

        .sidebar{

            position:fixed;
            left:0;
            top:0;
            width:200px;
            height:100vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(0,0,0,0.05);

            padding-top:20px;
        }

        .sidebar h4{

            color:#6d071a;
            font-weight: 700;
            text-align:center;
            margin-bottom:30px;
        }

        .sidebar a{

            display:block;
            color:#555;
            font-weight: 600;
            text-decoration:none;
            padding:12px 20px;
            margin:5px 10px;
            border:1px solid transparent;
            border-radius:8px;
        }

        .sidebar a:hover{

            background:#fdf5f6;
            color:#6d071a;
            border-color: #fdf5f6;
        }
        .card-admin{

            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(109, 7, 26, 0.5);
            border-radius:15px;
            box-shadow: 0 8px 32px rgba(0,0,0,.1);
        }

        .navbar-admin{
            height:75px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom:1px solid rgba(0,0,0,0.05);
            display:flex;
            justify-content:flex-end;
            align-items:center;
            padding:0 35px;
            position:sticky;
            top:0;
            z-index:1000;
        }

        .btn-maroon{
            border:2px solid #6d071a;
            color:#6d071a;
            background:transparent;
            border-radius:30px;
            padding:6px 20px;
            font-weight:600;
            transition:.3s;
        }
        .btn-maroon:hover{
            background:#6d071a;
            color:white;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Admin Panel</h4>
    <a href="/admin">Dashboard</a>
    <a href="/admin/users">Users</a>
    <a href="/admin/ports">Ports</a>
    <a href="/admin/articles">Articles</a>
    <a href="/ui/dashboard">Viewer Dashboard</a>

</div>

<div class="main-wrapper" style="margin-left: 200px;">
    <nav class="navbar-admin">
        <form action="/logout" method="POST" style="margin: 0;">
            @csrf
            <button class="btn btn-maroon">Logout</button>
        </form>
    </nav>
    <div style="padding: 30px;">
        @yield('content')
    </div>
</div>
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>
</html>