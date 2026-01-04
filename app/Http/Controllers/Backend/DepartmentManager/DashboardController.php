<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller{

    public function departmentManagerDashboard(){
        $clinic = Auth::user()->employee->clinic;
        $department = Auth::user()->employee->department;
        $employee_count = Employee::where('user_id', '!=', Auth::id())->where('clinic_id' , $clinic->id)->where('department_id' , $department->id)->count();

        $doctor_count = Doctor::whereHas('employee', function ($q) use ($clinic , $department) {
            $q->where('clinic_id', $clinic->id)->where('department_id' , $department->id);
        })->count();

        $doctors = Doctor::with('employee.user')->whereHas('employee', function ($q) use ($clinic , $department) {
            $q->where('clinic_id', $clinic->id)->where('department_id' , $department->id);
        })->take(5)->get();


        $patient_count = Patient::whereHas('appointments.clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->count();


        $patients = Patient::with('user')->whereHas('appointments.clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->orderBy('created_at', 'desc')->take(5)->get();


        $all_appointments = Appointment::whereHas('clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->count();

        $appointments = Appointment::whereHas('clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->orderBy('created_at', 'desc')->take(5)->get();


        $today_appointments = Appointment::whereHas('clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->whereDate('date', Carbon::today())->count();


        return view ('Backend.departments_managers.dashboard' , compact(
            'employee_count',
            'doctor_count',
            'doctors',
            'patient_count',
            'patients',
            'all_appointments',
            'appointments',
            'today_appointments',
        ));
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
