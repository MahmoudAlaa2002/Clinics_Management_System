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
        return view('Backend.admin.patients.add');
    }


    public function storePatient(Request $request){
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

        return response()->json(['data' => 1]);
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
        $user = User::findOrFail($patient->user_id);

        $patientExists = User::where(function ($query) use ($request) {
            $query->whereRaw('LOWER(email) = ?', [strtolower($request->email)])
                  ->orWhereRaw('LOWER(name) = ?', [strtolower($request->name)]);
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

}
