<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {

    public function viewProfile(){
        $patient = auth()->user()->patient;
        return view('Backend.patients.profile.view' , compact('patient'));
    }



    public function editProfile(){
        $patient = auth()->user()->patient;
        return view('Backend.patients.profile.edit' , compact('patient'));
    }


    public function updateProfile(Request $request) {
        $user = auth()->user();
        $patient = $user->patient;

        // email duplicate
        if (User::where('email', $request->email)->where('id','!=',$user->id)->exists()) {
            return response()->json(['data'=>0]);
        }

        // image
        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
            $file = $request->file('image');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('assets/img/patient'), $name);
            $user->image = 'assets/img/patient/'.$name;
        }

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'date_of_birth'=>$request->date_of_birth
        ]);

        $patient->update([
            'emergency_contact'=>$request->emergency_contact,
            'blood_type'=>$request->blood_type,
            'chronic_diseases'=>$request->chronic_diseases,
            'allergies'=>$request->allergies,
        ]);

        return response()->json(['data'=>1]);
    }




    public function editPassword(){
        $patient = auth()->user()->patient;
        return view('Backend.patients.profile.editPassword' , compact('patient'));
    }

    public function updatePassword(Request $request) {
        if (!Auth::guard('web')->validate([
            'email'=>auth()->user()->email,
            'password'=>$request->current_password
        ])) {
            return response()->json(['data'=>0]); // wrong current
        }

        auth()->user()->update([
            'password'=>Hash::make($request->password)
        ]);

        return response()->json(['data'=>1]);
    }



}
