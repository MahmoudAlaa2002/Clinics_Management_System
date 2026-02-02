<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller{

    public function adminDashboard(){
        $clinic_count = Clinic::count();
        $department_count = Department::count();
        $doctor_count = Doctor::count();
        $doctors = Doctor::orderBy('created_at', 'desc')->take(10)->get();
        $employee_count = Employee::count();
        $patient_count = Patient::count();
        $patients = Patient::orderBy('created_at', 'desc')->take(5)->get();
        $all_appointments = Appointment::count();
        $today_appointments = Appointment::whereDate('date', today())->count();
        $appointments = Appointment::orderBy('created_at', 'desc')->take(5)->get();
        $invoices_count = Invoice::count();
        return view('Backend.admin.dashboard' , compact(
            'clinic_count' ,
        'department_count' ,
        'doctor_count' ,
        'doctors',
        'employee_count' ,
        'patient_count' ,
        'patients',
        'all_appointments',
        'today_appointments',
                     'appointments',
                     'invoices_count',
        ));
    }





    //My Profile
    public function myProfile(){
        $user = User::role('admin')->first();
        return view('Backend.admin.myprofile.view' , compact('user'));
    }





    public function editProfile(){
        $user = auth()->user();
        return view('Backend.admin.myprofile.edit' , compact('user'));
    }


    public function updateProfile(Request $request){
        $user = auth()->user();

        $password = $user->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $user->image; // الصورة الحالية
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('admin', 'public');
        }

        $user->update([
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
