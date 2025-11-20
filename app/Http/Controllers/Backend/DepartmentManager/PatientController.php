<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller{

    public function viewPatients(){
        $clinicId = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $patients = Patient::whereHas('appointments.clinicDepartment', function ($q) use ($clinicId , $departmentId) {
            $q->where('clinic_id', $clinicId)
              ->where('department_id', $departmentId);
        })->orderBy('id', 'asc')->paginate(12);
        return view('Backend.departments_managers.patients.view' , compact('patients'));
    }





    public function searchPatients(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $patients = Patient::with('user:id,name,email,phone,address')
            ->whereHas('appointments.clinicDepartment', function ($q) use ($clinicId , $departmentId) {
                $q->where('clinic_id', $clinicId)
                  ->where('department_id', $departmentId);
            });

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $patients->whereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;
            }
        }

        $patients   = $patients->orderBy('id')->paginate(12);
        $view       = view('Backend.departments_managers.patients.search', compact('patients'))->render();
        $pagination = $patients->total() > 12 ? $patients->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $patients->total(),
            'searching'  => $keyword !== '',
        ]);
    }






    public function profilePatient($id){
        $patient = Patient::findOrFail($id);
        return view('Backend.departments_managers.patients.profile', compact('patient'));
    }
}
