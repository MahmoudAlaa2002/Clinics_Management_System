<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller{


    public function viewPatients(){
        $clinicId = Auth::user()->employee->clinic_id;
        $patients = Patient::whereHas('appointments.clinicDepartment', function ($q) use ($clinicId) {
            $q->where('clinic_id', $clinicId);
        })->orderBy('id', 'asc')->paginate(12);
        return view('Backend.clinics_managers.patients.view' , compact('patients'));
    }





    public function searchPatients(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $patients = Patient::with('user:id,name,email,phone,address');

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $patients->whereHas('user', fn($q) => $q->where('name', 'like', "{$keyword}%"));
                    break;
            }
        }

        $patients   = $patients->orderBy('id')->paginate(12);
        $view       = view('Backend.clinics_managers.patients.search', compact('patients'))->render();
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
        return view('Backend.clinics_managers.patients.profile', compact('patient'));
    }


}
