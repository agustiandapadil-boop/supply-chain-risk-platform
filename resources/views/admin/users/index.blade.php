@extends('admin.layouts.app')

@section('content')

<div
class="
d-flex
justify-content-between
align-items-center
mb-4
"
>

    <h2>
        User Management
    </h2>

    <a
        href="/admin/users/create"
        class="btn btn-danger"
    >
        Add User
    </a>

</div>

<div class="card card-admin p-4">

<table class="table">

    <thead>

    <tr>

        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>

    </tr>
    </thead>
    <tbody>

    @foreach($users as $user)

        <tr>

            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
                {{ $user->role }}
            </td>

            <td>

                <a
                    href="/admin/users/{{ $user->id }}/edit"
                    class="btn btn-sm btn-warning"
                >
                    Edit
                </a>
            </td>
        </tr>

    @endforeach

    </tbody>

</table>
{{ $users->links() }}
</div>

@endsection