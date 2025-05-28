<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class OtpLoginController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        Mail::raw("Kode OTP Anda: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Kode OTP Login');
        });

        session(['otp_email' => $user->email]);
        return redirect()->route('otp.verify.form')->with('status', 'OTP telah dikirim ke email Anda.');
    }

    public function showVerifyForm()
    {
        return view('auth.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);
        $user = User::where('email', session('otp_email'))->first();

        if (
            !$user ||
            $user->otp_code !== $request->otp ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau kadaluarsa.']);
        }

        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);

        // Jika belum punya password, redirect ke form set password
        if (is_null($user->password)) {
            return redirect()->route('password.set.form');
        }

        // Redirect sesuai role
        return $user->role === 'admin'
            ? redirect('/admin/dashboard')
            : redirect('/alumni/dashboard');
    }
}
