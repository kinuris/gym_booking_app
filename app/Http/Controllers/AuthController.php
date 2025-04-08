<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function registerView()
    {
        return view('register');
    }

    public function registerClientView()
    {
        return view('register-client');
    }

    public function registerClient(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|same:confirm_password',
            'phone_number' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = new \App\Models\Client();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->password = bcrypt($request->password);
        $user->phone_number = $request->phone_number;
        $user->birthdate = $request->birthdate;

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->save();

        return redirect('/');
    }

    public function loginView()
    {
        return view('login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('client')->attempt($credentials) || Auth::guard('instructor')->attempt($credentials) || Auth::guard('web')->attempt($credentials)) {
            if (Auth::guard('client')->check() && Auth::guard('client')->user()->is_disabled) {
                Auth::guard('client')->logout();
                return redirect('/login')->withErrors([
                    'email' => 'Your account has been disabled.',
                ]);
            }

            if (Auth::guard('instructor')->check() && Auth::guard('instructor')->user()->is_disabled) {
                Auth::guard('instructor')->logout();
                return redirect('/login')->withErrors([
                    'email' => 'Your account has been disabled.',
                ]);
            }

            if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_disabled) {
                Auth::guard('web')->logout();
                return redirect('/login')->withErrors([
                    'email' => 'Your account has been disabled.',
                ]);
            }

            return redirect()->intended('/');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|same:confirm_password',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'hourly_rate' => 'required|numeric|min:0',
            'phone_number' => 'required',
            'monthly_rate' => 'required|numeric|min:0',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'required|string|max:1000',
        ]);

        $user = new \App\Models\Instructor();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->birthdate = $request->birthdate;
        $user->hourly_rate = $request->hourly_rate;
        $user->monthly_rate = $request->monthly_rate;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->bio = $request->bio;
        $user->save();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
