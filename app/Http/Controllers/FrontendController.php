<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class FrontendController extends Controller{

    public function login(){
        return view('auth.login');
    }


    public function userLogin(Request $request){
        $Check = $request->all();
        if(Auth::guard('web')->attempt(['email' => $Check['email'] , 'password' => $Check['password']])){
            if(Auth::user()->hasRole('admin')){
                return response()->json(['data' => 1]);
            }else if(Auth::user()->hasRole('clinic_manager')){
                return response()->json(['data' => 2]);
            }else if(Auth::user()->hasRole('doctor')){
                return response()->json(['data' => 3]);
            }else if(Auth::user()->hasRole('staff')){
                return response()->json(['data' => 4]);
            }else{
                return response()->json(['data' => 5 , 'user_id' => Auth::user()->id]);
            }
        }else{
            return response()->json(['data' => 0]);
        }
    }




    public function register(){
        return view('auth.register');
    }


    public function newAccount(Request $request){
        $check = User::where('email' , '=' , $request->email)->first();         // هل الايميل موجود مسبقا
        if(isset($check)){
            return response()->json(['data' => 0]);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email =$request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->created_at = Carbon::now();
            $user->save();

            Patient::create([
                'name' => $request->name,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'data' => 1,
                'user_id' => $user->id,
            ]);
        }
    }


    public function patientDashboard(){
        return view('Frontend.patient.dashboard');
    }


    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
