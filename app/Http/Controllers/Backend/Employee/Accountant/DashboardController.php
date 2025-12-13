<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller{

    public function accountantDashboard(){
        $clinic_id = Auth::user()->employee->clinic_id;

        $doctors_count = Doctor::whereHas('employee', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->count();

        $patients_count = Patient::whereHas('clinicPatients', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->count();

        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinic_id)->pluck('id');
        $all_appointments = Appointment::whereIn('clinic_department_id', $clinicDepartmentIds)->count();
        $invoices_count = $invoices = Invoice::whereHas('appointment.clinicDepartment', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->count();

        return view ('Backend.employees.accountants.dashboard' , compact(
            'doctors_count',
            'patients_count',
            'all_appointments',
            'invoices_count',
        ));
    }


    public function accountantProfile(){
        $accountant = Auth::user();
        return view('Backend.employees.accountants.profile.view' , compact('accountant'));
    }




    public function accountantEditProfile(){
        $accountant = Auth::user();
        return view('Backend.employees.accountants.profile.edit' , compact('accountant'));
    }

    public function accountantUpdateProfile(Request $request){
        $accountant = Auth::user();

        $password = $accountant->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $accountant->image;
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

        $accountant->update([
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
