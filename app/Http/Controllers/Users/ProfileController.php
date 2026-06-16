<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        $user = DB::select("SELECT * FROM Users WHERE user_id = ?", [session('user_id')]);
        if (empty($user)) {
            return redirect('/')->with('error', 'User not found.');
        }
        return view('profile', ['user' => $user[0]]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'Gmail' => 'required|email|max:60',
            'phone_number' => 'nullable|string|max:11',
            'location_address' => 'nullable|string|max:60',
            'bod' => 'nullable|date',
        ]);

        $existing = DB::select("SELECT user_id FROM Users WHERE Gmail = ? AND user_id != ?", [$request->Gmail, session('user_id')]);
        if (!empty($existing)) {
            return back()->withErrors(['Gmail' => 'This email is already taken.'])->withInput();
        }

        DB::update("
            UPDATE Users SET first_name = ?, last_name = ?, Gmail = ?,
                phone_number = ?, location_address = ?, bod = ?
            WHERE user_id = ?
        ", [
            $request->first_name,
            $request->last_name,
            $request->Gmail,
            $request->phone_number,
            $request->location_address,
            $request->bod,
            session('user_id'),
        ]);

        session(['first_name' => $request->first_name]);

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = DB::select("SELECT * FROM Users WHERE user_id = ?", [session('user_id')]);

        if (empty($user) || !Hash::check($request->current_password, $user[0]->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        DB::update("UPDATE Users SET password = ? WHERE user_id = ?", [
            Hash::make($request->new_password),
            session('user_id'),
        ]);

        return redirect('/profile')->with('success', 'Password changed successfully!');
    }
}
