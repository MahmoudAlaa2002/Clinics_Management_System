<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller{

    public function addDoctor(){
        $clinics = Clinic::all();
        return view('Backend.admin.doctors.add' , compact('clinics'));
    }


    public function storeDoctor(Request $request){
        if(User::where('name', $request->name)->exists() && User::where('email', $request->email)->exists()){
            return response()->json(['data' => 0]);
        }else{

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'doctors/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            } else {
                $imageName = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $imageName,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);
            $user->assignRole(['doctor']);

            $employee = Employee::create([
                'user_id' => $user->id,
                'clinic_id' => $request->clinic_id,
                'job_title_id' => 3,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'hire_date' => now()->toDateString(),
                'status' => $request->status,
                'short_biography' => $request->short_biography,
            ]);

            $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');
            Doctor::create([
                'employee_id' => $employee->id,
                'clinic_department_id' => $clinicDepartmentId,
                'qualification' => $request->qualification,
                'experience_years' => $request->experience_years,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewDoctors(){
        $doctors = Doctor::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.doctors.view' , compact('doctors'));
    }





    public function searchDoctors(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $doctors = Doctor::with([
            'clinicDepartment.clinic:id,name',
            'clinicDepartment.department:id,name',
            'employee:id,user_id,working_days,status',
            'employee.user:id,name,address',
        ]);

        if ($keyword !== '') {
            $lowerKeyword = strtolower($keyword);

            switch ($filter) {
                case 'name':
                    $doctors->whereHas('employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', $keyword.'%');
                    });
                    break;

                case 'clinic':
                    $doctors->whereHas('clinicDepartment.clinic', function ($q) use ($keyword) {
              $q->where('name', 'LIKE', $keyword.'%');
                    });
                    break;

                case 'department':
                    $doctors->whereHas('clinicDepartment.department', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', $keyword.'%');
                    });
                    break;

                case 'status':
                    $doctors->whereHas('employee', function ($q) use ($keyword) {
                        $q->where('status', 'LIKE', $keyword.'%');
                    });
                    break;
            }
        }

        $doctors = $doctors->orderBy('id')->paginate(12);
        $view = view('Backend.admin.doctors.searchDoctor', compact('doctors'))->render();
        $pagination = $doctors->total() > 12 ? $doctors->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $doctors->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function profileDoctor($id){
        $doctor = Doctor::with(['clinic','department','employee'])->findOrFail($id);
        return view('Backend.admin.doctors.profile', compact('doctor'));
    }





    public function editDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $employee = Employee::where('id', $doctor->employee_id)->first();
        $user = $employee ? User::where('id', $employee->user_id)->first() : null;
        $clinics = Clinic::all();
        $departments = Department::all();
        $working_days = $doctor->employee->working_days ?? [];
        return view('Backend.admin.doctors.edit', compact('doctor', 'user', 'departments', 'clinics', 'working_days'));
    }


    public function updateDoctor(Request $request, $id){
        $doctor = Doctor::findOrFail($id);
        $employee = Employee::where('id', $doctor->employee_id)->first();
        $user = $employee ? User::where('id', $employee->user_id)->first() : null;

        $currentUserId = $doctor->employee->user_id;
        if (User::where('name', $request->name)->where('id', '!=', $currentUserId)->exists() || User::where('email', $request->email)->where('id', '!=', $currentUserId)->exists()) {
            return response()->json(['data' => 0]);
        }else{
            $imageName = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'doctors/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            }


            $password = $user->password;
            if ($request->filled('password')) {
                $password = Hash::make($request->password);
            }

            $user->update([
                'name' => $request->name ,
                'email' => $request->email ,
                'phone' => $request->phone,
                'password' => $password,
                'image' => $imageName,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);

            $employee->update([
                'user_id' => $user->id ,
                'clinic_id' => $request->clinic_id ,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'hire_date' => $request->hire_date,
                'short_biography' => $request->short_biography,
            ]);

            $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');

            $doctor->update([
                'employee_id' => $employee->id ,
                'clinic_department_id' => $clinicDepartmentId ,
                'qualification' => $request->qualification,
                'experience_years' => $request->experience_years,
            ]);

            return response()->json(['data' => 1]);
        }
    }




    public function deleteDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $employee = Employee::where('id', $doctor->employee_id)->first();
        $user = $employee ? User::where('id', $employee->user_id)->first() : null;

        $doctor->delete();
        $employee->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }










    public function searchDoctorSchedules(){
        $clinics = Clinic::all();
        $departments = Department::all();
        $doctors = Doctor::all();
        return view('Backend.admin.doctors.schedules', compact('clinics', 'departments', 'doctors'));
    }


    public function searchDoctchedules(Request $request){
        $doctor_id = $request->doctor_id;
        $clinic_id = $request->clinic_id;
        $department_id = $request->department_id;
        $offset = (int) ($request->offset ?? 0);

        $clinics = Clinic::all();
        $departments = Department::all();
        $doctors = Doctor::all();

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addWeeks($offset);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->addWeeks($offset);

        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();

        return view('Backend.admin.doctors.schedules', [
            'appointments' => $appointments,
            'selectedDoctor' => Doctor::find($doctor_id),
            'clinics' => $clinics,
            'departments' => $departments,
            'doctors' => $doctors,
            'clinic_id' => $clinic_id,
            'department_id' => $department_id,
            'doctor_id' => $doctor_id,
            'offset' => $offset,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
        ]);
    }




    public function getDepartmentsByClinic($clinic_id){
        $clinic = Clinic::with('departments')->find($clinic_id);
        if (!$clinic) {
            return response()->json([]);
        }
        return response()->json($clinic->departments);
    }


    public function getClinicInfo($id){
        $clinic = Clinic::findOrFail($id);
        return response()->json([
            'opening_time' => $clinic->opening_time,
            'closing_time' => $clinic->closing_time,
        ]);
    }


    public function getWorkingTimes($doctor_id){
        $doctor = Doctor::findOrFail($doctor_id);

        $workingDays = json_decode($doctor->working_days, true);
        $times = [];

        foreach ($workingDays as $day) {
            $times[] = [
                'day' => $day,
                'from' => $doctor->work_start_time,
                'to' => $doctor->work_end_time,
            ];
        }

        return response()->json($times);
    }

    public function getWorkingDays($id) {
        $clinic = Clinic::findOrFail($id);
        return response()->json(json_decode($clinic->working_days));
    }

}
