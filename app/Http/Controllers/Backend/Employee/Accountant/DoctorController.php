<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use App\Models\Doctor;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller{

    public function viewDoctors(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $doctors = Doctor::whereHas('employee', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->with(['employee.user', 'employee.department'])->paginate(12);
        return view('Backend.employees.accountants.doctors.view', compact('doctors'));
    }





    public function searchDoctors(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinic_id     = Auth::user()->employee->clinic->id;

        $query = Doctor::with(['employee', 'employee.user', 'employee.department'])
            ->whereHas('employee', function ($q) use ($clinic_id) {
                $q->where('clinic_id', $clinic_id);
            });

        if ($keyword !== '') {

            switch ($filter) {

                case 'name':
                    $query->whereHas('employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', $keyword . '%');
                    });
                    break;

                case 'department_name':
                    $query->whereHas('employee.department', function ($q) use ($keyword) {
                        $q->where('name', 'like', $keyword . '%');
                    });
                    break;

                case 'status':
                    $query->whereHas('employee', function ($q) use ($keyword) {
                        $q->where('status', 'like', $keyword . '%');
                    });
                    break;

                default:
                    $query->where(function ($q) use ($keyword) {
                        $q->whereHas('employee.user', function ($qq) use ($keyword) {
                            $qq->where('name', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('employee', function ($qq) use ($keyword) {
                            $qq->where('status', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('employee.department', function ($qq) use ($keyword) {
                            $qq->where('name', 'like', '%' . $keyword . '%');
                        });
                    });
                    break;
            }
        }

        $doctors = $query->orderBy('id')->paginate(12);

        $html = view('Backend.employees.accountants.doctors.search', compact('doctors'))->render();

        return response()->json([
            'html'       => $html,
            'count'      => $doctors->total(),
            'searching'  => $keyword !== '',
            'pagination' => $doctors->links('pagination::bootstrap-4')->render(),
        ]);
    }






    public function profileDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $invoicesCount = Invoice::whereHas('appointment', function ($q) use ($doctor) {
            $q->where('doctor_id', $doctor->id);
        })->count();
        return view('Backend.employees.accountants.doctors.profile', compact('doctor' , 'invoicesCount'));
    }
}
