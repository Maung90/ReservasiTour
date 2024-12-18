<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function submit(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role_id,
            ]);
            
            return response()->json([
                'status' => true,
                'message' => 'Login success!.',
                'csrf_token' => csrf_token(),
                'session' => $request->session(),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data belum terdaftar atau salah!',
        ], 422);
    }

}
