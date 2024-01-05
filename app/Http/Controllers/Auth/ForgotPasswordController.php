<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MailContents;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Notifications\InfoNotification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordController extends Controller
{
    //
    public function showForgetPasswordForm()
    {
        return view('auth.forgot-password');
    }

    //
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:tblProfile',
        ], ['email.exists' => 'This email address does not exist']);

        $token = Str::random(64);
        $profile = encrypt($request->email);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // log activity
        $logMessage = $request->email . ' request a password reset link.';
        logAction($request->email, 'Forgot Password', $logMessage);
        $userEmail = Profile::where('email', $request->email)->first();
        // notification
        $link = route('get.resetPassword', $token);

        Notification::send(
            $userEmail,
            new InfoNotification(MailContents::forgotPasswordMessage($link), MailContents::forgotPasswordSubject())
        );

        return back()->with('success', 'A mail has been sent with your password reset link!');
    }

    public function showResetPasswordForm($token)
    {
        $getProfile = DB::table('password_resets')->where(['token' => $token])->first();
        return view('auth.reset-password', ['token' => $token, 'email' => $getProfile->email]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:tblProfile',
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
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = Profile::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();
        // log activity
        $logMessage = $request->email . ' changed password.';
        logAction($request->email, 'Reset Password', $logMessage);
        $userEmail = Profile::where('email', $request->email)->first();

        Notification::send(
            $userEmail,
            new InfoNotification(MailContents::resetPasswordMessage(), MailContents::resetPasswordSubject())
        );
        return redirect()->route('login')->with('success', 'Your password has been changed!');
    }
}
