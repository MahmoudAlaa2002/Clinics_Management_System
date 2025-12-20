<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller {

    public function showForgotForm(){
        return view('auth.forgot-password');
    }

    /* =========================
       Send Reset Link Email
    ==========================*/
    public function sendResetLink(Request $request){
        // يفحص هل الايميل موجود في جدول اليوزر
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 422);
    }






    /* =========================
       Show Reset Password Form
    ==========================*/
    public function showResetForm($token, Request $request){
        return view('auth.reset-password', ['token' => $token,'email' => $request->email]);
    }


    /* =========================
       Reset Password
    ==========================*/
    public function resetPassword(Request $request){
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 422);
    }

}
