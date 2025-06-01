<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('auth.login', $data);
    }

    public function action_login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $login = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('login');
    }
}
