<!DOCTYPE html>
<html>

<head>

    <title>
        Supply Chain Risk Platform
    </title>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css"
    />

    <style>

        body{
            background:#ffffff;
            color:#222;
            font-family:"Segoe UI",sans-serif;
            overflow-x:hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | Navbar
        |--------------------------------------------------------------------------
        */

        .navbar-custom{

            background:#6d071a;

            position:fixed;

            top:0;

            left:0;

            right:0;

            z-index:1050;

            height:70px;

            box-shadow:
                0 2px 10px
                rgba(0,0,0,.15);
        }

        .navbar-brand{

            color:white !important;

            font-weight:700;

            font-size:22px;
        }

        /*
        |--------------------------------------------------------------------------
        | Sidebar
        |--------------------------------------------------------------------------
        */

        .sidebar{

            position:fixed;

            top:70px;

            left:0;

            width:250px;

            height:100vh;

            background:#6d071a;

            padding:20px;

            overflow-y:auto;
        }

        .sidebar .nav-link{

            color:white;

            border:1px solid white;

            border-radius:10px;

            margin-bottom:12px;

            padding:12px 15px;

            font-weight:600;

            transition:.3s;
        }

        .sidebar .nav-link:hover{

            background:white;

            color:#6d071a;
        }

        .sidebar .nav-link.active{

            background:white;

            color:#6d071a;

            font-weight:700;
        }

        /*
        |--------------------------------------------------------------------------
        | Content
        |--------------------------------------------------------------------------
        */

        .content-wrapper{

            margin-left:250px;

            margin-top:70px;

            padding:30px;
        }

        /*
        |--------------------------------------------------------------------------
        | Cards
        |--------------------------------------------------------------------------
        */

        .card-custom{

            border:2px solid #6d071a;

            border-radius:15px;

            box-shadow:
                0 4px 15px
                rgba(0,0,0,.04);
        }

        .card-value{

            font-size:30px;

            font-weight:700;

            color:#6d071a;
        }

        /*
        |--------------------------------------------------------------------------
        | Titles
        |--------------------------------------------------------------------------
        */

        .page-title{

            font-size:28px;

            font-weight:700;
        }

        /*
        |--------------------------------------------------------------------------
        | Risk Badges
        |--------------------------------------------------------------------------
        */

        .badge-high{
            background:#8b0000;
        }

        .badge-medium{
            background:#b8860b;
        }

        .badge-low{
            background:#198754;
        }

        /*
        |--------------------------------------------------------------------------
        | Table
        |--------------------------------------------------------------------------
        */

        table tbody tr:hover{

            background:#fafafa;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-custom">

    <div class="container-fluid">

        <a
            href="/ui/dashboard"
            class="navbar-brand"
        >
            Supply Chain Risk Platform
        </a>

        <div>

            @auth

                <form
                    action="/logout"
                    method="POST"
                >

                    @csrf

                    <button
                        class="btn btn-light"
                    >
                        Logout
                    </button>

                </form>

            @endauth

        </div>

    </div>

</nav>

<div class="sidebar">

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

</div>

<div class="content-wrapper">

    @yield('content')

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@yield('scripts')

</body>

</html>