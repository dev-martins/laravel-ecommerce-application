<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException();
        }

        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;


        $token->save();

        return response()->json([
            'name'     => $user['name'],
            'access_token'  => $tokenResult->accessToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
        'Saiu com sucesso!']);
    }

    public function allUsers()
    {
        return User::all();
    }
}
