<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ClinicController extends Controller{

    public function addClinic(){
        $departments = Department::all();
        return view('Backend.admin.clinics.add' , compact('departments'));
    }


    public function storeClinic(Request $request){
        $normalizedName = strtolower(trim($request->name));
        $normalizedEmail = strtolower(trim($request->email));

        if (Clinic::whereRaw('LOWER(name) = ?', [$normalizedName])->exists() || Clinic::whereRaw('LOWER(email) = ?', [$normalizedEmail])->exists()) {
            return response()->json(['data' => 0]);
        }

        $clinic = Clinic::create([
            'name'          => $request->name,
            'location'      => $request->location,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'opening_time'  => $request->opening_time,
            'closing_time'  => $request->closing_time,
            'working_days'  => $request->working_days,
            'description'   => $request->description,
            'status'        => $request->status,
        ]);

        $departmentIds = $request->input('departments', []);
        $clinic->departments()->sync($departmentIds);

        return response()->json(['data' => 1]);
    }





    public function viewClinics(){
        $clinics = Clinic::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.clinics.view' , compact('clinics'));
    }





    public function searchClinics(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinics = Clinic::query();

        if ($keyword !== '') {
            switch ($filter) {
                case 'clinic':$clinics->where('name', 'like', "{$keyword}%");break;

                case 'location': $clinics->where('location', 'like', "{$keyword}%");break;

                case 'status': $clinics->where('status', 'like', "{$keyword}%");break;

                default:
                    $clinics->where(function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%")
                        ->orWhere('location', 'like', "{$keyword}%")
                        ->orWhere('status', 'like', "{$keyword}%");
                    });
                    break;
            }
        }

        $clinics    = $clinics->orderBy('id', 'asc')->paginate(10);
        $view       = view('Backend.admin.clinics.searchClinic', compact('clinics'))->render();
        $pagination = ($clinics->total() > $clinics->perPage()) ? $clinics->links('pagination::bootstrap-4')->render() : '';
        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $clinics->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function detailsClinic($id){
        $clinic = Clinic::findOrFail($id);
        $clinic_manager = Employee::where('clinic_id', $clinic->id)->where('job_title', 'Clinic Manager')->first();
        $doctors_count = Doctor::whereHas('employee', function($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->count();

        $patients_count = $clinic->appointments()->distinct('patient_id')->count('patient_id');
        return view('Backend.admin.clinics.details' , compact('clinic' ,
         'clinic_manager',
         'doctors_count',
         'patients_count',
        ));
    }





    public function editClinic($id){
        $clinic = Clinic::with(['departments'])->findOrFail($id);
        $working_days = $clinic->working_days ;
        $all_departments = Department::all();
        $clinic_departments = $clinic->departments->pluck('id')->toArray();
        return view('Backend.admin.clinics.edit', compact('clinic','working_days','all_departments','clinic_departments' ));
    }


    public function updateClinic(Request $request, $id){
        $normalizedName = strtolower(trim($request->name));
        $normalizedEmail = strtolower(trim($request->email));

        $exists = Clinic::where(function ($query) use ($normalizedName, $normalizedEmail) {
                $query->whereRaw('LOWER(name) = ?', [$normalizedName])
                      ->orWhereRaw('LOWER(email) = ?', [$normalizedEmail]);
            })->where('id', '!=', $id)->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $clinic = Clinic::findOrFail($id);
        $clinic->update([
            'name'          => $request->name,
            'location'      => $request->location,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'opening_time'  => $request->opening_time,
            'closing_time'  => $request->closing_time,
            'description'   => $request->description,
            'status'        => $request->status,
            'working_days'  => $request->working_days,
        ]);

        $clinic->departments()->sync($request->input('departments', []));
        return response()->json(['data' => 1]);
    }




    public function deleteClinic($id){
        $clinic = Clinic::findOrFail($id);
        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinic->id)->pluck('id');
        $employeeIds = Employee::where('clinic_id', $clinic->id)->pluck('id');
        $doctorIds = Doctor::whereIn('employee_id', $employeeIds)->pluck('id');
        $userIds = Employee::whereIn('id', $employeeIds)->pluck('user_id');

        Doctor::whereIn('id', $doctorIds)->delete();
        Employee::whereIn('id', $employeeIds)->delete();
        User::whereIn('id', $userIds)->delete();

        ClinicDepartment::whereIn('id', $clinicDepartmentIds)->delete();
        $clinic->delete();
        return response()->json(['success' => true]);
    }












    public function viewClinicsManagers(){
        $clinics_managers = User::role('clinic_manager')->with('employee.clinic')->paginate(12);
        return view('Backend.admin.clinics.clinics_managers.view' , compact('clinics_managers'));
    }






    public function searchClinicsManagers(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $query = User::role('clinic_manager')->with('employee.clinic');

        if ($keyword !== '') {
            if ($filter === 'clinic') {

                $query->whereHas('employee.clinic', function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword.'%');
                });
            } elseif ($filter === 'name') {

                $query->where('name', 'like', $keyword.'%');
            } else {

                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%'.$keyword.'%')
                    ->orWhereHas('employee.clinic', function ($qq) use ($keyword) {
                        $qq->where('name', 'like', '%'.$keyword.'%');
                    });
                });
            }
        }

        $clinics_managers = $query->orderBy('id')->paginate(12);
        $html = view('Backend.admin.clinics.clinics_managers.searchClinicsManagers', compact('clinics_managers'))->render();

        return response()->json([
            'html'       => $html,
            'count'      => $clinics_managers->total(),
            'searching'  => $keyword !== '',
            'pagination' => $clinics_managers->links('pagination::bootstrap-4')->render(),
        ]);
    }





    public function profileClinicsManagers($id){
        $clinic_manager = User::with('employee.clinic')->findOrFail($id);
        return view('Backend.admin.clinics.clinics_managers.profile', compact('clinic_manager'));
    }






    public function editClinicsManagers($id){
        $clinic_manager = User::with('employee.clinic')->findOrFail($id);
        $clinics = Clinic::all();
        $working_days = $clinic_manager->employee->working_days ?? [];
        return view('Backend.admin.clinics.clinics_managers.edit', compact('clinic_manager', 'clinics', 'working_days'));
    }



    public function updateClinicsManagers(Request $request, $id){
        $clinic_manager = User::findOrFail($id);
        $employee = Employee::where('user_id', $clinic_manager->id)->first();

        $normalizedEmail = strtolower(trim($request->email));
        if (User::whereRaw('LOWER(email) = ?', [$normalizedEmail])
                ->where('id', '!=', $id)
                ->exists()) {
            return response()->json(['data' => 0]);
        }

        $imagePath = $clinic_manager->image;
        if ($request->hasFile('image')) {
            // حذف القديمة
            if ($clinic_manager->image && file_exists(public_path($clinic_manager->image))) {
                @unlink(public_path($clinic_manager->image));
            }
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/employees'), $imageName);

            $imagePath = 'assets/img/employees/' . $imageName;
        }

        $password = $clinic_manager->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $clinic_manager->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'password'      => $password,
            'image'         => $imagePath,
            'address'       => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
        ]);

        $employee->update([
            'clinic_id'       => $request->clinic_id,
            'status'          => $request->status,
            'work_start_time' => $request->work_start_time,
            'work_end_time'   => $request->work_end_time,
            'working_days'    => $request->working_days,
            'short_biography' => $request->short_biography,
            'job_title'       => 'Clinic Manager',
        ]);

        return response()->json(['data' => 1]);
    }





    public function deleteClinicsManagers($id){
        $user = User::findOrFail($id);
        $employee = Employee::where('user_id', $id)->firstOrFail();

        if ($user->hasRole('doctor')) {
            $employee->update(['job_title' => 'Doctor']);
            $user->removeRole('clinic_manager');
            return response()->json(['success' => true, 'action' => 'kept_user_as_doctor']);
        } else {
            $user->removeRole('clinic_manager');
            $employee->delete();
            $user->delete();

            return response()->json(['success' => true, 'action' => 'deleted_manager_employee_user']);
        }
    }
}
