<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\FMDQ\PasswordUpdatedMail;
use App\Models\ActivityLog;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    //
    public function changePassword()
    {
        return view('auth.change-password');
    }

    //
    public function termsAndConditions()
    {
        return view('termsAndConditions');
    }

    //
    public function postTerms(Request $request)
    {
        return redirect()->route('login')->with('success', "You have successfully attested to the terms and conditions. Kindly proceed to login");
        // $accepted = '1';
        // $profileUpdated = Profile::where('termsAndConditions', null)->update(['termsAndConditions' => $accepted]);
        // if ($profileUpdated) {
        //     return redirect()->route('login')->with('success', "You have successfully attested the terms and conditions. Kindly proceed");
        // }
    }

    // update password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $default = Hash::make($request->default);
        $current = $user->defaultPassword;
        $new = $request->password;
        //
        $user = Profile::where('email', $request->email)->first();
        if (Hash::check($default, $current)) {
            // dd($default . ' is not equals to ' . $current);
            return redirect()->back()->with('error', "The entered password does not match your default or current password");
        }
        //
        if (Hash::check($new, $current)) {
            return redirect()->back()->with('error', "You cannot use your default password. Kindly update your password");
        }
        //
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'confirmed', // If using password confirmation field, like 'password_confirmation'
                'min:6',
                'different:email', // Ensure password is different from the username
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one digit
            ],
        ]);
        //
        if ($validated) {
            $email = $request->email;
            $password = Hash::make($request->password);
            $passwordStatus = 1;
            //
            $profileUpdated = Profile::where('id', $user->id)->update(['password' => $password, 'passwordStatus' => $passwordStatus]);
            //
            if ($profileUpdated) {
                // log activity
                $activity = new ActivityLog();
                $activity->date = now();
                $activity->app = 'RITCC';
                $activity->type = 'Change Password';
                $activity->activity = $user->email . ' changed password .';
                $activity->username = $user->email;
                $log = $activity->save();
            }
            //
            if ($log) {
                // Mail
                $updated = ([
                    'name' => $user->firstName,
                    'type' => 'change_password',

                ]);
                Mail::to($user->email)->send(new PasswordUpdatedMail($updated));
                //
                return redirect()->route('login')->with('success', "Your password has been changed. Please login.");
            }
        }
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
        // //
        // if (auth()->user()->termsAndConditions !== '1') {
        //     return redirect()->route('termsAndConditions')->with('info', 'Kindly accept the RITCC terms and conditions');
        // }

        // to check if the
        if (auth()->user()->passwordStatus === '0') {
            // Auth::logout(); // Logout the user
            return redirect()->route('changePassword')->with('info', 'Kindly update your password.');
        }

        // super admin
        if (auth()->user()->type === 'super') {
            return redirect()->route('iqx.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // inputter
        else if (auth()->user()->type === 'inputter') {
            return redirect()->route('inputter.profile.index')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // authoriser
        else if (auth()->user()->type === 'authoriser') {
            return redirect()->route('authoriser.profile.index')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // auctioneer
        elseif (auth()->user()->type == 'auctioneer' || auth()->user()->type == 'bidder') {
            return redirect()->route('bank.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // firs
        elseif (auth()->user()->type == 'firs') {
            return redirect()->route('firs.certificate.mgt.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
    }

    //
    public function signOut()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
