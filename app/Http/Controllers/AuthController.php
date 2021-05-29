<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();

            $user = Auth::user();
            return $user;
        }

        return response()->json([
            'message' => 'Invalid login credentials'
        ], 401);
    }

    public function getToken(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $user->createToken('my-token');
        }

        return response()->json([
            'message' => 'Invalid login credentials'
        ], 401);
    }
}
