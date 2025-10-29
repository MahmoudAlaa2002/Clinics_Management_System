<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicPatient;
use App\Models\ClinicDepartment;
use App\Models\DepartmentPatient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller{

    public function addPatient(){
        $clinics = Clinic::all();
        $departments = Department::all();
        $doctors = Doctor::all();
        return view('Backend.admin.patients.add' , compact('clinics' , 'departments' , 'doctors'));
    }


    public function storePatient(Request $request){
       //  احسب بيانات الموعد وفحص التعارض أولًا قبل إضافة المريض
        $appointmentDate = Carbon::parse("next {$request->appointment_day}")->toDateString();

        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->exists();

        if ($conflict) {
            return response()->json(['data' => 1]); // هذا الموعد محجوز
        }

        $user = User::whereRaw('LOWER(email) = ?', [strtolower($request->email)])
            ->orWhereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();

        if ($user) {
            return response()->json(['data' => 0]); // موجود مسبقاً
        }

        // المستخدم غير موجود - أنشئه ثم كمل
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/patients'), $imageName);
            $imagePath = 'assets/img/patients/' . $imageName;
        } else {
            $imagePath = null;
        }

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'phone'        => $request->phone,
            'address'      => $request->address,
            'image'        => $imagePath,
            'date_of_birth'=> $request->date_of_birth,
            'gender'       => $request->gender,
            'role'         => 'patient',
        ]);
        $user->assignRole('patient');

        $patient = Patient::create([
            'user_id'           => $user->id,
            'blood_type'        => $request->blood_type,
            'emergency_contact' => $request->emergency_contact,
            'allergies'         => $request->allergies,
            'chronic_diseases'  => $request->chronic_diseases,
        ]);

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');
        $consultation_fee = Doctor::where('id', $request->doctor_id)->value('consultation_fee');
        Appointment::create([
            'patient_id'           => $patient->id,
            'doctor_id'            => $request->doctor_id,
            'clinic_department_id' => $clinicDepartmentId,
            'date'                 => $appointmentDate,
            'time'                 => $request->appointment_time,
            'status'               => 'Pending',
            'consultation_fee'     => $consultation_fee,
            'notes'                => $request->notes,
        ]);

        return response()->json(['data' => 2]);
    }






    public function viewPatients(){
        $patients = Patient::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.patients.view' , compact('patients'));
    }





    public function searchPatients(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $patients = Patient::with('user:id,name,email,phone,address');

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $patients->whereHas('user', fn($q) => $q->where('name', 'like', "{$keyword}%"));
                    break;
            }
        }

        $patients   = $patients->orderBy('id')->paginate(12);
        $view       = view('Backend.admin.patients.searchPatient', compact('patients'))->render();
        $pagination = $patients->total() > 12 ? $patients->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $patients->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function profilePatient($id){
        $patient = Patient::findOrFail($id);
        return view('Backend.admin.patients.profile', compact('patient'));
    }





    public function editPatient($id){
        $patient = Patient::with('user')->findOrFail($id);
        $user = $patient->user;
        return view('Backend.admin.patients.edit', compact('patient','user'));
    }


    public function updatePatient(Request $request, $id){
        $patient = Patient::findOrFail($id);
        $user    = User::findOrFail($patient->user_id);

        $patientExists = User::where(function ($query) use ($request) {
            $query->where('email', $request->email)->orWhere('name', $request->name);
        })->where('id', '!=', $user->id)->exists();

        if ($patientExists) {
            return response()->json(['data' => 0]);
        }else{
            $imagePath = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/patients'), $imageName);
                $imagePath = 'assets/img/patients/' . $imageName;
            }

        $password = $user->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => $password,
            'phone'         => $request->phone,
            'address'       => $request->filled('address') ? $request->address : null,
            'image'         => $imagePath,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
            'role'          => 'patient',
        ]);


        $patient->update([
            'blood_type'        => $request->blood_type,
            'emergency_contact' => $request->emergency_contact,
            'allergies'         => $request->allergies,
            'chronic_diseases'  => $request->chronic_diseases,
        ]);

        return response()->json(['data' => 1]);
        }


    }




    public function deletePatient($id){
        $patient = Patient::findOrFail($id);
        $user = User::findOrFail($patient->user_id);

        Appointment::where('patient_id', $patient->id)->delete();
        $patient->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }





    public function getdepartmentsByClinic($clinic_id){
        $clinic = Clinic::with('departments')->findOrFail($clinic_id);
        return response()->json($clinic->departments);
    }


    public function getDoctorsByClinicAndDepartment(Request $request){
        $doctors = Doctor::whereHas('employee', function ($q) use ($request) {
            $q->where('clinic_id', $request->clinic_id)
              ->where('department_id', $request->department_id);
        })
        ->with(['employee.user:id,name'])
        ->get()
        ->map(fn($d) => [
            'id'   => $d->id,
            'name' => optional(optional($d->employee)->user)->name ?? 'Unknown'
        ])->values();

        return response()->json($doctors);
    }



    public function getDoctorInfo($id){
        $doctor = Doctor::with('employee')->findOrFail($id);
        return response()->json([
            'work_start_time' => $doctor->employee?->work_start_time,
            'work_end_time'   => $doctor->employee?->work_end_time,
        ]);
    }


    public function getWorkingDays($id){
        $doctor = Doctor::with('employee')->findOrFail($id);
        $days = $doctor->employee?->working_days;
        if (is_string($days)) {
            $decoded = json_decode($days, true);   // true => يرجّع Array
            $days = is_array($decoded) ? $decoded : [];
        } elseif ($days === null) {
            $days = [];
        }

        return response()->json($days);
    }
}
