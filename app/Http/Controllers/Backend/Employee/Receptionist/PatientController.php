<?php

namespace App\Http\Controllers\Backend\Employee\Receptionist;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicPatient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\admin\PatientAddByReceptionist;

class PatientController extends Controller{

    public function addPatient(){
        return view('Backend.employees.receptionists.patients.add');
    }


    public function storePatient(Request $request){
        $clinic_id = Auth::user()->employee->clinic_id;

        $user = User::whereRaw('LOWER(email) = ?', [strtolower($request->email)])->first();
        if ($user) {

            $patient = Patient::where('user_id', $user->id)->first();
            if ($patient) {
                $linked = ClinicPatient::where('clinic_id', $clinic_id)->where('patient_id', $patient->id)->exists();
                if ($linked) {
                    return response()->json(['data' => 0]);    // المريض موجود مسبقاً
                }

                ClinicPatient::create([
                    'clinic_id'  => $clinic_id,
                    'patient_id' => $patient->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json(['data' => 1]);  // تمت الإضافة بنجاح
            }
        }

        // 2) غير موجود في كلا الجدولين → إنشاء جديد

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/patients'), $imageName);
            $imagePath = 'assets/img/patients/' . $imageName;
        } else {
            $imagePath = null;
        }

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'phone'         => $request->phone,
            'address'       => $request->address,
            'image'         => $imagePath,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
            'role'          => 'patient',
        ]);

        $user->assignRole('patient');

        $patient = Patient::create([
            'user_id'           => $user->id,
            'blood_type'        => $request->blood_type,
            'emergency_contact' => $request->emergency_contact,
            'allergies'         => $request->allergies,
            'chronic_diseases'  => $request->chronic_diseases,
        ]);

        // ربطه مع العيادة
        ClinicPatient::create([
            'clinic_id'  => $clinic_id,
            'patient_id' => $patient->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $admin = User::where('role', 'admin')->get();
        $clinicManager = User::where('role', 'clinic_manager')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', Auth::user()->employee->clinic_id);
            })->get();

        $recipients = $admin->merge($clinicManager);

        $receptionistName = Auth::user()->employee->user->name;
        $clinicName = Auth::user()->employee->clinic->name;
        Notification::send($recipients, new PatientAddByReceptionist($patient, $receptionistName, $clinicName));


        return response()->json(['data' => 2]);  // تمت الإضافة بنجاح
    }








    public function viewPatients(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $patients = Patient::whereHas('clinicPatients', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->orderBy('id', 'asc')->paginate(50);

        return view('Backend.employees.receptionists.patients.view', compact('patients'));
    }






    public function searchPatients(Request $request){
        $clinic_id = Auth::user()->employee->clinic_id;
        $keyword   = trim((string) $request->input('keyword', ''));
        $filter    = $request->input('filter', '');

        $patients = Patient::with('user:id,name,email,phone,address')
            ->whereHas('clinicPatients', function ($q) use ($clinic_id) {
                $q->where('clinic_id', $clinic_id);
            });

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $patients->whereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'email':
                    $patients->whereHas('user', function ($q) use ($keyword) {
                        $q->where('email', 'like', "{$keyword}%");
                    });
                    break;

                case 'phone':
                    $patients->whereHas('user', function ($q) use ($keyword) {
                        $q->where('phone', 'like', "{$keyword}%");
                    });
                    break;
            }
        }

        $patients   = $patients->orderBy('id')->paginate(50);
        $view       = view('Backend.employees.receptionists.patients.search', compact('patients'))->render();
        $pagination = ($patients->total() > $patients->perPage()) ? $patients->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $patients->total(),
            'searching'  => $keyword !== '',
        ]);
    }






    public function profilePatient($id){
        $patient = Patient::findOrFail($id);
        return view('Backend.employees.receptionists.patients.profile', compact('patient'));
    }





    public function editPatient($id){
        $clinic_id = Auth::user()->employee->clinic_id;
        $patient = Patient::where('id', $id)->whereHas('clinicPatients', function ($q) use ($clinic_id) {
                $q->where('clinic_id', $clinic_id);
            })->with('user')->firstOrFail();

        return view('Backend.employees.receptionists.patients.edit', compact('patient'));
    }



    public function updatePatient(Request $request, $id){
        $clinic_id = Auth::user()->employee->clinic_id;
        $patient = Patient::where('id', $id)->whereHas('clinicPatients', function ($q) use ($clinic_id) {
                $q->where('clinic_id', $clinic_id);
            })->with('user')->firstOrFail();

        $user = $patient->user;

        if (strtolower($user->email) !== strtolower($request->email)) {

            $existingUser = User::whereRaw('LOWER(email) = ?', [strtolower($request->email)])->where('id', '!=', $user->id)->first();

            if ($existingUser) {
                return response()->json(['data' => 0]);
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/patients'), $imageName);
            $imagePath = 'assets/img/patients/' . $imageName;

            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
        } else {
            $imagePath = $user->image;
        }

        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'image'         => $imagePath,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
        ]);

        $patient->update([
            'blood_type'        => $request->blood_type,
            'emergency_contact' => $request->emergency_contact,
            'allergies'         => $request->allergies,
            'chronic_diseases'  => $request->chronic_diseases,
        ]);

        return response()->json(['data' => 1]); // تم التعديل بنجاح
    }





    public function deletePatient($id){
        $clinic_id = Auth::user()->employee->clinic_id;
        ClinicPatient::where('clinic_id', $clinic_id)->where('patient_id', $id)->delete();
        return response()->json(['success' => true]);
    }
}
