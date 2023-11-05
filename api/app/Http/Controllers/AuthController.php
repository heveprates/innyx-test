<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private const AUTH_TOKEN_NAME = 'auth_token';
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Usuário ou senha inválidos'], 401);
        }

        $user->tokens()->where('name', self::AUTH_TOKEN_NAME)->delete();

        return response()->json([
            'bearer_token' => $user->createToken(self::AUTH_TOKEN_NAME)->plainTextToken,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->where('name', self::AUTH_TOKEN_NAME)->delete();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

}
