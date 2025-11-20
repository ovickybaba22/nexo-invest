<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'is_admin'=> ['nullable', 'boolean'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->is_admin = (bool) ($data['is_admin'] ?? false);

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User updated successfully.');
    }
}