<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated(); // Ottieni le credenziali validate

        if (!Auth::attempt($credentials)) { // Verifica se le credenziali sono corrette
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = $request->user(); // Ottieni l'utente autenticato
        $token = $user->createToken('auth_token')->plainTextToken; // Crea un token di accesso

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout() 
    {
        Auth::user()->currentAccessToken()->delete();  
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

    public function logoutAll() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out from all devices',
        ]);
    }

    public function user() {
        return new UserResource(Auth::user());
    }

}
