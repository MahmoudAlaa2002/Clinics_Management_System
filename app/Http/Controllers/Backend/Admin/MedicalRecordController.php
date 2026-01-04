<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;

class MedicalRecordController extends Controller{

    public function viewMedicalRecords(){
        $medical_records = MedicalRecord::orderBy('id', 'asc')->paginate(50);
        return view('Backend.admin.medical_records.view' , compact('medical_records'));
    }





    public function searchMedicalRecords(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $medical_records = MedicalRecord::with([
            'patient.user',
            'doctor.employee.user',
            'appointment.clinicDepartment.clinic'
        ]);

        if ($keyword !== '') {
            switch ($filter) {

                case 'appointment_id':
                    $medical_records->where('appointment_id', 'like', "{$keyword}%");
                    break;

                case 'patient_name':
                    $medical_records->whereHas('patient.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'doctor_name':
                    $medical_records->whereHas('doctor.employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'clinic_name':
                    $medical_records->whereHas('appointment.clinicDepartment.clinic', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'diagnosis':
                    $medical_records->where('diagnosis', 'like', "{$keyword}%");
                    break;

                case 'record_date':
                    $medical_records->where('record_date', 'like', "{$keyword}%");
                    break;

                default:
                    $medical_records->where(function ($q) use ($keyword) {
                        $q->where('record_date', 'like', "%{$keyword}%")
                          ->orWhere('diagnosis', 'like', "%{$keyword}%")
                          ->orWhere('treatment', 'like', "%{$keyword}%")
                          ->orWhereHas('patient.user', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"))
                          ->orWhereHas('doctor.employee.user', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"))
                          ->orWhereHas('appointment.clinicDepartment.clinic', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"));
                    });
                    break;
            }
        }

        $medical_records = $medical_records->orderBy('id', 'asc')->paginate(50);

        $view = view('Backend.admin.medical_records.search', compact('medical_records'))->render();
        $pagination = ($medical_records->total() > $medical_records->perPage()) ? $medical_records->links('pagination::bootstrap-4')->render() : '';


        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $medical_records->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function detailsMedicalRecord($id){
        $medical_record = MedicalRecord::with([
            'patient.user',
            'doctor.employee.user',
            'appointment.clinicDepartment.clinic'
        ])->findOrFail($id);
        return view ('Backend.admin.medical_records.details' , compact('medical_record'));
    }


}
