<?php

namespace App\Http\Controllers\Backend\Admin;


use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialty;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller{

    public function addAppointment(){
        $patients = Patient::all();
        $clinics = Clinic::all();
        $departments = Department::all();
        $doctors = Doctor::all();
        return view('Backend.admin.appointments.add' , compact('patients' , 'clinics' , 'departments' , 'doctors'));
    }


    public function storeAppointment(Request $request){
        $selectedDay = $request->appointment_day;
        $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');

        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('appointment_date', $appointmentDate)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
         }else{
            $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');

            Appointment::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'clinic_department_id'  => $clinicDepartmentId,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewAppointments(){
        $appointments = Appointment::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.appointments.view' , compact('appointments'));
    }


    public function searchAppointments(Request $request){
        $keyword = $request->input('keyword');
        $filter = $request->input('filter');

        $appointments = Appointment::with(['patient', 'clinic', 'department', 'doctor']);

        if ($keyword) {
            switch ($filter) {
                case 'patient':
                    $appointments->whereHas('patient', fn($q) => $q->where('name', 'like', "$keyword%"));
                    break;
                case 'clinic':
                    $appointments->whereHas('clinic', fn($q) => $q->where('name', 'like', "$keyword%"));
                    break;
                case 'department':
                    $appointments->whereHas('specialty', fn($q) => $q->where('name', 'like', "$keyword%"));
                    break;
                case 'doctor':
                    $appointments->whereHas('doctor', fn($q) => $q->where('name', 'like', "$keyword%"));
                    break;
                case 'date':
                    $appointments->where('appointment_date', 'like', "$keyword%");
                    break;
                case 'status':
                    $appointments->where('status', 'like', "$keyword%");
                    break;
            }
        }

        $appointments = $appointments->orderBy('id')->paginate(12);
        $count = $appointments->count();

        $view = view('Backend.admin.appointments.searchAppointment', compact('appointments'))->render();
        $pagination = $appointments->total() > 12 ? $appointments->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html' => $view,
            'pagination' => $pagination,
            'count' => $appointments->total(),
            'searching' => !empty($keyword)
        ]);
    }





    public function descriptionAppointment($id){
        $appointment = Appointment::findOrFail($id);
        return view('Backend.admin.appointments.description', compact('appointment' ));
    }





    public function editAppointment($id){
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::all();
        $clinics = Clinic::all();
        return view('Backend.admin.appointments.edit', compact('patients' , 'appointment' ,'clinics'));
    }


    public function updateAppointment(Request $request, $id){
        $selectedDay = $request->appointment_day;
        $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();

        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->where('appointment_date', $appointmentDate)
            ->where('appointment_time', $request->appointment_time)
            ->where('id', '!=', $id) // تجاهل الموعد الحالي
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        } else {
            $appointment = Appointment::findOrFail($id);
            $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');
            $appointment->update([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'clinic_department_id'  => $clinicDepartmentId,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function deleteAppointment($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(['success' => true]);
    }
}
