<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller{

    public function addEmployee(){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;
        $departments = $clinic->departments;
        $opening_time = $clinic->opening_time;
        $closing_time = $clinic->closing_time;
        $working_days = $clinic->working_days ?? [];
        return view('Backend.clinics_managers.employees.add', compact(
            'clinic',
            'departments',
            'opening_time',
            'closing_time',
            'working_days',
        ));
    }


    public function storeEmployee(Request $request){
        $normalizedName = strtolower(trim($request->name));
        $normalizedEmail = strtolower(trim($request->email));
        $existingEmployee = User::whereRaw('LOWER(name) = ?', [$normalizedName])->whereRaw('LOWER(email) = ?', [$normalizedEmail])->first();

        if ($existingEmployee) {
            return response()->json(['data' => 0]);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/employees'), $imageName);
            $imagePath = 'assets/img/employees/' . $imageName;
        }

        $role = match ($request->job_title) {
            'Department Manager' => 'department_manager',
            default => 'employee',
        };

        // تحقق من عدم وجود مدير للقسم في نفس العيادة
        if ($request->job_title === 'Department Manager') {
            $departmentHasManager = Employee::where('clinic_id', $request->clinic_id)
                ->where('department_id', $request->department_id)
                ->whereHas('user.roles', function ($q) {
                    $q->where('name', 'department_manager');
                })->exists();

            if ($departmentHasManager) {
                return response()->json(['data' => 1]);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagePath,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'role' => $role,
        ]);

        $user->assignRole($role);

        $employee = Employee::create([
            'user_id' => $user->id,
            'clinic_id' => $request->clinic_id,
            'department_id' => $request->department_id,
            'job_title' => $request->job_title,
            'hire_date' => now()->toDateString(),
            'work_start_time' => $request->work_start_time,
            'work_end_time' => $request->work_end_time,
            'working_days' => $request->working_days,
            'status' => $request->status,
            'short_biography' => $request->short_biography,
        ]);


        if ($request->job_title === 'Doctor') {
            Doctor::create([
                'employee_id' => $employee->id,
                'speciality' => $request->speciality,
                'qualification' => $request->qualification,
                'rating' => $request->rating,
                'consultation_fee' => $request->consultation_fee,
            ]);
        }

        return response()->json(['data' => 2]);
    }






    public function viewEmployees(){
        $employees = Employee::where('user_id', '!=', Auth::id())->orderBy('id', 'asc')->paginate(12);
        return view('Backend.clinics_managers.employees.view' , compact('employees'));
    }





    public function searchEmployees(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $query = Employee::with('user');

        if ($keyword !== '') {
            if ($filter === 'name') {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword . '%');
                });
            } elseif ($filter === 'job') {
                $query->where('job_title', 'like', $keyword . '%');
            } else {
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('user', function ($qq) use ($keyword) {
                        $qq->where('name', 'like', '%' . $keyword . '%');
                    })->orWhere('job_title', 'like', '%' . $keyword . '%');
                });
            }
        }

        $employees = $query->orderBy('id')->paginate(12);
        $html = view('Backend.clinics_managers.employees.search', compact('employees'))->render();

        return response()->json([
            'html'       => $html,
            'count'      => $employees->total(),
            'searching'  => $keyword !== '',
            'pagination' => $employees->links('pagination::bootstrap-4')->render(),
        ]);
    }







    public function profileEmployee($id){
        $employee = Employee::findOrFail($id);
        return view('Backend.clinics_managers.employees.profile', compact('employee'));
    }





    public function editEmployee($id){
        $employee = Employee::findOrFail($id);
        $clinic = Auth::user()->employee->clinic;
        $departments = $clinic->departments;
        $opening_time = $clinic->opening_time;
        $closing_time = $clinic->closing_time;
        $working_days = $clinic->working_days ?? [];

        return view('Backend.clinics_managers.employees.edit', compact('employee',
            'clinic',
            'departments',
            'opening_time',
            'closing_time',
            'working_days',
        ));
    }

    public function updateEmployee(Request $request, $id){
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        $normalizedName = strtolower(trim($request->name));
        $normalizedEmail = strtolower(trim($request->email));

        $existingEmployee = User::whereRaw('LOWER(name) = ?', [$normalizedName])
            ->whereRaw('LOWER(email) = ?', [$normalizedEmail])
            ->where('id', '!=', $user->id) // استثناء المستخدم الحالي
            ->first();

        if ($existingEmployee) {
            return response()->json(['data' => 0]); // موجود مسبقا
        }

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/employees'), $imageName);
            $newPath = 'assets/img/employees/' . $imageName;

            // حذف القديمة إذا كانت موجودة
            if ($user->image && file_exists(public_path($user->image))) {
                @unlink(public_path($user->image));
            }

            $imagePath = $newPath;
        }

        $role = match ($request->job_title) {
            'Department Manager' => 'department_manager',
            default => 'employee',
        };

        // تحقق من عدم وجود مدير قسم آخر
        if ($request->job_title === 'Department Manager') {
            $departmentHasManager = Employee::where('clinic_id', $request->clinic_id)
                ->where('department_id', $request->department_id)
                ->where('id', '!=', $employee->id)
                ->whereHas('user.roles', fn($q) => $q->where('name', 'department_manager'))
                ->exists();

            if ($departmentHasManager) {
                return response()->json(['data' => 1]);
            }
        }

        $password = $user->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'image' => $imagePath,
            'role' => $role,

        ]);

        $user->syncRoles([$role]);

        $employee->update([
            'clinic_id' => $request->clinic_id,
            'department_id' => $request->department_id,
            'job_title' => $request->job_title,
            'work_start_time' => $request->work_start_time,
            'work_end_time' => $request->work_end_time,
            'working_days' => $request->working_days,
            'status' => $request->status,
            'short_biography' => $request->short_biography,
        ]);

        if ($request->job_title === 'Doctor') {
            if ($employee->doctor) {
                $employee->doctor->update([
                    'speciality' => $request->speciality,
                    'qualification' => $request->qualification,
                    'rating' => $request->rating,
                    'consultation_fee' => $request->consultation_fee,
                ]);
            } else {
                Doctor::create([
                    'employee_id' => $employee->id,
                    'speciality' => $request->speciality,
                    'qualification' => $request->qualification,
                    'rating' => $request->rating,
                    'consultation_fee' => $request->consultation_fee,
                ]);
            }
        } else {
            // إذا لم يعد دكتورًا، احذف السجل المرتبط
            if ($employee->doctor) {
                $employee->doctor->delete();
            }
        }

        return response()->json(['data' => 2]); // تم التحديث بنجاح
    }






    public function deleteEmployee($id){
        $employee = Employee::findOrFail($id);
        $user = User::findOrFail($employee->user_id);
        $doctor = Doctor::where('employee_id', $employee->id)->first();
        if ($doctor) {
            $doctor->delete();
        }
        $employee->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }

}

