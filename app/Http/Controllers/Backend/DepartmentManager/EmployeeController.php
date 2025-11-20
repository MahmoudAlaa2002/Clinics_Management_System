<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller{

    public function viewEmployees(){
        $clinic_id = Auth::user()->employee->clinic->id;
        $department_id = Auth::user()->employee->department->id;
        $employees = Employee::where('user_id', '!=', Auth::id())->where('clinic_id' , $clinic_id)->where('department_id' , $department_id)->orderBy('id', 'asc')->paginate(12);
        return view ('Backend.departments_managers.employees.view' , compact('employees'));
    }




    public function searchEmployees(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinic_id     = Auth::user()->employee->clinic->id;
        $department_id = Auth::user()->employee->department->id;

        $query = Employee::with('user')->where('user_id', '!=', Auth::id())
                    ->where('clinic_id', $clinic_id)->where('department_id', $department_id);

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
        $html = view('Backend.departments_managers.employees.search', compact('employees'))->render();

        return response()->json([
            'html'       => $html,
            'count'      => $employees->total(),
            'searching'  => $keyword !== '',
            'pagination' => $employees->links('pagination::bootstrap-4')->render(),
        ]);
    }




    public function profileEmployee($id){
        $employee = Employee::findOrFail($id);
        return view('Backend.departments_managers.employees.profile', compact('employee'));
    }
}
