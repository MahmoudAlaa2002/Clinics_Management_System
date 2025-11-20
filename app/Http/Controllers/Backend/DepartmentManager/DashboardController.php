<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller{

    public function departmentManagerDashboard(){
        return view ('Backend.departments_managers.dashboard');
    }



    public function departmentManagerProfile(){
        $department_manager = Auth::user();
        return view('Backend.departments_managers.profile.view' , compact('department_manager'));
    }




    public function departmentManagerEditProfile(){
        $department_manager = Auth::user();
        return view('Backend.departments_managers.profile.edit' , compact('department_manager'));
    }

    public function departmentManagerUpdateProfile(Request $request){
        $department_manager = Auth::user();

        $password = $department_manager->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $department_manager->image; 
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $newPath = 'assets/img/department_manager/' . $imageName;


            $file->move(public_path('assets/img/department_manager'), $imageName);

            if (!empty($imagePath) && file_exists(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }

            $imagePath = $newPath;
        }

        $department_manager->update([
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
