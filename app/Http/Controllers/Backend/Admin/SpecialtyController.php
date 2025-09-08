<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Models\DepartmentSpecialty;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller{

    public function addSpecialty(){
        $departments = Department::all();
        return view('Backend.admin.specialties.add' , compact('departments'));
    }


    public function storeSpecialty(Request $request){
        if (Specialty::where('name', $request->name)->exists()) {
            return response()->json(['data' => 0]); // موجود مسبقًا
        }

        $specialty = Specialty::create([
            'name' => $request->name,
        ]);

        if ($request->has('departments') && is_array($request->departments)) {
            $specialty->departments()->attach($request->departments);   // بضيف التخصص لكل قسم
        }

        return response()->json(['data' => 1]);
    }






    public function viewSpecialties(){
        $specialties = Specialty::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.specialties.view', compact('specialties'));
    }





    public function descriptionSpecialty($id){
        $specialty = Specialty::with('departments')->findOrFail($id);
        $count_departments = $specialty->departments->count();

        $clinicIds = ClinicDepartment::whereIn('department_id', $specialty->departments->pluck('id'))->pluck('clinic_id')->unique();
        $count_clinics = $clinicIds->count();

        $count_doctor = Doctor::where('specialty_id', $specialty->id)->count();

        return view('Backend.admin.specialties.description', compact(
            'specialty',
            'count_departments',
            'count_clinics',
            'count_doctor'
        ));
    }






    public function editSpecialty($id){
        $specialty = Specialty::findOrFail($id);
        $departments = Department::all();
        return view('Backend.admin.specialties.edit', compact('specialty' , 'departments'));
    }


    public function updateSpecialty(Request $request, $id){
        $specialty = Specialty::findOrFail($id);
        $specialty->update([
            'name' => $request->name,
        ]);

        // تحديث الأقسام المرتبطة
        if ($request->has('departments') && is_array($request->departments)) {
            $specialty->departments()->sync($request->departments);
        } else {
            // إذا ما اختار ولا قسم، نحذف كل الارتباطات
            $specialty->departments()->detach();
        }

        return response()->json(['data' => 1]);
    }




    public function deleteSpecialty($id){
        $specialty = Specialty::findOrFail($id);
        $specialty->departments()->detach();

        $doctors = Doctor::where('specialty_id', $id)->get();
        foreach ($doctors as $doctor) {
            $doctor->delete();

            if ($doctor->employee) {
                if ($doctor->employee->user) {
                    $doctor->employee->user->delete();
                }

                $doctor->employee->delete();
            }
        }

        $specialty->delete();
        return response()->json(['success' => true]);
    }

}
