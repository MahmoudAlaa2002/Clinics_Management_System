<?php

namespace App\Http\Controllers\Backend\Employee\Receptionist;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller {

    public function receptionistDashboard(){
        $clinic_id     = Auth::user()->employee->clinic->id;
        $department_id = Auth::user()->employee->department->id;

        $doctors_count = Doctor::whereHas('employee', function ($query) use ($clinic_id , $department_id) {
            $query->where('clinic_id', $clinic_id)
                ->where('department_id', $department_id);
        })->count();

        $patients_count = Patient::whereHas('clinicPatients', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->count();

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $clinic_id)->where('department_id', $department_id)->value('id');
        $all_appointments = Appointment::where('clinic_department_id', $clinicDepartmentId)->count();
        $today_appointments = Appointment::where('clinic_department_id', $clinicDepartmentId)->whereDate('date', today())->count();

        $invoices_count = Invoice::whereHas('appointment', function($q) use ($clinic_id, $department_id) {
            $q->where('clinic_department_id', $department_id)
              ->whereHas('doctor.employee', function($qq) use ($clinic_id) {
                  $qq->where('clinic_id', $clinic_id);
              });
        }) ->count();

        return view ('Backend.employees.receptionists.dashboard' , compact(
            'doctors_count',
            'patients_count',
            'all_appointments',
            'today_appointments',
            'invoices_count',
        ));
    }




    public function receptionistProfile(){
        $receptionist = Auth::user();
        return view('Backend.employees.receptionists.profile.view' , compact('receptionist'));
    }




    public function receptionistEditProfile(){
        $receptionist = Auth::user();
        return view('Backend.employees.receptionists.profile.edit' , compact('receptionist'));
    }

    public function receptionistUpdateProfile(Request $request){
        $receptionist = Auth::user();

        $password = $receptionist->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $receptionist->image;
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

        $receptionist->update([
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
