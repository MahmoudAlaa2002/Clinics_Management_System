<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Medication;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\MedicineStock;
use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller{

    public function adminDashboard(){
        $clinic_count = Clinic::count();
        $department_count = Department::count();
        $doctor_count = Doctor::count();
        $doctors = Doctor::orderBy('created_at', 'desc')->take(10)->get();
        $employee_count = Employee::count();
        $patient_count = Patient::count();
        $patients = Patient::orderBy('created_at', 'desc')->take(5)->get();
        $today_appointments = Appointment::whereDate('date', today())->count();
        $appointments = Appointment::orderBy('created_at', 'desc')->take(5)->get();
        return view('Backend.admin.dashboard' , compact(
            'clinic_count' ,
        'department_count' ,
        'doctor_count' ,
        'doctors',
        'employee_count' ,
        'patient_count' ,
        'patients',
        'today_appointments',
                     'appointments',
    ));
    }





    //My Profile
    public function myProfile(){
        $user = User::role('admin')->first();
        return view('Backend.admin.myprofile.view' , compact('user'));
    }





    public function editProfile(){
        $user = User::role('admin')->first();
        return view('Backend.admin.myprofile.edit' , compact('user'));
    }


    public function updateProfile(Request $request){
        $user = User::role('admin')->first();

        $password = $user->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imageName = $user->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = 'admin/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin'), $imageName);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password ,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imageName,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        return response()->json(['data' => 1]);
    }
}
