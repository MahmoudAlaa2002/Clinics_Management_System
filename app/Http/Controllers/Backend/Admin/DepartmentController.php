<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Specialty;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Models\EmployeeJobTitle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller{

    public function addDepartment(){
        $specialties = Specialty::all();
        return view('Backend.admin.departments.add' , compact('specialties'));
    }


    public function storeDepartment(Request $request){
        if(Department::where('name' , $request->name)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $department = Department::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // ربط التخصصات
            if ($request->has('specialties') && is_array($request->specialties)) {
                $department->specialties()->attach($request->specialties);
            }

            return response()->json(['data' => 1]);
        }
    }





    public function viewDepartments(){
        $departments = Department::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.departments.view', compact('departments'));
    }





    public function descriptionDepartment($id){
        $department = Department::with(['clinics', 'doctors'])->withCount('clinics')->findOrFail($id);
        $count_clinics = $department->clinics_count;
        $count_specialties = $department->specialties()->count();
        $count_doctor = $department->doctors()->count();

        return view('Backend.admin.departments.description', compact(
            'department',
            'count_clinics',
            'count_specialties',
            'count_doctor'
        ));
    }





    public function editDepartment($id){
        $department = Department::findOrFail($id);
        $specialties = Specialty::all();
        return view('Backend.admin.departments.edit', compact('department' , 'specialties'));
    }


    public function updateDepartment(Request $request, $id){
        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $department->specialties()->sync($request->specialties ?? []);

        return response()->json(['data' => 1]);
    }




    public function deleteDepartment($id){
        $department = Department::findOrFail($id);
        $clinicDepartmentIds = ClinicDepartment::where('department_id', $id)->pluck('id');

        $doctors = Doctor::whereIn('clinic_department_id', $clinicDepartmentIds)->get();
        foreach ($doctors as $doctor) {
            $employee = Employee::find($doctor->employee_id);
            if ($employee) {
                User::where('id', $employee->user_id)->delete();
                $employee->delete();
            }

            $doctor->delete();
        }

        $department->clinics()->detach();
        $department->specialties()->detach();
        $department->delete();

        return response()->json(['success' => true]);
    }







    public function viewDepartmentsManagers(){
        $departments_managers = User::role('department_manager')->paginate(12);
        return view('Backend.admin.departments.departments_managers.view' , compact('departments_managers'));
    }


    public function searchDepartmentsManagers(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $query = User::role('department_manager')->with('employee.clinic');

        if ($keyword !== '') {
            if ($filter === 'clinic') {
                $query->whereHas('employee.clinic', function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword.'%');
                });
            } elseif ($filter === 'name') {
                $query->where('name', 'like', $keyword.'%');
            } else {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%'.$keyword.'%')
                    ->orWhereHas('employee.clinic', function ($qq) use ($keyword) {
                        $qq->where('name', 'like', '%'.$keyword.'%');
                    });
                });
            }
        }

        $departments_managers = $query->orderBy('id')->paginate(12);

        $html = view('Backend.admin.departments.departments_managers.search', compact('departments_managers'))->render();

        return response()->json([
            'html'       => $html,
            'count'      => $departments_managers->total(),
            'searching'  => $keyword !== '',
            'pagination' => $departments_managers->links('pagination::bootstrap-4')->render(),
        ]);
    }






    public function profileDepartmentManager($id){
        $department_manager = User::findOrFail($id);
        return view('Backend.admin.departments.departments_managers.profile', compact('department_manager'));
    }




    public function editDepartmentManager($id){
        $department_manager = User::findOrFail($id);
        $clinics = Clinic::all();
        $working_days = $department_manager->employee->working_days ?? [];
        return view('Backend.admin.departments.departments_managers.edit', compact( 'department_manager', 'clinics', 'working_days'));
    }


    public function updateDepartmentManager(Request $request, $id){
        $department_manager = User::findOrFail($id);
        $employee = Employee::where('user_id', $department_manager->id)->first();

        if (User::where('name', $request->name)->where('id', '!=', $id)->exists() || User::where('email', $request->email)->where('id', '!=', $id)->exists()) {
            return response()->json(['data' => 0]);
        }else{
            $imagePath = $department_manager->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/department_manager'), $imageName);
                $imagePath = 'assets/img/department_manager/' . $imageName;
            }


            $password = $department_manager->password;
            if ($request->filled('password')) {
                $password = Hash::make($request->password);
            }

            $department_manager->update([
                'name' => $request->name ,
                'email' => $request->email ,
                'phone' => $request->phone,
                'password' => $password,
                'image' => $imagePath,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);

            $employee->update([
                'user_id' => $department_manager->id ,
                'clinic_id' => $request->clinic_id ,
                'department_id' => $request->department_id ,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'short_biography' => $request->short_biography,
            ]);

            return response()->json(['data' => 1]);
        }
    }




    public function deleteDepartmentManager($id){
        $user = User::findOrFail($id);
        $employee = Employee::where('user_id', $id)->first();

        $jobTitle = JobTitle::where('name', 'Department Manager')->first();
        EmployeeJobTitle::where('employee_id', $employee->id)->where('job_title_id', $jobTitle->id)->delete();

        // تحقق إذا كان عنده وظائف أخرى
        $remainingJobTitles = EmployeeJobTitle::where('employee_id', $employee->id)->count();

        // إذا ما في غير وظيفة مدير قسم → احذف كل شيء
        if ($remainingJobTitles == 0) {
            $employee->delete();
            $user->delete();
        }

        return response()->json(['success' => true]);
    }

}

