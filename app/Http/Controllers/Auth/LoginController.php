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

        $attempt_login = Auth::attempt($credentials);

        if (!$attempt_login) {
            return redirect()->route('login')->with('error', 'Invalid credentials.');
        }

        // super admin
        if (auth()->user()->Package == '1') {

            return redirect()->route('iqx.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // inputter and authoriser
        else if ((auth()->user()->type == 'inputter' || auth()->user()->type == 'authoriser')) {
            // dd('Inputter');
            return redirect()->route('profile.index')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // firs
        // auctioneer
        // bidder

    }

    //
    public function signOut()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
