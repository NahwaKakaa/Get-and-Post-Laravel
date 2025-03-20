<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));

        if (isset($user['error'])) {
            return response()->json($user, 400);
        }

        return response()->json($user, 201);
    }

    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // Menampilkan detail pengguna berdasarkan ID
    public function showById($id)
    {
        $user = User::findById($id);
        if ($user) {
            return response()->json($user, 200);
        }
        return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
    }

    // Menampilkan detail pengguna berdasarkan Email
    public function showByEmail($email)
    {
        $user = User::findByEmail($email);
        if ($user) {
            return response()->json($user, 200);
        }
        return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
    }
}
