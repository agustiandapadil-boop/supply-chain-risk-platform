<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>
        Supply Chain Risk Platform
    </title>
    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Leaflet --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css"
    >

    {{-- Google Font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
        body{

            font-family:'Inter',sans-serif;

            background: url('/img/background1.png') no-repeat center center fixed;
            background-size: cover;

            color:#333;
            overflow-x:hidden;

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

            color: #333;

            padding:28px 20px;
            display:flex;
            flex-direction:column;

            box-shadow:
                5px 0 20px rgba(0,0,0,.12);

            z-index:2000;

        }

        .sidebar-brand{

            margin-bottom:35px;

            text-align:center;

        }

        .sidebar-brand h3{

            margin:0;

            font-size:24px;
            font-weight:700;
            color: #6d071a;
            letter-spacing:.5px;

            letter-spacing:.5px;

        }

        .sidebar-brand small{

            display:block;

            margin-top:6px;
            color: #555;
            letter-spacing:1px;

            font-size:13px;

        }

        .sidebar hr{

            border-color: rgba(0,0,0,.1);

            margin-bottom:25px;

        }

        .sidebar .nav-link{

            color: #555;
            padding:14px 18px;
            border-radius:14px;
            margin-bottom:10px;
            transition:.3s;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:12px;

        }

        .sidebar .nav-link:hover{

            background: #fdf5f6;
            color: #6d071a;
            transform:translateX(8px);

        }

        .sidebar .nav-link.active{

            background: transparent;
            color: #6d071a;
            font-weight:700;
            border-left: 4px solid #6d071a;
            border-radius: 0 14px 14px 0;
            padding-left: 14px; 
            box-shadow: none;

        }

        .main{

            margin-left:200px;

            min-height:100vh;

        }

        .navbar-custom{

            height:75px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom:1px solid #ececec;
            display:flex;
            justify-content:flex-end;
            align-items:center;
            padding:0 35px;
            box-shadow:
                0 3px 10px rgba(0,0,0,.05);
            position:sticky;
            top:0;
            z-index:1000;

        }

        .btn-maroon{
            border:2px solid #6d071a;
            color:#6d071a;
            background:white;
            border-radius:30px;
            padding:8px 22px;
            font-weight:600;
            transition:.3s;

        }

        .btn-maroon:hover{
            background:#6d071a;
            color:white;

        }

        .content{
            padding:35px;

        }
        .card-custom{

            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius:18px;
            transition:.35s;
            box-shadow:

                0 8px 32px rgba(0,0,0,.1);
        }

        .card-custom:hover{
            border-color:#6d071a;
            transform:translateY(-6px);
            box-shadow:
                0 20px 35px rgba(109,7,26,.16);

        }

        .card-value{
            font-size:34px;
            font-weight:700;
            color:#6d071a;
            margin-top:8px;

        }

        .card-custom small{
            text-transform:uppercase;
            color:#777;
            letter-spacing:.8px;
            font-size:13px;

        }
        .page-title{

            font-size:32px;
            font-weight:700;
            color:#333;
            margin:0;

        }

        .table{

            margin-bottom:0;
        }
        .table thead{
            background:#fafafa;
        }
        .table th{

            border:none;
            color:#555;
            font-weight:600;

        }

        .table td{
            vertical-align:middle;

        }
        .table tbody tr{
            transition:.3s;

        }

        .table tbody tr:hover{
            background:#fcf4f5;

        }
        #countrySearch{

            border-radius:30px;
            border:2px solid #ddd;
            padding:12px 20px;
            transition:.3s;

        }

        #countrySearch:focus{
            border-color:#6d071a;
            box-shadow:
                0 0 10px rgba(109,7,26,.15);

        }

        #searchResults{

            border-radius:15px;
            overflow:hidden;
            box-shadow:
                0 10px 25px rgba(0,0,0,.08);

        }
        .badge-high{

            background:#8b0000;
            color:white;

        }

        .badge-medium{
            background:#c98c00;
            color:white;

        }

        .badge-low{
            background:#198754;
            color:white;

        }
        ::-webkit-scrollbar{
            width:8px;

        }

        ::-webkit-scrollbar-thumb{
            background:#bcbcbc;
            border-radius:20px;

        }

        @media(max-width:992px){
            .sidebar{
                width:200px;

            }
            .main{
                margin-left:200px;
            }

        }
        @media(max-width:768px){
            .sidebar{
                display:none;
            }

            .main{
                margin-left:0;

            }

            .navbar-custom{
                justify-content:space-between;

            }

            .content{
                padding:20px;

            }

        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-brand">
            <h3>
                Supply Chain
            </h3>
            <small>
                Risk Platform
            </small>

        </div>
        <hr>
        <a
            href="/ui/dashboard"
            class="nav-link {{ request()->is('ui/dashboard') ? 'active' : '' }}"
        >
            Dashboard
        </a>

        <a
            href="/watchlist"
            class="nav-link {{ request()->is('watchlist') ? 'active' : '' }}"
        >
            Watchlist
        </a>

        <a
            href="/ui/analytics"
            class="nav-link {{ request()->is('ui/analytics') ? 'active' : '' }}"
        >
            Analytics
        </a>

        <a
            href="/ui/news"
            class="nav-link {{ request()->is('ui/news') ? 'active' : '' }}"
        >
            News
        </a>

        <a
            href="/ui/ports"
            class="nav-link {{ request()->is('ui/ports') ? 'active' : '' }}"
        >
            Ports
        </a>

        <a
            href="/ui/articles"
            class="nav-link {{ request()->is('ui/articles*') ? 'active' : '' }}"
        >
            Articles
        </a>

    </div>

    {{-- Main --}}
    <div class="main">

        {{-- Navbar --}}
        <nav class="navbar-custom">

            @auth

                <form
                    action="/logout"
                    method="POST"
                >

                    @csrf

                    <button
                        class="btn btn-maroon"
                    >
                        Logout
                    </button>

                </form>

            @endauth

        </nav>

        {{-- Content --}}
        <div class="content">

            @yield('content')

        </div>

    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    @yield('scripts')

</body>
</html>