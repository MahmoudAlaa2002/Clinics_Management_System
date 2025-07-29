<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller{

    public function addDoctor(){
        $clinics = Clinic::with('specialties')->get();
        return view('Backend.admin.doctors.add' , compact('clinics'));
    }


    public function storeDoctor(Request $request){
        if(Doctor::where('name', $request->name)->exists() || User::where('email', $request->email)->exists()){
            return response()->json(['data' => 0]);
        }else{

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'doctors/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            } else {
                $imageName = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $imageName,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
                'role' => 'doctor',
            ]);
            $user->syncRoles(['doctor']);


            Doctor::create([
                'name' => $request->name,
                'clinic_id' => $request->clinic_id,
                'specialty_id' => $request->specialty_id,
                'user_id' => $user->id,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewDoctors(){
        $doctors = Doctor::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.doctors.view' , compact('doctors'));
    }





    public function viewClinicManagers(){
        $doctors = Doctor::where('is_in_charge' , true)->paginate(12);
        return view('Backend.admin.doctors.view_clinic_managers' , compact('doctors'));
    }





    public function profileDoctor($id){
        $doctor = Doctor::with(['clinic','specialty'])->findOrFail($id);
        return view('Backend.admin.doctors.profile', compact('doctor'));
    }





    public function editDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $user = User::where('id', $doctor->user_id)->first();
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        $working_days = $doctor->working_days ?? [];
        return view('Backend.admin.doctors.edit', compact('doctor' , 'user' , 'specialties' , 'clinics' , 'working_days'));
    }


    public function updateDoctor(Request $request, $id){
        $doctor = Doctor::findOrFail($id);
        $user = User::where('id', $doctor->user_id)->first();

        if(Doctor::where('name', $request->name)->where('id', '!=', $id)->exists() || User::where('email', $request->email)->where('id', '!=', $doctor->user_id)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $imageName = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'doctors/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            }

            $doctor->update([
                'name' => $request->name,
                'clinic_id' => $request->clinic_id ,
                'specialty_id' => $request->specialty_id ,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
            ]);

            $password = $user->password;
            if ($request->filled('password')) {
                $password = Hash::make($request->password);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password ,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $imageName,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
            ]);

            return response()->json(['data' => 1]);
        }
    }




    public function deleteDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $user = User::where('id', $doctor->user_id)->first();
        $doctor->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }





    public function searchDoctorSchedules(){
        $clinics = Clinic::all();
        $Specialties = Specialty::all();
        $doctors = Doctor::all();
        return view('Backend.admin.doctors.schedules', compact('clinics', 'Specialties', 'doctors'));
    }


    public function searchDoctchedules(Request $request){
        $doctor_id = $request->doctor_id;
        $clinic_id = $request->clinic_id;
        $specialty_id = $request->specialty_id;
        $offset = (int) $request->offset ?? 0;

        $clinics = Clinic::all();
        $Specialties = Specialty::all();
        $doctors = Doctor::all();

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addWeeks($offset);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->addWeeks($offset);

        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->whereBetween('appointment_date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();

        return view('Backend.admin.doctors.schedules', [
            'appointments' => $appointments,
            'selectedDoctor' => Doctor::find($doctor_id),
            'clinics' => $clinics,
            'Specialties' => $Specialties,
            'doctors' => $doctors,
            'clinic_id' => $clinic_id,
            'specialty_id' => $specialty_id,
            'doctor_id' => $doctor_id,
            'offset' => $offset,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
        ]);
    }





    public function getSpecialtiesByClinic($clinic_id){
        // جلب التخصصات المرتبطة بالعيادة
        $specialties = Clinic::find($clinic_id)->specialties;

        return response()->json($specialties);
    }


    public function getClinicInfo($id){
        $clinic = Clinic::findOrFail($id);
        return response()->json([
            'opening_time' => $clinic->opening_time,
            'closing_time' => $clinic->closing_time,
        ]);
    }


    public function getWorkingDays($id){
        $clinic = Clinic::findOrFail($id);
        return response()->json($clinic->working_days);
    }
}
