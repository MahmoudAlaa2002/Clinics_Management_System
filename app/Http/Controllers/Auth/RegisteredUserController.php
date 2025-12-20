<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use App\Notifications\admin\PatientRegisteredNotification;

class RegisteredUserController extends Controller{

    public function create(): View{
        return view('auth.register');
    }


    public function store(Request $request){
        $check = User::where('email' , '=' , $request->email)->first();         // هل الايميل موجود مسبقا
        if(isset($check)){
            return response()->json(['data' => 0]);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email =$request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->date_of_birth =$request->date_of_birth;
            $user->gender =$request->gender;
            $user->role = 'patient';
            $user->created_at = Carbon::now();
            $user->save();

            $user->assignRole(['patient']);

            $patient = Patient::create([
                'user_id' => $user->id,
                'blood_type' => $request->blood_type,
                'emergency_contact' => $request->emergency_contact,
                'allergies' => $request->allergies,
                'chronic_diseases' => $request->chronic_diseases,
            ]);


            // 🔔 إنشاء إشعار للآدمن
            $admin = User::where('role', 'admin')->get();
            Notification::send($admin , new PatientRegisteredNotification($patient));


            event(new Registered($user));
            Auth::login($user);

            return response()->json([
                'data' => 1,
                'user_id' => $user->id,
            ]);
        }
    }
}
