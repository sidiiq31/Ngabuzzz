<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name');
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|unique:users,name',
            'email'=> 'required|email|unique:users,email',
            'username'=> 'required|unique:users,username',
            'role'=> 'required',
            'password'=> 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'name'     => $request->name,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name');
        return view('users.edit', compact('user','roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'name'     => 'required',
            'role'     => 'required',
            'status' => 'required|in:enable,disable',
        ]);

        $user->username = $request->username;
        $user->name     = $request->name;
        $user->role     = $request->role;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }
}
