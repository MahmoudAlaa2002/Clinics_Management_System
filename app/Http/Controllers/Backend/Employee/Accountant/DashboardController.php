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
use Illuminate\Support\Facades\Storage;

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

        $issued_invoices_count = Invoice::whereHas('appointment.clinicDepartment', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->where('invoice_status' , 'Issued')->count();

        $cancelled_invoices_count = Invoice::whereHas('appointment.clinicDepartment', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->where('invoice_status' , 'Cancelled')->count();

        return view ('Backend.employees.accountants.dashboard' , compact(
            'doctors_count',
            'patients_count',
            'all_appointments',
            'issued_invoices_count',
            'cancelled_invoices_count',
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

        $imagePath = $accountant->image; // الصورة القديمة
        if ($request->hasFile('image')) {
            if ($accountant->image && Storage::disk('public')->exists($accountant->image)) {
                Storage::disk('public')->delete($accountant->image);
            }
            $imagePath = $request->file('image')->store('employees', 'public');
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
