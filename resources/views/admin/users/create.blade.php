<!DOCTYPE html>
<html>
<head>

    <title>Add User</title>

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
            background:#f5f5f5;
        }

        .form-wrapper{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card-user{
            width:550px;
            border:2px solid #6d071a;
            border-radius:15px;
            background:white;
            padding:35px;
        }

        .btn-maroon{
            background:#6d071a;
            color:white;
        }

        .btn-maroon:hover{
            background:#540514;
            color:white;
        }

    </style>
</head>
<body>
<div class="form-wrapper">
    <div class="card-user">
        <h2 class="mb-4 text-center">Add User</h2>
        <form
            method="POST"
            action="/admin/users"
        >

            @csrf

            <div class="mb-3">

<label class="form-label">Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    required
                >

            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required
                >

            </div>
            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >

            </div>
            <div class="mb-4">
                <label class="form-label">Role</label>

                <select
                    name="role"
                    class="form-control"
                >

                    <option value="viewer">Viewer</option>
                    <option value="admin">Admin</option>

                </select>
            </div>
            <div class="d-flex gap-2">
                <a href="/admin/users" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-maroon">Save User</button>

            </div>
        </form>
    </div>
</div>
</body>
</html>