<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller{

    public function addEmployee(){
        $departments = Department::all();
        $clinics = Clinic::all();
        $jobTitles = JobTitle::all();
        return view('Backend.admin.employees.add' , compact('departments' , 'clinics' , 'jobTitles'));
    }


    public function storeEmployee(Request $request){
        $existingEmployee = User::where('name', $request->name)->where('email', $request->email)->first();

        if($existingEmployee){
            return response()->json(['data' => 0]);
        }else{

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'employees/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('employees'), $imageName);
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
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);

            $user->assignRole(['employee']);

            Employee::create([
                'clinic_id' => $request->clinic_id,
                'department_id' => $request->department_id,
                'job_title_id' => $request->job_title_id,
                'status' => $request->status,
                'user_id' => $user->id,
                'short_biography' => $request->short_biography,
            ]);

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
        $user = User::where('id', $employee->user_id)->first();

        if(User::where('name', $request->name)->where('id', '!=', $user->id)->exists() && User::where('email', $request->email)->where('id', '!=', $user->id)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $imageName = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'employees/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('employees'), $imageName);
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
                'image' => $imageName,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);

            $employee->update([
                'clinic_id' => $request->clinic_id,
                'department_id' => $request->department_id,
                'job_title_id' => $request->job_title_id,
                'status' => $request->status,
                'user_id' => $user->id,
                'short_biography' => $request->short_biography,
            ]);
            return response()->json(['data' => 1]);
        }
    }




    public function deleteEmployee($id){
        $employee = Employee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->first();
        $employee->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }
}
