<?php

namespace App\Http\Controllers\Backend\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {

    public function settings(){
        $patient = auth()->user();
        return view('Backend.patients.settings.view' , compact('patient'));
    }




    public function viewProfile(){
        $patient = auth()->user();
        return view('Backend.patients.profile.view' , compact('patient'));
    }



    public function editProfile(){
        $patient = auth()->user();
        return view('Backend.patients.profile.edit' , compact('patient'));
    }



    public function updateProfile(Request $request){
        $patient = auth()->user();

        $password = $patient->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $patient->image;
        if ($request->hasFile('image')) {
            // حذف الصورة القديمةإن وجدت
            if ($patient->image && file_exists(public_path($patient->image))) {
                @unlink(public_path($patient->image));
            }
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/patient'), $imageName);
            $imagePath = 'assets/img/patient/' . $imageName;
        }

        $patient->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password ,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagePath,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        return response()->json(['data' => 1]);
    }
}
