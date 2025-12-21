<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Models\Employee;
use App\Models\NurseTask;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Events\NurseTaskAssigned;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\employee\nurse\TasksNotification;

class NurseTaskController extends Controller {

    public function assignTask($appointmentId, $nurseId) {
        $appointment = Appointment::with(['patient.user'])->findOrFail($appointmentId);
        $nurse = Employee::with(['user', 'department'])->findOrFail($nurseId);

        return view('Backend.doctors.nurses_tasks.show',compact('appointment', 'nurse')
        );
    }



    public function assignTaskStore(Request $request) {
        $task = NurseTask::create([
            'appointment_id' => $request->appointment_id,
            'nurse_id'       => $request->nurse_id,
            'task'           => $request->task,
            'notes'          => $request->notes,
            'status'         => 'Pending',
        ]);

        NurseTaskAssigned::dispatch($task);

        return response()->json(['success'=> true]);
    }




    public function detailsTask(){
        $doctorId = Auth::user()->employee->doctor->id;

        $tasks = NurseTask::whereHas('appointment', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })->with([
                'nurse.user',              // اسم الممرض
                'appointment.patient.user' // اسم المريض
            ])->orderBy('id', 'desc')->get();

        return view('Backend.doctors.nurses_tasks.index', compact('tasks'));
    }
}
