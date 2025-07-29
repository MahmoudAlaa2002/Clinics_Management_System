<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClinicController extends Controller{

    public function addClinic(){
        $doctors = Doctor::where('is_in_charge' , false)->get();
        $specialties = Specialty::all();
        return view('Backend.admin.clinics.add' , compact('doctors' , 'specialties'));
    }


    public function storeClinic(Request $request){
        if(Clinic::where('name' , $request->name)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $clinic = Clinic::create([
                'name' => $request->name,
                'location' => $request->location,
                'clinic_phone' => $request->phone,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'description' => $request->description,
                'status' => $request->status,
                'working_days' => json_encode($request->working_days),
                'doctor_in_charge' => $request->doctor_in_charge ?: null,
            ]);

            // ✅ ربط التخصصات الموجودة مسبقًا بالعيادة
            $specialtyIds = $request->input('specialties', []); // IDs جاهزة من الفورم
            $clinic->specialties()->sync($specialtyIds);

            if ($request->filled('doctor_id')) {
                $doctor = Doctor::where('id', $request->doctor_id)->first();
                if ($doctor) {
                    $doctor->update([
                        'is_in_charge' => true,
                    ]);

                    $user = User::find($doctor->user_id);

                    if ($user) {
                        $user->update([
                            'role' => 'clinic_manager',
                        ]);
                        $user->syncRoles(['clinic_manager']);
                    }
                }
            }
            return response()->json(['data' => 1]);
        }
    }





    public function viewClinics(){
        $clinics = Clinic::with('specialties')->orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.clinics.view' , compact('clinics'));
    }





    public function descriptionClinic($id){
        $clinic = Clinic::with(['specialties' , 'doctors'])->where('id' , $id)->first();
        return view('Backend.admin.clinics.description' , compact('clinic'));
    }





    public function editClinic($id){
        $clinic = Clinic::with(['specialties'])->findOrFail($id);
        $currentDoctorId = $clinic->doctor_in_charge;

        $doctorsQuery = Doctor::where('is_in_charge', false);

        if (!is_null($currentDoctorId)) {
            $doctorsQuery->orWhere('id', $currentDoctorId);
        }

        $doctors = $doctorsQuery->get();

        $working_days = json_decode($clinic->working_days, true);
        $all_specialties = Specialty::all();
        $clinic_specialties = $clinic->specialties->pluck('id')->toArray();

        return view('Backend.admin.clinics.edit', compact('clinic','doctors','working_days','all_specialties','clinic_specialties'));
    }

    public function updateClinic(Request $request, $id){
        $clinic = Clinic::findOrFail($id);
        $doctors = Doctor::all();

        if ($request->filled('doctor_in_charge') && $request->doctor_in_charge != $clinic->doctor_in_charge) {

            $previousManager = Doctor::where('clinic_id', $clinic->id)->where('is_in_charge', true)->first();

            if ($previousManager) {
                $previousManager->is_in_charge = false;
                $previousManager->save();

                if ($previousManager->user_id) {
                    $oldUser = User::find($previousManager->user_id);
                    if ($oldUser) {
                        $oldUser->role = 'doctor';
                        $oldUser->save();
                        $oldUser->syncRoles(['doctor']);
                    }
                }
            }

            $selectedId = $request->doctor_in_charge;

            foreach ($doctors as $doctor) {
                if ($doctor->id == $selectedId) {
                    $doctor->is_in_charge = true;
                    $doctor->clinic_id = $clinic->id;
                    $doctor->save();

                    if ($doctor->user_id) {
                        $user = User::find($doctor->user_id);
                        if ($user) {
                            $user->role = 'clinic_manager';
                            $user->save();
                            $user->syncRoles(['clinic_manager']);
                        }
                    }

                    break;
                }
            }
        }

        $clinic->update([
            'name' => $request->name,
            'location' => $request->location,
            'clinic_phone' => $request->phone,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'description' => $request->description,
            'status' => $request->status,
            'working_days' => json_encode($request->working_days),
            'doctor_in_charge' => $request->filled('doctor_in_charge') ? $request->doctor_in_charge : null,
        ]);

        $clinic->specialties()->sync($request->input('specialties', []));

        return response()->json(['data' => 1]);
    }




    public function deleteClinic($id){
        $clinic = Clinic::findOrFail($id);

        // حذف الربط فقط بين العيادة والتخصصات (وليس حذف التخصصات نفسها)
        $clinic->specialties()->detach();

        Doctor::where('clinic_id', $clinic->id)->delete();
        $clinic->delete();

        return response()->json(['success' => true]);
    }
}
