<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'credential' => 'required | string',
            'password' => 'required | string',
            'remember-check' => 'nullable | string'
        ], [
            'credential.required' => 'Please enter your username or email !',
            'password.required' => 'Please enter your password !',
            'password.string' => 'Only alphabets, numbers & special characters are allowed. Must be a string !'
        ]);

        $credential = $request->credential;
        $password = $request->password;

        if (filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('web')->attempt(['email' => $credential, 'password' => $password])) {
                $request->session()->regenerate();

                if($request->has('remember-check')) {
                    $user = User::where('email', $credential)->first();
                    Auth::guard('web')->login($user, true);
                }
                else{
                    $user = User::where('email', $credential)->first();
                    Auth::guard('web')->login($user, false);
                }
            }
        } else {
            if (Auth::guard('web')->attempt(['username' => $credential, 'password' => $password])) {
                $request->session()->regenerate();

                if($request->has('remember-check')) {
                    $user = User::where('username', $credential)->first();
                    Auth::guard('web')->login($user, true);
                }
                else{
                    $user = User::where('username', $credential)->first();
                    Auth::guard('web')->login($user, false);
                }
            }
        }

        return redirect()->route('login')->with('error', 'Invalid username/email or password !');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'credential' => 'required | string'
        ], [
            'credential.required' => 'Please enter your username or email!',
        ]);

        $credential = $request->credential;

        $user = User::where('email', $credential)->orWhere('username', $credential)->first();

        if ($user) {

            $code = Password::createToken($user);

            $user_token = DB::table('password_reset_tokens')->where('email', $user->email)->first();

            if ($user_token) {
                DB::table('password_reset_tokens')->where('email', $user->email)->update([
                    'token' => $code,
                    'created_at' => now()
                ]);
            } else {
                DB::table('password_reset_tokens')->insert([
                    'email' => $user->email,
                    'token' => $code,
                    'created_at' => now()
                ]);
            }

            $user->sendPasswordResetNotification($code, $user->email);


            return redirect()->route('login')->with('success', 'Password reset link sent to your email !');
        }

        return redirect()->route('forgot_password')->with('error', 'Invalid Email/Username !');
    }

    public function resetPasswordForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        $user = DB::table('password_reset_tokens')->where('email', $email)->where('token', $token)->first();

        if(!$user) {
            return back()->with('error', 'Invalid token !');
        }

        $created_at = $user->created_at;
        $now = now();
        $diff = $now->diffInMinutes($created_at);

        if ($diff > 30) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('login')->with('error', 'Token expired !');
        }

        if ($user) {
            return view('reset-password', ['token' => $token, 'email' => $email]);
        }

        return redirect()->route('login')->with('error', 'Invalid token !');
    }

    public function resetPasswordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required | same:password'
        ], [
            'password.required' => 'Please enter your password !',
        ]);

        $password = $request->password;
        $email = $request->email;

        $user = User::where('email', $email)->first();

        $current_password = $user->password;

        if (Hash::check($password, $current_password)) {
            return back()->with('error', 'New password cannot be the same as the current password !');
        }

        $user->update([
            'password' => Hash::make($password)
        ]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')->with('success', 'Password reset successful !');
    }
}
