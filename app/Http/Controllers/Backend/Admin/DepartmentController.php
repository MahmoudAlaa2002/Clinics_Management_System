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
        return view('Backend.admin.departments.add');
    }


    public function storeDepartment(Request $request){
        $normalizedName = strtolower(trim($request->name));
        if (Department::whereRaw('LOWER(name) = ?', [$normalizedName])->exists()) {
            return response()->json(['data' => 0]);
        } else {
            $department = Department::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            return response()->json(['data' => 1]);
        }
    }





    public function viewDepartments(){
        $departments = Department::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.departments.view', compact('departments'));
    }





    public function detailsDepartment($id){
        $department = Department::with('clinics', 'doctors')->findOrFail($id);
        $count_clinics = $department->clinics()->count();
        $count_doctor = $department->doctors()->count();

        return view('Backend.admin.departments.details', compact(
            'department',
            'count_clinics',
            'count_doctor'
        ));
    }





    public function editDepartment($id){
        $department = Department::findOrFail($id);
        return view('Backend.admin.departments.edit', compact('department'));
    }


    public function updateDepartment(Request $request, $id){
        $department = Department::findOrFail($id);
        $normalizedName = strtolower(trim($request->name));
        $exists = Department::whereRaw('LOWER(name) = ?', [$normalizedName])->where('id', '!=', $id)->exists();
        if ($exists) {
            return response()->json(['data' => 0]);
        }
        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return response()->json(['data' => 1]);
    }





    public function deleteDepartment($id){
        $department = Department::findOrFail($id);
        $employeeIds = Employee::where('department_id', $department->id)->pluck('id');
        $userIds = Employee::whereIn('id', $employeeIds)->pluck('user_id');
        $doctorIds = Doctor::whereIn('employee_id', $employeeIds)->pluck('id');

        Doctor::whereIn('id', $doctorIds)->delete();
        Employee::whereIn('id', $employeeIds)->delete();
        User::whereIn('id', $userIds)->delete();

        $department->clinics()->detach();
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

        $departments_managers = User::role('department_manager')->with([
            'employee:id,user_id,clinic_id,department_id,status',
            'employee.clinic:id,name',
        ]);

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $departments_managers->where('name', 'LIKE', "{$keyword}%");
                    break;

                case 'clinic':
                    // ✅ إصلاح رئيسي: لازم تمر من العلاقة employee أولًا
                    $departments_managers->whereHas('employee', function ($q) use ($keyword) {
                        $q->whereHas('clinic', function ($qq) use ($keyword) {
                            $qq->where('name', 'LIKE', "{$keyword}%");
                        });
                    });
                    break;

                default:
                    $departments_managers->where(function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('employee', function ($qq) use ($keyword) {
                                $qq->whereHas('clinic', function ($qqq) use ($keyword) {
                                    $qqq->where('name', 'LIKE', "%{$keyword}%");
                                });
                            });
                    });
                    break;
            }
        }

        $departments_managers = $departments_managers->orderBy('id', 'asc')->paginate(12);

        $view = view('Backend.admin.departments.departments_managers.search', compact('departments_managers'))->render();
        $pagination = $departments_managers->total() > 12 ? $departments_managers->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $departments_managers->total(),
            'searching'  => $keyword !== '',
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

