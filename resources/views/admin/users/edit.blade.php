<!DOCTYPE html>
<html>
<head>

    <title>Edit User</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body{
            background:#f5f6fa;
        }

        .edit-card{
            max-width:700px;
            margin:auto;
            margin-top:50px;
            border:none;
            border-radius:15px;
            box-shadow:
                0 4px 20px
                rgba(0,0,0,.08);
        }

    </style>

</head>
<body>

<div class="container">
    <div class="card edit-card">
        <div class="card-body p-5">
            <h2 class="mb-4">Edit User</h2>

            <form
                method="POST"
                action="/admin/users/{{ $user->id }}"
            >

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ $user->name }}"
                        required
                    >

                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ $user->email }}"
                        required
                    >

                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                    >
<small class="text-muted">Leave blank if password is not changed</small>
</div>

<div class="mb-4">
    <label class="form-label">Role</label>

                    <select
                        name="role"
                        class="form-select"
                    >

                        <option
                            value="viewer"
                            {{ $user->role == 'viewer' ? 'selected' : '' }}
                        >
                            Viewer
                        </option>

                        <option
                            value="admin"
                            {{ $user->role == 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Update User
                    </button>

                    <a
                        href="/admin/users"
                        class="btn btn-secondary"
                    >
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>