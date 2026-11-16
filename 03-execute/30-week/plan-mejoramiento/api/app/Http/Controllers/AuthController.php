<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends ApiController
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate(['username' => ['required', 'string'], 'password' => ['required', 'string']]);
        $user = User::where('username', strtolower(trim($data['username'])))->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->error('INVALID_CREDENTIALS', 'Las credenciales no son válidas.', 401);
        }

        return response()->json(['access_token' => hash('sha256', $user->id.Str::random(40)), 'token_type' => 'Bearer', 'expires_in' => 28800, 'role' => $user->role]);
    }
}
