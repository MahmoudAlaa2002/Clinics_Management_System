<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;

class MedicalRecordController extends Controller{

    public function viewMedicalRecords(){
        $medical_records = MedicalRecord::orderBy('id', 'asc')->paginate(12);
        return view('Backend.clinics_managers.medical_records.view' , compact('medical_records'));
    }






    public function searchMedicalRecords(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        // العلاقات الضرورية
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

        $medical_records = $medical_records->orderBy('id', 'asc')->paginate(12);

        $view = view('Backend.clinics_managers.medical_records.search', compact('medical_records'))->render();
        $pagination = $medical_records->total() > 12
            ? $medical_records->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $medical_records->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function detailsMedicalRecord($id){
        $medical_record = MedicalRecord::findOrFail($id);
        return view ('Backend.clinics_managers.medical_records.details' , compact('medical_record'));
    }





    public function editMedicalRecord($id){
        $medical_record = MedicalRecord::findOrFail($id);
        return view ('Backend.clinics_managers.medical_records.edit' , compact('medical_record'));
    }





    public function updateMedicalRecord(Request $request, $id){
        $medical_record = MedicalRecord::findOrFail($id);
        $medical_record->update([
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'record_date' => $request->record_date,
            'prescriptions' => $request->prescriptions,
            'attachments'  => $request->attachments,
            'notes'  => $request->notes,
        ]);

        return response()->json(['data' => 1]);
    }





    public function deleteMedicalRecord($id){
        $medical_record = MedicalRecord::findOrFail($id);
        $medical_record->delete();
        return response()->json(['success' => true]);
    }
}
