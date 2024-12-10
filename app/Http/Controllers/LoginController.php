<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(auth()->attempt($data)) {
            return redirect()->route('users.home');
        }else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout(); // Log out the user
        
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->route('home'); // Redirect to the login page
    }

}
