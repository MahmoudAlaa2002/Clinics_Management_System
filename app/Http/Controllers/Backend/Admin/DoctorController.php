<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\EmployeeJobTitle;
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
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/doctors'), $imageName);
                $imagePath = 'assets/img/doctors/' . $imageName;
            } else {
                $imagePath = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $imagePath,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);
            $user->assignRole(['doctor']);

            $employee = Employee::create([
                'user_id' => $user->id,
                'clinic_id' => $request->clinic_id,
                'department_id' => $request->department_id,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'status' => $request->status,
                'short_biography' => $request->short_biography,
            ]);

            $job_title_Id = JobTitle::where('name', 'doctor')->pluck('id')->first();
            EmployeeJobTitle::create([
                'employee_id' => $employee->id,
                'job_title_id' => $job_title_Id ,
                'hire_date' => now()->toDateString(),
            ]);

            Doctor::create([
                'employee_id' => $employee->id,
                'qualification' => $request->qualification,
                'experience_years' => $request->experience_years,
                'specialty_id'       => $request->specialty_id,
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
            'specialty:id,name',
            'employee:id,user_id,working_days,status,clinic_id,department_id',
            'employee.user:id,name,address,image',
            'employee.clinic:id,name',
            'employee.department:id,name',
        ]);

        if ($keyword !== '') {
            switch ($filter) {
                case 'name': // البحث باسم المستخدم
                    $doctors->whereHas('employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'clinic': // البحث باسم العيادة
                    $doctors->whereHas('employee.clinic', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'department': // البحث باسم القسم
                    $doctors->whereHas('employee.department', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'status': // البحث حسب حالة الموظف
                    $doctors->whereHas('employee', function ($q) use ($keyword) {
                        $q->where('status', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'specialty': // البحث باسم التخصص
                    $doctors->whereHas('specialty', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'qualification': // البحث بالمؤهل العلمي
                    $doctors->where('qualification', 'LIKE', "{$keyword}%");
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
        $doctor = Doctor::with(['employee.user','employee.department','employee.clinic'])->findOrFail($id);

        // dd($doctor->employee->user->name);
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
            $imagePath = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/doctors'), $imageName);
                $imagePath = 'assets/img/doctors/' . $imageName;
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
                'image' => $imagePath,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);

            $employee->update([
                'user_id' => $user->id ,
                'clinic_id' => $request->clinic_id,
                'department_id' => $request->department_id,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'short_biography' => $request->short_biography,
            ]);

            $job_title_Id = JobTitle::where('name', 'doctor')->pluck('id')->first();
            EmployeeJobTitle::updateOrCreate(
                ['employee_id' => $employee->id],
                [
                    'job_title_id' => $job_title_Id,
                    'hire_date' => $request->hire_date ?? now()->toDateString(),
                ]
            );

            $doctor->update([
                'employee_id' => $employee->id ,
                'qualification' => $request->qualification,
                'experience_years' => $request->experience_years,
                'specialty_id'       => $request->specialty_id,
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


    public function getSpecialtiesByDepartment($department_id){
        $department = Department::with('specialties')->findOrFail($department_id);
        return response()->json($department->specialties);
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

        $workingDays = json_decode($doctor->employee->working_days, true);
        $times = [];

        foreach ($workingDays as $day) {
            $times[] = [
                'day' => $day,
                'from' => $doctor->employee->work_start_time,
                'to' => $doctor->employee->work_end_time,
            ];
        }

        return response()->json($times);
    }

    public function getWorkingDays($id) {
        $clinic = Clinic::findOrFail($id);
        return response()->json([
            'working_days' => $clinic->working_days,
        ]);
    }

}
