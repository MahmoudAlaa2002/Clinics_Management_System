<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialty;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicPatient;
use App\Models\SpecialtyPatient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller{

    public function addPatient(){
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        $doctors = Doctor::all();
        return view('Backend.admin.patients.add' , compact('specialties' , 'clinics' , 'doctors'));
    }


    public function storePatient(Request $request){
        $existingPatient = Patient::where('name', $request->name)->first();
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->name !== $request->name) {
            return response()->json(['data' => 0]);
        }
        else if ($existingPatient && $existingUser) {
            $alreadyExists = ClinicPatient::where('patient_id', $existingPatient->id)
            ->where('clinic_id', $request->clinic_id)->exists();

            if (!$alreadyExists) {
                ClinicPatient::create([
                    'patient_id' => $existingPatient->id,
                    'clinic_id' => $request->clinic_id,
                    'visit_date' => now(),
                ]);
            }

            SpecialtyPatient::create([
                'patient_id' => $existingPatient->id,
                'specialty_id' => $request->specialty_id,

            ]);

            $selectedDay = $request->appointment_day;
            $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();  // تحويله إلى تاريخ (أقرب تاريخ قادم لهذا اليوم)

            Appointment::create([
                'patient_id' => $existingPatient->id,
                'doctor_id' => $request->doctor_id,
                'clinic_id'  => $request->clinic_id,
                'specialty_id'  => $request->specialty_id,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 1]);
        }else{

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'patients/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            } else {
                $imageName = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->filled('address') ? $request->address : null,
                'image' => $imageName,
                'role' => 'patient',
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
            ]);

            $user->syncRoles(['patient']);

            $patient = Patient::create([
                'name' => $request->name,
                'user_id' => $user->id,
            ]);

            ClinicPatient::create([
                'patient_id' => $patient->id,
                'clinic_id' => $request->clinic_id,
                'visit_date' => now(),
            ]);

            SpecialtyPatient::create([
                'patient_id' => $patient->id,
                'specialty_id' => $request->specialty_id,

            ]);

            $selectedDay = $request->appointment_day;
            $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();  // تحويله إلى تاريخ (أقرب تاريخ قادم لهذا اليوم)

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'clinic_id'  => $request->clinic_id,
                'specialty_id'  => $request->specialty_id,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 2]);
        }
    }





    public function viewPatients(){
        $patients = Patient::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.patients.view' , compact('patients'));
    }





    public function profilePatient($id){
        $patient = Patient::findOrFail($id);
        return view('Backend.admin.patients.profile', compact('patient'));
    }





    public function editPatient($id){
        $patient = Patient::with(['user', 'clinics', 'doctors' , 'specialties'])->findOrFail($id);
        $user = User::where('id', $patient->user_id)->first();
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        return view('Backend.admin.patients.edit', compact('patient' , 'user' , 'specialties' , 'clinics'));
    }


    public function updatePatient(Request $request, $id){
        $patient = Patient::findOrFail($id);
        $user = User::where('id', $patient->user_id)->first();

        $existingUser = User::where('email', $request->email)->where('id', '!=', $user->id)->exists();

        if($existingUser){
            return response()->json(['data' => 0]);
        }else{
            $imageName = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'patients/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('patients'), $imageName);
            }

            $password = $user->password;
            if ($request->filled('password')){
                $password = Hash::make($request->password);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'phone' => $request->phone,
                'address' => $request->filled('address') ? $request->address : null,
                'image' => $imageName,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
            ]);

            $patient->update([
                'name' => $request->name,
            ]);

            ClinicPatient::updateOrCreate(
                ['patient_id' => $patient->id],
                ['clinic_id' => $request->clinic_id, 'visit_date' => now()]
            );

            SpecialtyPatient::updateOrCreate(
                ['patient_id' => $patient->id],
                ['specialty_id' => $request->specialty_id]
            );

            $selectedDay = $request->appointment_day;
            $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'clinic_id'  => $request->clinic_id,
                'specialty_id'  => $request->specialty_id,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 1]);
        }
    }




    public function deletePatient($id){
        $patient = Patient::findOrFail($id);
        $user = User::where('id', $patient->user_id)->first();
        $patient->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }





    public function getSpecialtiesByClinic($clinic_id){
        $clinic = Clinic::with('specialties')->findOrFail($clinic_id);
        return response()->json($clinic->specialties);
    }


    public function getDoctorsByClinicAndSpecialty(Request $request){
        $clinicId = $request->clinic_id;
        $specialtyId = $request->specialty_id;

        $doctors = Doctor::where('clinic_id', $clinicId)
                        ->where('specialty_id', $specialtyId)
                        ->get();

        return response()->json($doctors);
    }


    public function getDoctorInfo($id){
        $doctor = Doctor::findOrFail($id);
        return response()->json([
            'work_start_time' => $doctor->work_start_time,
            'work_end_time'   => $doctor->work_end_time,
        ]);
    }


    public function getWorkingDays($id){
        $doctor = Doctor::findOrFail($id);
        return response()->json(
            is_string($doctor->working_days)
                ? json_decode($doctor->working_days)
                : $doctor->working_days
        );
    }
}
