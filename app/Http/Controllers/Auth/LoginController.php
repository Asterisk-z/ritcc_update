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

        if (!$user) {
            return redirect()->route('login')->with('error', 'This user does not exist');
        }
        // super admin
        else if ((Auth::attempt($credentials)) && ($user->Package === '1')) {
            // dd('iQX');
            return redirect()->route('iqx.dashboard')->with('success', 'Welcome to RITCC, ' . $user->FirstName . '.');
        }
        // inputter and authoriser
        else if ((Auth::attempt($credentials) && ($user->type === 'inputter' || $user->type === 'authoriser'))) {
            // dump('Inputter');
            return redirect()->route('profile.index')->with('success', 'Welcome to RITCC, ' . $user->FirstName . '.');
        }
        // firs
        // auctioneer
        // bidder
        else {
            return redirect()->route('login')->with('error', 'Invalid credentials.');
        }
    }

    //
    public function signOut()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
