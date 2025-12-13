<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller{

    public function clinicManagerDashboard(){
        $clinic = Auth::user()->employee->clinic;
        $department_count = $clinic->departments->count();
        $employee_count = Employee::where('user_id', '!=', Auth::id())->where('clinic_id' , $clinic->id)->count();
        $doctor_count = Doctor::whereHas('employee', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->count();

        $doctors = Doctor::whereHas('employee', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->take(5)->get();

        $patient_count = $clinic->patients()->count();
        $patients = $clinic->patients()
            ->orderBy('clinic_patients.created_at', 'desc')
            ->take(5)
            ->get();



        $all_appointments = $clinic->appointments()->count();
        $appointments = $clinic->appointments()->take(5)->get();
        $today_appointments = $clinic->appointments()->whereDate('date', today())->count();

        $invoice_count = Invoice::whereHas('appointment', function ($q) use ($clinic) {
            $q->whereIn('clinic_department_id', $clinic->clinicDepartments()->pluck('id'));
        })->count();


        return view ('Backend.clinics_managers.dashboard' , compact('department_count',
            'employee_count',
            'doctor_count',
            'doctors',
            'patient_count',
            'patients',
            'all_appointments',
            'today_appointments',
            'appointments',
            'invoice_count',
        ));
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
