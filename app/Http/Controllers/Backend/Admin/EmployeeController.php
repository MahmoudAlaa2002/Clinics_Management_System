<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\EmployeeJobTitle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller{

    public function addEmployee(){
        $departments = Department::all();
        $clinics     = Clinic::select('id', 'name')->get(); // فقط ID واسم العيادة
        $job_titles  = JobTitle::all();
        $doctors     = Doctor::with('employee')->get();

        return view('Backend.admin.employees.add', compact(
            'departments',
            'clinics',
            'job_titles',
            'doctors'
        ));
    }


    public function storeEmployee(Request $request){
        $existingEmployee = User::where('name', $request->name)->where('email', $request->email)->first();
        if($existingEmployee){
            return response()->json(['data' => 0]);
        }else{

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/employees'), $imageName);
                $imagePath = 'assets/img/employees/' . $imageName;
            } else {
                $imagePath = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->filled('address') ? $request->address : null,
                'image' => $imagePath,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);


            $employee = Employee::create([
                'user_id' => $user->id,
                'clinic_id' => $request->clinic_id,
                'department_id' => $request->department_id,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'status' => $request->status,
                'short_biography' => $request->short_biography,
            ]);


            if(is_array($request->job_title_id)){
                foreach($request->job_title_id as $job_id){
                    EmployeeJobTitle::create([
                        'employee_id' => $employee->id,
                        'job_title_id' => $job_id,
                        'hire_date' => now()->toDateString(),
                    ]);
                }
            }

            if(is_array($request->job_title_id) && in_array(3, $request->job_title_id)){
                Doctor::create([
                    'employee_id' => $employee->id,
                ]);
            }

            if ($request->job_title_id) {
                $jobTitles = JobTitle::whereIn('id', $request->job_title_id)->pluck('name')->toArray();

                $roles = [];

                if (in_array('Clinic Manager', $jobTitles)) {
                    $roles[] = 'clinic_manager';
                }

                if (in_array('Department Manager', $jobTitles)) {
                    $roles[] = 'department_manager';
                }

                if (in_array('Doctor', $jobTitles)) {
                    $roles[] = 'doctor';
                }

                if (array_intersect(['Receptionist', 'Nurse', 'Accountant', 'Pharmacist', 'Store Supervisor'], $jobTitles)) {
                    $roles[] = 'employee';
                }

                $user->syncRoles($roles); // يحفظ كل الأدوار دفعة وحدة
            }


            return response()->json(['data' => 1]);
        }
    }





    public function viewEmployees(){
        $employees = Employee::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.employees.view' , compact('employees'));
    }





    public function profileEmployee($id){
        $employee = Employee::findOrFail($id);
        return view('Backend.admin.employees.profile', compact('employee'));
    }





    public function editEmployee($id){
        $employee = Employee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->first();
        $departments = Department::all();
        $clinics = Clinic::all();
        $jobTitles = JobTitle::all();
        return view('Backend.admin.employees.edit', compact('employee' , 'user' , 'departments' , 'clinics' , 'jobTitles'));
    }


    public function updateEmployee(Request $request, $id){
        $employee = Employee::findOrFail($id);
        $user = User::findOrFail($employee->user_id);

        if (User::where('name', $request->name)->where('id', '!=', $user->id)->exists() || User::where('email', $request->email)->where('id', '!=', $user->id)->exists()) {
            return response()->json(['data' => 0]);
        }

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/employees'), $imageName);
            $imagePath = 'assets/img/employees/' . $imageName;
        }

        $password = $user->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'phone' => $request->phone,
            'address' => $request->filled('address') ? $request->address : null,
            'image' => $imagePath,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        $employee->update([
            'clinic_id' => $request->clinic_id,
            'department_id' => $request->department_id,
            'work_start_time' => $request->work_start_time,
            'work_end_time' => $request->work_end_time,
            'working_days' => $request->working_days,
            'status' => $request->status,
            'short_biography' => $request->short_biography,
        ]);

        if (is_array($request->job_title_id)) {
            $currentJobTitles = EmployeeJobTitle::where('employee_id', $employee->id)->pluck('job_title_id')->toArray();

            foreach ($request->job_title_id as $job_id) {
                EmployeeJobTitle::updateOrCreate(
                    ['employee_id' => $employee->id, 'job_title_id' => $job_id],
                    ['hire_date' => in_array($job_id, $currentJobTitles)
                        ? EmployeeJobTitle::where('employee_id', $employee->id)->where('job_title_id', $job_id)->value('hire_date')
                        : now()->toDateString()
                    ]
                );
            }

            EmployeeJobTitle::where('employee_id', $employee->id)
                ->whereNotIn('job_title_id', $request->job_title_id)
                ->delete();
        }

        if (is_array($request->job_title_id) && in_array(3, $request->job_title_id)) {
            Doctor::updateOrCreate(
                ['employee_id' => $employee->id],
            );
        } else {
            Doctor::where('employee_id', $employee->id)->delete();
        }

        if ($request->job_title_id) {
            $jobTitles = JobTitle::whereIn('id', $request->job_title_id)->pluck('name')->toArray();

            $roles = [];

            if (in_array('Clinic Manager', $jobTitles)) {
                $roles[] = 'clinic_manager';
            }

            if (in_array('Department Manager', $jobTitles)) {
                $roles[] = 'department_manager';
            }

            if (in_array('Doctor', $jobTitles)) {
                $roles[] = 'doctor';
            }

            if (array_intersect(['Receptionist', 'Nurse', 'Accountant', 'Pharmacist', 'Store Supervisor'], $jobTitles)) {
                $roles[] = 'employee';
            }

            $user->syncRoles($roles);
        }

        return response()->json(['data' => 1]);
    }





    public function deleteEmployee($id){
        $employee = Employee::findOrFail($id);
        $user = User::findOrFail($employee->user_id);
        Doctor::where('employee_id', $employee->id)->delete();
        EmployeeJobTitle::where('employee_id', $employee->id)->delete();
        $employee->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }
}
