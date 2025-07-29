<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller{

    public function addSpecialty(){
        return view('Backend.admin.specialty.add');
    }


    public function storeSpecialty(Request $request){
        if(Specialty::where('name' , $request->name)->exists()){
            return response()->json(['data' => 0]);
        }else{
            Specialty::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewSpecialties(){
        $specialties = Specialty::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.specialty.view', compact('specialties'));
    }





    public function descriptionSpecialty($id){
        $specialty = Specialty::with(['clinics' , 'doctors'])->withCount('clinics')->findOrFail($id);
        $count_clinics = $specialty->clinics_count;
        $count_doctor = Doctor::where('specialty_id', $id)->count();

        return view('Backend.admin.specialty.description', compact('specialty' , 'count_clinics' , 'count_doctor'));
    }





    public function editSpecialty($id){
        $specialty = Specialty::findOrFail($id);
        return view('Backend.admin.specialty.edit', compact('specialty'));
    }


    public function updateSpecialty(Request $request, $id){
        $specialty = Specialty::findOrFail($id);

        $specialty->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['data' => 1]);
    }




    public function deleteSpecialty($id){
        $specialty = Specialty::findOrFail($id);
        $doctors = Doctor::where('specialty_id', $specialty->id)->get();

        foreach ($doctors as $doctor) {
            User::where('id', $doctor->user_id)->delete();
        }

        Doctor::where('specialty_id', $specialty->id)->delete();
        $specialty->clinics()->detach();
        $specialty->delete();

        return response()->json(['success' => true]);
    }
}
