<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\JobTitle;
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
        if(Clinic::where('name' , $request->name)->exists() || Clinic::where('email' , $request->email)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $clinic = Clinic::create([
                'name' => $request->name,
                'location' => $request->location,
                'email' => $request->email,
                'phone' => $request->phone,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'description' => $request->description,
                'status' => $request->status,
                'working_days' => json_encode($request->working_days),
            ]);

            $departmentIds = $request->input('departments', []);
            $clinic->departments()->sync($departmentIds);


            return response()->json(['data' => 1]);
        }
    }





    public function viewClinics(){
        $clinics = Clinic::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.clinics.view' , compact('clinics'));
    }





    public function searchClinics(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinics = Clinic::with([
            'departments:id,name',
            'clinicDepartments:id,clinic_id,department_id',
            'clinicDepartments.doctors:id,clinic_department_id,employee_id',
            'clinicDepartments.doctors.employee:id,user_id,working_days',
            'clinicDepartments.doctors.employee.user:id,name',
        ]);

        if ($keyword !== '') {
            switch ($filter) {
                case 'clinic':
                    $clinics->where('name', 'like', "{$keyword}%");
                    break;
                case 'location':
                    $clinics->where('location', 'like', "{$keyword}%");
                    break;
                case 'day':
                    $clinics->whereJsonContains('working_days', ucfirst(strtolower($keyword)));
                    break;
                case 'status':
                    $clinics->where('status', 'like', "{$keyword}%");
                    break;
            }
        }

        $clinics    = $clinics->orderBy('id')->paginate(12);
        $view       = view('Backend.admin.clinics.searchClinic', compact('clinics'))->render();
        $pagination = $clinics->total() > 12 ? $clinics->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $clinics->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function descriptionClinic($id){
        $clinic = Clinic::with(['departments' , 'doctors'])->where('id' , $id)->first();
        return view('Backend.admin.clinics.description' , compact('clinic'));
    }





    public function editClinic($id){
        $clinic = Clinic::with(['departments'])->findOrFail($id);
        $working_days = json_decode($clinic->working_days, true);
        $all_departments = Department::all();
        $clinic_departments = $clinic->departments->pluck('id')->toArray();
        return view('Backend.admin.clinics.edit', compact('clinic','working_days','all_departments','clinic_departments' ));
    }

    public function updateClinic(Request $request, $id){
        $exists = Clinic::where(function ($query) use ($request, $id) {
            $query->where('name', $request->name)
                  ->orWhere('email', $request->email);
        })->where('id', '!=', $id)->exists();
        if($exists){
            return response()->json(['data' => 0]);
        }else{
            $clinic = Clinic::findOrFail($id);
            $clinic->update([
                'name' => $request->name,
                'location' => $request->location,
                'phone' => $request->phone,
                'email' => $request->email,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'description' => $request->description,
                'status' => $request->status,
                'working_days' => json_encode($request->working_days),
            ]);

            $clinic->departments()->sync($request->input('departments', []));

            return response()->json(['data' => 1]);
        }
    }




    public function deleteClinic($id){
        $clinic = Clinic::findOrFail($id);

        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinic->id)->pluck('id');
        $employeeIds = Doctor::whereIn('clinic_department_id', $clinicDepartmentIds)->pluck('employee_id')->filter();
        $userIds = Employee::whereIn('id', $employeeIds)->pluck('user_id')->filter();

        Doctor::whereIn('clinic_department_id', $clinicDepartmentIds)->delete();
        Employee::whereIn('id', $employeeIds)->delete();
        User::whereIn('id', $userIds)->delete();
        ClinicDepartment::where('clinic_id', $clinic->id)->delete();

        $clinic->delete();

        return response()->json(['success' => true]);
    }










    public function viewClinicsManagers(){
        $clinics_managers = User::role('clinic_manager')->paginate(12);
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
        $clinic_manager = User::findOrFail($id);
        return view('Backend.admin.clinics.clinics_managers.profile', compact('clinic_manager'));
    }





    public function editClinicsManagers($id){
        $clinic_manager = User::findOrFail($id);
        $clinics = Clinic::all();
        $working_days = $clinic_manager->employee->working_days ?? [];
        return view('Backend.admin.clinics.clinics_managers.edit', compact( 'clinic_manager', 'clinics', 'working_days'));
    }


    public function updateClinicsManagers(Request $request, $id){
        $clinic_manager = User::findOrFail($id);
        $employee = Employee::where('user_id', $clinic_manager->id)->first();

        if (User::where('name', $request->name)->where('id', '!=', $id)->exists() || User::where('email', $request->email)->where('id', '!=', $id)->exists()) {
            return response()->json(['data' => 0]);
        }else{
            $imageName = $clinic_manager->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'doctors/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            }


            $password = $clinic_manager->password;
            if ($request->filled('password')) {
                $password = Hash::make($request->password);
            }

            $clinic_manager->update([
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
                'user_id' => $clinic_manager->id ,
                'clinic_id' => $request->clinic_id ,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'short_biography' => $request->short_biography,
            ]);

            return response()->json(['data' => 1]);
        }
    }




    public function deleteClinicsManagers($id){
        $user = User::findOrFail($id);
        $employee = Employee::where('user_id', $id)->firstOrFail();

        Clinic::where('manager_employee_id', $employee->id)->update(['manager_employee_id' => null]);


        if($user->hasRole('doctor')) {
            $doctorTitleId = JobTitle::where('name', 'Doctor')->value('id');


            if ($doctorTitleId) {
                $employee->update(['job_title_id' => $doctorTitleId]);
            }

            $user->removeRole('clinic_manager');
            return response()->json(['success' => true, 'action' => 'kept_user_as_doctor']);
        }else{
            $user->removeRole('clinic_manager');
            $employee->delete();
            $user->delete();

            return response()->json(['success' => true, 'action' => 'deleted_manager_employee_user']);
        }
    }
}
