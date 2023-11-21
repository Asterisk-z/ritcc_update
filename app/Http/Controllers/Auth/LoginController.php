<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    //
    public function signIn(Request $request)
    {

        $credentials = $request->only('email', 'password');

        $user = Profile::where('email', $credentials['email'])->first();
        // dd($user);
        if (!$user) {
            return redirect()->route('login')->with('error', 'This user does not exist');
        }

        if (Auth::attempt($credentials)) {
            return redirect()->route('inputterDashboard')->with('success', 'Welcome to RITCC, ' . $user->FirstName . '.');
        } else {
            return redirect()->route('login')->with('error', 'Invalid credentials.');
        }
    }

    //
    public function signOut()
    {
        Auth::logout();
        return redirect()->route('login');
        // return redirect('http://10.10.14.130:8181/');
    }
}
