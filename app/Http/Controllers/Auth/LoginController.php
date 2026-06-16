<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        if (session('user_id')) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::select('SELECT * FROM Users WHERE username = ? OR Gmail = ?', [
            $request->username,
            $request->username,
        ]);

        if (!empty($user) && Hash::check($request->password, $user[0]->password)) {
            session(['user_id' => $user[0]->user_id, 'username' => $user[0]->username, 'first_name' => $user[0]->first_name]);
            return redirect('/')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }

    public function destroy()
    {
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
