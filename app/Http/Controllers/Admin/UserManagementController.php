<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users =
            User::latest()
            ->paginate(20);

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function create()
    {
        return view(
            'admin.users.create'
        );
    }

    public function store(
        Request $request
    )
    {
        
        $request->validate([

            'name' =>
                'required',
            'email' =>
                'required|email|unique:users',
            'password' =>
                'required|min:6',
            'role' =>
                'required'
        ]);

        User::create([

            'name' =>
                $request->name,
            'email' =>
                $request->email,

            'password' =>
                Hash::make(
                    $request->password
                ),
            'role' =>
                $request->role
        ]);

        return redirect(
            '/admin/users'
        );
    }

    public function edit($id)
    {
        $user =
            User::findOrFail($id);

        return view(
            'admin.users.edit',
            compact('user')
        );
    }

    public function update(
        Request $request,
        $id
    )
    {
        $user =
            User::findOrFail($id);

        $user->update([

            'name' =>
                $request->name,

            'email' =>
                $request->email,

            'role' =>
                $request->role
        ]);

        if (
            $request->password
        ) {

            $user->update([

                'password' =>
                    Hash::make(
                        $request->password
                    )
            ]);
        }

        return redirect(
            '/admin/users'
        );
    }

    public function destroy($id)
    {
        User::destroy($id);

        return back();
    }
}