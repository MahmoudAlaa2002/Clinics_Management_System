<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller{

    public function clinicManagerDashboard(){
        return view ('Backend.clinics_managers.dashboard');
    }




    public function clinicManagerProfile(){
        $clinicManager = Auth::user();
        return view('Backend.clinics_managers.profile.view', compact('clinicManager'));
    }




    public function clinicManagerEditProfile(){
        $clinicManager = Auth::user();
        return view('Backend.clinics_managers.profile.edit', compact('clinicManager'));
    }


    public function clinicManagerUpdateProfile(Request $request){
        $clinicManager = Auth::user();

        $password = $clinicManager->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $clinicManager->image; // الصورة القديمة
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $newPath = 'assets/img/clinic_manager/' . $imageName;


            $file->move(public_path('assets/img/clinic_manager'), $imageName);

            if (!empty($imagePath) && file_exists(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }

            $imagePath = $newPath;
        }

        $clinicManager->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $password,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'image'        => $imagePath,
            'date_of_birth'=> $request->date_of_birth,
            'gender'       => $request->gender,
        ]);

        return response()->json(['data' => 1]);
    }


}
