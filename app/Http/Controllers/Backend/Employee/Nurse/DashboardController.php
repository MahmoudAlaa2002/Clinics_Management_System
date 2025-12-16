<?php

namespace App\Http\Controllers\Backend\Employee\Nurse;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\NurseTask;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller{

    public function nurseDashboard(){
        $clinic = Auth::user()->employee->clinic;
        $department = Auth::user()->employee->department;
        
        $doctor_count = Doctor::whereHas('employee', function ($q) use ($clinic , $department) {
            $q->where('clinic_id', $clinic->id)->where('department_id' , $department->id);
        })->count();


        $patient_count = Patient::whereHas('appointments.clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->count();


        $all_appointments = Appointment::whereHas('clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->count();


        $today_appointments = Appointment::whereHas('clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->whereDate('date', Carbon::today())->count();


        $pending_tasks_count = NurseTask::where('nurse_id' , Auth::user()->employee->id)->where('status' , 'Pending')->count();
        $completed_tasks_count = NurseTask::where('nurse_id' , Auth::user()->employee->id)->where('status' , 'Completed')->count();


        $doctors = Doctor::whereHas('employee', function ($q) use ($clinic , $department) {
            $q->where('clinic_id', $clinic->id)->where('department_id' , $department->id);
        })->latest('id')->take(5)->get();


        $patients = Patient::whereHas('appointments.clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->latest('id')->take(5)->get();


        $appointments = Appointment::whereHas('clinicDepartment', function($q) use ($clinic, $department) {
            $q->where('clinic_id', $clinic->id)
              ->where('department_id', $department->id);
        })->latest('id')->take(5)->get();


        return view ('Backend.employees.nurses.dashboard' , compact(
            'doctor_count' ,
        'patient_count' ,
        'all_appointments' ,
        'today_appointments' ,
        'pending_tasks_count',
        'completed_tasks_count',
        'doctors',
        'patients',
        'appointments',
        ));
    }




    public function nurseProfile(){
        $nurse = Auth::user();
        return view('Backend.employees.nurses.profile.view' , compact('nurse'));
    }




    public function nurseEditProfile(){
        $nurse = Auth::user();
        return view('Backend.employees.nurses.profile.edit' , compact('nurse'));
    }

    public function nurseUpdateProfile(Request $request){
        $nurse = Auth::user();

        $password = $nurse->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $nurse->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $newPath = 'assets/img/employees/' . $imageName;


            $file->move(public_path('assets/img/employees'), $imageName);

            if (!empty($imagePath) && file_exists(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }

            $imagePath = $newPath;
        }

        $nurse->update([
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
