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

    // update password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        //
        // $user = Profile::where('email', $request->email)->first();
        //
        $validated =  $request->validate([
            'password' => [
                'required',
                'string',
                // function ($attribute, $value, $fail) use ($user) {
                //     // Check if the entered password matches either the defaultPassword or current password
                //     if (!Hash::check($value, $user->defaultPassword) && !Hash::check($value, $user->password)) {
                //         $fail('The entered password does not match your default or current password.');
                //     }
                // },
                // 'confirmed', // If using password confirmation field, like 'password_confirmation'
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
                    'type' => 'changePassword',
                    // 'email' => $user->email,
                    // 'password' => $uniqueString

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
        // to check if the
        if (auth()->user()->passwordStatus === '0') {
            // Auth::logout(); // Logout the user
            return redirect()->route('changePassword')->with('info', 'Kindly update your password.');
        }
        // super admin
        if (auth()->user()->type === 'super') {
            return redirect()->route('iqx.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // inputter and authoriser
        else if ((auth()->user()->type === 'inputter' || auth()->user()->type === 'authoriser')) {
            return redirect()->route('profile.index')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // auctioneer
        elseif (auth()->user()->type === 'auctioneer') {
            return redirect()->route('auction.mgt.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        }
        // firs
        // elseif (auth()->user()->type == 'firs') {
        //     return redirect()->route('auction.mgt.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        // }
        //
        // elseif (auth()->user()->type == 'bidder') {
        //     return redirect()->route('auction.mgt.dashboard')->with('success', 'Welcome to RITCC, ' . auth()->user()->firstName . '.');
        // }
    }

    //
    public function signOut()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
