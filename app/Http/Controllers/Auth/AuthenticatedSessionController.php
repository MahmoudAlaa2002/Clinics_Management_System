<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AuthenticatedSessionController extends Controller{

    public function login(){
        return view('auth.login');
    }


    public function userLogin(Request $request){
        $Check = $request->all();
        $remember = $request->boolean('remember');


        if (Auth::guard('web')->attempt(['email' => $Check['email'], 'password' => $Check['password']],$remember)) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return response()->json(['data' => 1]);

            } else if ($user->role == 'clinic_manager') {
                return response()->json(['data' => 2]);

            } else if ($user->role == 'department_manager') {
                return response()->json(['data' => 3]);

            } else if ($user->role == 'doctor') {
                return response()->json(['data' => 4]);

            } elseif ($user->role == 'employee') {
                $employee = $user->employee;
                $jobTitle = $employee->job_title;

                return response()->json([
                    'data'     => 5,
                    'position' => $jobTitle ?? 'general'
                ]);
            } elseif ($user->role == 'patient') {
                return response()->json(['data' => 6]);
            }
        } else {
            return response()->json(['data' => 0]);
        }
    }



    public function logout(){
        if (auth()->check()) {
            auth()->user()->update([
                'last_seen' => now()
            ]);
        }
        Auth::logout(); // تسجيل خروج المستخدم
        request()->session()->invalidate(); // تعطيل الجلسة الحالية
        request()->session()->regenerateToken(); // إنشاء CSRF token جديد
        return redirect()->route('login');
    }
}
