<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        if (session('user_id')) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'Gmail' => 'required|email|max:60',
            'phone_number' => 'nullable|string|max:11',
            'username' => 'required|string|max:60|unique:Users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $existing = DB::select("SELECT user_id FROM Users WHERE Gmail = ?", [$request->Gmail]);
        if (!empty($existing)) {
            return back()->withErrors(['Gmail' => 'This email is already registered.'])->withInput();
        }

        DB::insert("
            INSERT INTO Users (first_name, last_name, Gmail, phone_number, username, password)
            VALUES (?, ?, ?, ?, ?, ?)
        ", [
            $request->first_name,
            $request->last_name,
            $request->Gmail,
            $request->phone_number,
            $request->username,
            Hash::make($request->password),
        ]);

        $userId = DB::getPdo()->lastInsertId();
        session(['user_id' => $userId, 'username' => $request->username, 'first_name' => $request->first_name]);

        return redirect('/')->with('success', 'Account created! Welcome to SalesTracker.');
    }
}
