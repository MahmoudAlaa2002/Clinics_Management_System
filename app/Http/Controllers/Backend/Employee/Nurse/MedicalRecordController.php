<?php

namespace App\Http\Controllers\Backend\Employee\Nurse;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller{

    public function viewMedicalRecords(){
        $clinicId = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $medical_records = MedicalRecord::with(['appointment', 'appointment.patient'])
            ->whereHas('appointment.clinicDepartment', function ($q) use ($clinicId, $departmentId) {
                $q->where('clinic_id', $clinicId)
                ->where('department_id', $departmentId);
            })->orderBy('id', 'asc')->paginate(12);

        return view ('Backend.employees.nurses.medical_records.view' , compact('medical_records'));
    }




    public function searchMedicalRecords(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId     = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $records = MedicalRecord::with([
            'appointment:id,doctor_id,patient_id',
            'doctor.employee.user:id,name',
            'patient.user:id,name'
        ])
        ->whereHas('appointment.clinicDepartment', function ($q) use ($clinicId, $departmentId) {
            $q->where('clinic_id', $clinicId)
            ->where('department_id', $departmentId);
        });


        if ($keyword !== '') {
            switch ($filter) {

                case 'doctor_name':
                    $records->whereHas('doctor.employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'patient_name':
                    $records->whereHas('patient.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'record_date':
                    $records->where('record_date', 'like', "{$keyword}%");
                    break;
            }
        }

        $records = $records->orderBy('id', 'asc')->paginate(12);
        $view = view('Backend.employees.nurses.medical_records.search',['medical_records' => $records])->render();
        $pagination = $records->total() > 12 ? $records->links('pagination::bootstrap-4')->render(): '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $records->total(),
            'searching'  => ($keyword !== ''),
        ]);
    }





    public function detailsMedicalRecord($id){
        $medical_record = MedicalRecord::findOrFail($id);
        return view('Backend.employees.nurses.medical_records.details' , compact('medical_record'));
    }

}
