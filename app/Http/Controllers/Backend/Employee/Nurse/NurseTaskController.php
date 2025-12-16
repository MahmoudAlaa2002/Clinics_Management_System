<?php

namespace App\Http\Controllers\Backend\Employee\Nurse;

use Carbon\Carbon;
use App\Models\NurseTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NurseTaskController extends Controller{

    public function viewNurseTasks(){
        $nurse_id = Auth::user()->employee->id;
        $nurse_tasks = NurseTask::where('nurse_id' , $nurse_id)->orderBy('id', 'asc')->paginate(12);
        return view('Backend.employees.nurses.nurse_tasks.view' , compact('nurse_tasks'));
    }




    public function searchNurseTasks(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId     = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $tasks = NurseTask::with([
            'appointment.doctor.employee.user:id,name',
            'appointment.patient.user:id,name',
        ])
        ->whereHas('appointment.clinicDepartment', function ($q) use ($clinicId, $departmentId) {
            $q->where('clinic_id', $clinicId)
            ->where('department_id', $departmentId);
        });

        if ($keyword !== '') {
            switch ($filter) {

                case 'doctor_name':
                    $tasks->whereHas('appointment.doctor.employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'patient_name':
                    $tasks->whereHas('appointment.patient.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'performed_at':
                    $tasks->where('performed_at', 'like', "{$keyword}%");
                    break;

                case 'status':
                    $tasks->where('status', 'like', "{$keyword}%");
                    break;
            }
        }

        $tasks = $tasks->orderBy('id', 'asc')->paginate(12);

        $view = view('Backend.employees.nurses.nurse_tasks.search', [
            'nurse_tasks' => $tasks
        ])->render();

        $pagination = $tasks->total() > 12
            ? $tasks->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $tasks->total(),
            'searching'  => ($keyword !== ''),
        ]);
    }





    public function detailsNurseTask($id){
        $task = NurseTask::findOrFail($id);
        return view('Backend.employees.nurses.nurse_tasks.details' , compact('task'));
    }




    public function completedNurseTask($id){
        $nurse_task = NurseTask::findOrFail($id);
        $nurse_task->update([
            'performed_at' => Carbon::now(),
            'status' => 'Completed',
        ]);

        return response()->json(['data' => 1]);
    }
}
