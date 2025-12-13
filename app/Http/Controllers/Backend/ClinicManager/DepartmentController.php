<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller{

    public function viewDepartments(){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;
        $departments = $clinic->departments;
        return view('Backend.clinics_managers.departments.view', compact('departments'));
    }




    public function addDepartmentToClinic(){
        $departments = Department::all();
        return view('Backend.clinics_managers.departments.add' , compact('departments'));
    }


    public function storeDepartmentToClinic(Request $request){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;

        $exists = $clinic->departments()->where('departments.id', $request->department_id)->exists();
        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $clinic->departments()->attach($request->department_id);
        return response()->json(['data' => 1]);
    }




    public function detailsDepartment($id){
        $clinic = Auth::user()->employee->clinic;
        $department = $clinic->departments()->where('departments.id', $id)->first();

        // يحضر الدكاترة الموجودين في هادا القسم وفي العيادة المحددة
        $doctors = $department->doctors()->whereHas('employee', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->with('employee.user')->get();
        return view('Backend.clinics_managers.departments.details', compact('department' , 'doctors'));
    }





    public function deleteDepartment($id){
        $clinic = Auth::user()->employee->clinic;
        $department = $clinic->departments()->where('departments.id', $id)->first();
        $clinic->departments()->detach($department->id);
        return response()->json(['data' => 1]);
    }





    public function viewDepartmentsManagers(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $departments_managers = Employee::where('clinic_id' , $clinic_id)->where('job_title' , 'Department Manager')->paginate(12);
        return view ('Backend.clinics_managers.departments.departments_managers.view' , compact('departments_managers'));
    }




    public function searchDepartmentsManagers(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinic_id = Auth::user()->employee->clinic_id;

        $departments_managers = Employee::where('clinic_id', $clinic_id)->where('job_title', 'Department Manager')->with('user');

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $departments_managers->whereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "{$keyword}%");
                    });
                    break;
            }
        }

        $departments_managers = $departments_managers->orderBy('id', 'asc')->paginate(12);
        $view = view('Backend.clinics_managers.departments.departments_managers.search',compact('departments_managers'))->render();
        $pagination = $departments_managers->total() > 12 ? $departments_managers->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $departments_managers->total(),
            'searching'  => $keyword !== '',
        ]);
    }






    public function profileDepartmentManager($id){
        $department_manager = Employee::findOrFail($id);
        return view('Backend.clinics_managers.departments.departments_managers.profile', compact('department_manager'));
    }




    public function editDepartmentManager($id){
        $department_manager = Employee::findOrFail($id);
        $clinic = $department_manager->clinic;
        $working_days = $department_manager->working_days ?? [];
        return view('Backend.clinics_managers.departments.departments_managers.edit', compact( 'department_manager', 'clinic', 'working_days'));
    }


    public function updateDepartmentManager(Request $request, $id){
        $employee = Employee::with('user', 'doctor')->findOrFail($id);
        $user = $employee->user;

        $normalizedEmail = strtolower(trim($request->email));
        $existingEmail = User::whereRaw('LOWER(email) = ?', [$normalizedEmail])->where('id', '!=', $user->id)   ->first();
        if ($existingEmail) {
            return response()->json(['data' => 0]); // الإيميل مستخدم مسبقاً
        }

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/department_manager'), $imageName);
            $imagePath = 'assets/img/department_manager/' . $imageName;
        }

        $password = $user->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $user->update([
            'name'          => $request->name,
            'email'         => $normalizedEmail,
            'phone'         => $request->phone,
            'password'      => $password,
            'image'         => $imagePath,
            'address'       => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
        ]);

        $employee->update([
            'clinic_id'       => $request->clinic_id,
            'department_id'   => $request->department_id,
            'status'          => $request->status,
            'work_start_time' => $request->work_start_time,
            'work_end_time'   => $request->work_end_time,
            'working_days'    => $request->working_days,
            'short_biography' => $request->short_biography,
        ]);


        return response()->json(['data' => 1]);
    }





    public function deleteDepartmentManager($id){
        $employee = Employee::with('user')->findOrFail($id);
        $user = $employee->user;
        $employee->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }

}
