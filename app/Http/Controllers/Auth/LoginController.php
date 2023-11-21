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
            dump('iQX');
            return redirect()->route('inputterDashboard')->with('success', 'Welcome to RITCC, ' . $user->FirstName . '.');
        }
        // inputter
        else if ((Auth::attempt($credentials)) && ($user->Package === '2' || $user->Package === '4')) {
            dump('Inputter');
            return redirect()->route('inputterDashboard')->with('success', 'Welcome to RITCC, ' . $user->FirstName . '.');
        }
        // authoriser
        else if ((Auth::attempt($credentials)) && ($user->Package === '3' || $user->Package === '5')) {
            dump('Authoriser');
            return redirect()->route('authoriser.profile')->with('success', 'Welcome to RITCC, ' . $user->FirstName . '.');
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
