<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller{

    public function addDoctor(){
        $clinic = Auth::user()->employee->clinic;
        $departments = $clinic->departments;
        $opening_time = $clinic->opening_time;
        $closing_time = $clinic->closing_time;
        $working_days = $clinic->working_days ?? [];
        return view('Backend.clinics_managers.doctors.add', compact(
            'clinic',
            'departments',
            'opening_time',
            'closing_time',
            'working_days',
        ));
    }


    public function storeDoctor(Request $request){
        $normalizedName = strtolower(trim($request->name));
        $normalizedEmail = strtolower(trim($request->email));
        $existingUser = User::whereRaw('LOWER(name) = ?', [$normalizedName])->orWhereRaw('LOWER(email) = ?', [$normalizedEmail])->first();

        if ($existingUser) {
            return response()->json(['data' => 0]);
        } else {

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
                'role' => 'doctor',
            ]);
            $user->assignRole(['doctor']);

            $employee = Employee::create([
                'user_id' => $user->id,
                'clinic_id' => $request->clinic_id,
                'department_id' => $request->department_id,
                'job_title' => 'Doctor',
                'hire_date' => now()->toDateString(),
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'status' => $request->status,
                'short_biography' => $request->short_biography,
            ]);

            Doctor::create([
                'employee_id' => $employee->id,
                'speciality'   => $request->speciality,
                'qualification' => $request->qualification,
                'consultation_fee'       => $request->consultation_fee,
                'rating' => $request->rating,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewDoctors(){
        $clinicId = Auth::user()->employee->clinic_id;
        $doctors = Doctor::whereHas('employee', function ($query) use ($clinicId) {
            $query->where('clinic_id', $clinicId);
        })->orderBy('id', 'asc')->paginate(12);
        return view('Backend.clinics_managers.doctors.view' , compact('doctors'));
    }





    public function searchDoctors(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId = Auth::user()->employee->clinic_id;

        $doctors = Doctor::with([
            'employee:id,user_id,job_title,status,clinic_id,department_id',
            'employee.user:id,name,address,image',
            'employee.department:id,name',
        ])
        ->whereHas('employee', function ($query) use ($clinicId) {
            $query->where('clinic_id', $clinicId);
        });

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $doctors->whereHas('employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'department':
                    $doctors->whereHas('employee.department', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'status':
                    $doctors->whereHas('employee', function ($q) use ($keyword) {
                        $q->where('status', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'job':
                    $doctors->whereHas('employee', function ($q) use ($keyword) {
                        $q->where('job_title', 'LIKE', "{$keyword}%");
                    });
                    break;

                case 'speciality':
                    $doctors->where('speciality', 'LIKE', "{$keyword}%");
                    break;

                case 'qualification':
                    $doctors->where('qualification', 'LIKE', "{$keyword}%");
                    break;

                default:
                    // 🔍 بحث عام
                    $doctors->where(function ($q) use ($keyword) {
                        $q->where('speciality', 'LIKE', "%{$keyword}%")
                        ->orWhere('qualification', 'LIKE', "%{$keyword}%")
                        ->orWhereHas('employee', function ($qq) use ($keyword) {
                            $qq->where('job_title', 'LIKE', "%{$keyword}%")
                               ->orWhere('status', 'LIKE', "%{$keyword}%");
                        })
                        ->orWhereHas('employee.user', function ($qq) use ($keyword) {
                            $qq->where('name', 'LIKE', "%{$keyword}%");
                        })
                        ->orWhereHas('employee.department', function ($qq) use ($keyword) {
                            $qq->where('name', 'LIKE', "%{$keyword}%");
                        });
                    });
                    break;
            }
        }

        $doctors = $doctors->orderBy('id')->paginate(12);

        $view = view('Backend.clinics_managers.doctors.search', compact('doctors'))->render();
        $pagination = $doctors->total() > 12 ? $doctors->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $doctors->total(),
            'searching'  => $keyword !== '',
        ]);
    }








    public function profileDoctor($id){
        $doctor = Doctor::findOrFail($id);
        return view('Backend.clinics_managers.doctors.profile', compact('doctor'));
    }





    public function editDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $employee = Employee::where('id', $doctor->employee_id)->first();
        $user = $employee ? User::where('id', $employee->user_id)->first() : null;
        $clinic = Auth::user()->employee->clinic;
        $departments = $clinic->departments;
        $opening_time = $clinic->opening_time;
        $closing_time = $clinic->closing_time;
        $working_days = $clinic->working_days ?? [];
        return view('Backend.clinics_managers.doctors.edit', compact('doctor',
            'clinic',
            'departments',
            'opening_time',
            'closing_time',
            'working_days',
        ));
    }


    public function updateDoctor(Request $request, $id){
        $doctor = Doctor::findOrFail($id);
        $employee = Employee::findOrFail($doctor->employee_id);
        $user = User::findOrFail($employee->user_id);

        $normalizedName = strtolower(trim($request->name));
        $normalizedEmail = strtolower(trim($request->email));

        $existingUser = User::whereRaw('LOWER(name) = ?', [$normalizedName])
            ->where('id', '!=', $user->id)->orWhereRaw('LOWER(email) = ?', [$normalizedEmail])->where('id', '!=', $user->id)->first();

        if ($existingUser) {
            return response()->json(['data' => 0]); // موجود مسبقاً
        }

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/doctors'), $imageName);
            $newPath = 'assets/img/doctors/' . $imageName;

            // حذف الصورة القديمة إذا وجدت
            if ($user->image && file_exists(public_path($user->image))) {
                @unlink(public_path($user->image));
            }
            $imagePath = $newPath;
        }

        $password = $user->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'address' => $request->address,
            'image' => $imagePath,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'role' => 'doctor',
        ]);

        $employee->update([
            'clinic_id' => $request->clinic_id,
            'department_id' => $request->department_id,
            'job_title' => 'Doctor',
            'work_start_time' => $request->work_start_time,
            'work_end_time' => $request->work_end_time,
            'working_days' => $request->working_days,
            'status' => $request->status,
            'short_biography' => $request->short_biography,
        ]);

        $doctor->update([
            'speciality' => $request->speciality,
            'qualification' => $request->qualification,
            'consultation_fee' => $request->consultation_fee,
            'rating' => $request->rating,
        ]);

        return response()->json(['data' => 1]); // تم التحديث بنجاح
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










    public function searchSchedules(){
        $clinic = Auth::user()->employee->clinic;
        $departments = $clinic->departments;
        $doctors = $clinic->employees()->whereHas('doctor')->with('doctor.employee.user')->get()->pluck('doctor');
        return view('Backend.clinics_managers.doctors.schedules', compact('clinic', 'departments', 'doctors'));
    }


    public function searchDoctchedule(Request $request){
        $clinic_id = $request->clinic_id;
        $department_id = $request->department_id;
        $doctor_id = $request->doctor_id;
        $offset = (int) ($request->offset ?? 0);

        $clinic = Auth::user()->employee->clinic;
        $departments = $clinic->departments;
        $doctors = $clinic->employees()->whereHas('doctor')->with('doctor.employee.user')->get()->pluck('doctor');

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addWeeks($offset);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->addWeeks($offset);

        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();

        return view('Backend.clinics_managers.doctors.schedules', [
            'appointments' => $appointments,
            'selectedDoctor' => Doctor::find($doctor_id),
            'clinic' => $clinic,
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
}
