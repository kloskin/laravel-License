<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        // Możesz ustawić hasło i rolę
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('defaultpassword'), 
            'role' => 'user' // lub inna logika
        ]);

        return redirect()->route('users.index')->with('status', 'Użytkownik dodany!');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$user->id}"
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('users.index')->with('status', 'Dane użytkownika zaktualizowane!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('status', 'Użytkownik usunięty!');
    }
}
