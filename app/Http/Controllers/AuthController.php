<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->intended('/');
        }

        $phone = $request->input('username');

        $credentials = [
            'phone' => $phone,
            'password' => $request->input('password'),
        ];

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Логин или пароль не верны',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function adminAuth(User $user)
    {

        if (hasRoles()) {
            auth()->login($user);
            toast('Вы успешно авторизовались как ' . $user->fullname, 'success');
            return redirect()->intended('/');
        }

        return back()->with('toast_error', 'У вас нет доступа!');
    }


}
