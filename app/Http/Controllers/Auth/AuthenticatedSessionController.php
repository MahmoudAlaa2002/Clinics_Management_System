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
        if(Auth::guard('web')->attempt(['email' => $Check['email'] , 'password' => $Check['password']])){
            if(Auth::user()->hasRole('admin')){
                return response()->json(['data' => 1]);
            }else if(Auth::user()->hasRole('clinic_manager')){
                return response()->json(['data' => 2 , 'user_id' => Auth::user()->id]);
            }else if(Auth::user()->hasRole('department_manager')){
                return response()->json(['data' => 3 , 'user_id' => Auth::user()->id]);
            }else if(Auth::user()->hasRole('doctor')){
                return response()->json(['data' => 4 , 'user_id' => Auth::user()->id]);
            }else if(Auth::user()->hasRole('employee')){
                return response()->json(['data' => 5 , 'user_id' => Auth::user()->id]);
            }else{
                return response()->json(['data' => 6 , 'user_id' => Auth::user()->id]);
            }
        }else{
            return response()->json(['data' => 0]);
        }
    }



    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
