<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Vendor;
use App\Models\Expense;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Specialty;
use App\Models\DosageForm;
use App\Models\Medication;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\ExpenseItem;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\ClinicPatient;
use App\Models\MedicineStock;
use App\Models\PaymentDetail;
use App\Models\VendorInvoice;
use App\Models\PatientInvoice;
use App\Models\ClinicSpecialty;
use App\Models\PrescriptionItem;
use App\Models\SpecialtyPatient;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DosageFormSeeder;

class AdminController extends Controller{

    public function adminDashboard(){
        $clinic_count = Clinic::count();
        $specialty_count = Specialty::count();
        $doctor_count = Doctor::count();
        $employee_count = Employee::count();
        $patient_count = Patient::count();
        $medication_count = Medication::count();
        $medication_stock_count = MedicineStock::count();
        $today_appointments = Appointment::whereDate('appointment_date', today())->count();
        return view('Backend.admin.dashboard' , compact('clinic_count' , 'specialty_count' , 'doctor_count' , 'employee_count' , 'patient_count' , 'medication_count' , 'medication_stock_count' , 'today_appointments'));
    }





    //Clinics
    public function addClinic(){
        $doctors = Doctor::where('is_in_charge' , false)->get();
        $specialties = Specialty::all();
        return view('Backend.admin.clinics.add' , compact('doctors' , 'specialties'));
    }


    public function storeClinic(Request $request){
        if(Clinic::where('name' , $request->name)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $clinic = Clinic::create([
                'name' => $request->name,
                'location' => $request->location,
                'clinic_phone' => $request->phone,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'description' => $request->description,
                'status' => $request->status,
                'working_days' => json_encode($request->working_days),
                'doctor_in_charge' => $request->doctor_in_charge ?: null,
            ]);

            // ✅ ربط التخصصات الموجودة مسبقًا بالعيادة
            $specialtyIds = $request->input('specialties', []); // IDs جاهزة من الفورم
            $clinic->specialties()->sync($specialtyIds);

            if ($request->filled('doctor_id')) {
                $doctor = Doctor::where('id', $request->doctor_id)->first();
                if ($doctor) {
                    $doctor->update([
                        'is_in_charge' => true,
                    ]);

                    $user = User::find($doctor->user_id);

                    if ($user) {
                        $user->update([
                            'role' => 'clinic_manager',
                        ]);
                        $user->syncRoles(['clinic_manager']);
                    }
                }
            }

            return response()->json(['data' => 1]);
        }
    }





    public function viewClinics(){
        $clinics = Clinic::with('specialties')->orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.clinics.view' , compact('clinics'));
    }





    public function descriptionClinic($id){
        $clinic = Clinic::with(['specialties' , 'doctors'])->where('id' , $id)->first();
        return view('Backend.admin.clinics.description' , compact('clinic'));
    }





    public function editClinic($id){
        $clinic = Clinic::with(['specialties'])->findOrFail($id);
        $currentDoctorId = $clinic->doctor_in_charge;

        $doctorsQuery = Doctor::where('is_in_charge', false);

        if (!is_null($currentDoctorId)) {
            $doctorsQuery->orWhere('id', $currentDoctorId);
        }

        $doctors = $doctorsQuery->get();

        $working_days = json_decode($clinic->working_days, true);
        $all_specialties = Specialty::all();
        $clinic_specialties = $clinic->specialties->pluck('id')->toArray();

        return view('Backend.admin.clinics.edit', compact('clinic','doctors','working_days','all_specialties','clinic_specialties'));
    }

    public function updateClinic(Request $request, $id){
        $clinic = Clinic::findOrFail($id);
        $doctors = Doctor::all();

        if ($request->filled('doctor_in_charge') && $request->doctor_in_charge != $clinic->doctor_in_charge) {

            $previousManager = Doctor::where('clinic_id', $clinic->id)->where('is_in_charge', true)->first();

            if ($previousManager) {
                $previousManager->is_in_charge = false;
                $previousManager->save();

                if ($previousManager->user_id) {
                    $oldUser = User::find($previousManager->user_id);
                    if ($oldUser) {
                        $oldUser->role = 'doctor';
                        $oldUser->save();
                        $oldUser->syncRoles(['doctor']);
                    }
                }
            }

            $selectedId = $request->doctor_in_charge;

            foreach ($doctors as $doctor) {
                if ($doctor->id == $selectedId) {
                    $doctor->is_in_charge = true;
                    $doctor->clinic_id = $clinic->id;
                    $doctor->save();

                    if ($doctor->user_id) {
                        $user = User::find($doctor->user_id);
                        if ($user) {
                            $user->role = 'clinic_manager';
                            $user->save();
                            $user->syncRoles(['clinic_manager']);
                        }
                    }

                    break;
                }
            }
        }

        $clinic->update([
            'name' => $request->name,
            'location' => $request->location,
            'clinic_phone' => $request->phone,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'description' => $request->description,
            'status' => $request->status,
            'working_days' => json_encode($request->working_days),
            'doctor_in_charge' => $request->filled('doctor_in_charge') ? $request->doctor_in_charge : null,
        ]);

        $clinic->specialties()->sync($request->input('specialties', []));

        return response()->json(['data' => 1]);
    }




    public function deleteClinic($id){
        $clinic = Clinic::findOrFail($id);

        // حذف الربط فقط بين العيادة والتخصصات (وليس حذف التخصصات نفسها)
        $clinic->specialties()->detach();

        Doctor::where('clinic_id', $clinic->id)->delete();
        $clinic->delete();

        return response()->json(['success' => true]);
    }





    //Specialty
    public function addSpecialty(){
        return view('Backend.admin.specialty.add');
    }


    public function storeSpecialty(Request $request){
        if(Specialty::where('name' , $request->name)->exists()){
            return response()->json(['data' => 0]);
        }else{
            Specialty::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewSpecialties(){
        $specialties = Specialty::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.specialty.view', compact('specialties'));
    }





    public function descriptionSpecialty($id){
        $specialty = Specialty::with(['clinics' , 'doctors'])->withCount('clinics')->findOrFail($id);
        $count_clinics = $specialty->clinics_count;
        $count_doctor = Doctor::where('specialty_id', $id)->count();

        return view('Backend.admin.specialty.description', compact('specialty' , 'count_clinics' , 'count_doctor'));
    }





    public function editSpecialty($id){
        $specialty = Specialty::findOrFail($id);
        return view('Backend.admin.specialty.edit', compact('specialty'));
    }


    public function updateSpecialty(Request $request, $id){
        $specialty = Specialty::findOrFail($id);

        $specialty->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['data' => 1]);
    }




    public function deleteSpecialty($id){
        $specialty = Specialty::findOrFail($id);
        $doctors = Doctor::where('specialty_id', $specialty->id)->get();

        foreach ($doctors as $doctor) {
            User::where('id', $doctor->user_id)->delete();
        }

        Doctor::where('specialty_id', $specialty->id)->delete();
        $specialty->clinics()->detach();
        $specialty->delete();

        return response()->json(['success' => true]);
    }




    //Doctor
    public function addDoctor(){
        $specialties = Specialty::all();
        // $s = ClinicSpecialty
        $clinics = Clinic::all();
        return view('Backend.admin.doctors.add' , compact('specialties' , 'clinics'));
    }


    public function storeDoctor(Request $request){
        if(Doctor::where('name', $request->name)->exists() || User::where('email', $request->email)->exists()){
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
                'role' => 'doctor',
            ]);
            $user->syncRoles(['doctor']);


            Doctor::create([
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
                'clinic_id' => $request->clinic_id,
                'specialty_id' => $request->specialty_id,
                'user_id' => $user->id,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => json_encode($request->working_days),
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewDoctors(){
        $doctors = Doctor::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.doctors.view' , compact('doctors'));
    }





    public function viewClinicManagers(){
        $doctors = Doctor::where('is_in_charge' , true)->paginate(12);
        return view('Backend.admin.doctors.view_clinic_managers' , compact('doctors'));
    }





    public function profileDoctor($id){
        $doctor = Doctor::with(['clinic','specialty'])->findOrFail($id);
        return view('Backend.admin.doctors.profile', compact('doctor'));
    }





    public function editDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $user = User::where('id', $doctor->user_id)->first();
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        $working_days = $doctor->working_days ?? [];
        return view('Backend.admin.doctors.edit', compact('doctor' , 'user' , 'specialties' , 'clinics' , 'working_days'));
    }


    public function updateDoctor(Request $request, $id){
        $doctor = Doctor::findOrFail($id);
        $user = User::where('id', $doctor->user_id)->first();

        if(Doctor::where('name', $request->name)->where('id', '!=', $id)->exists() || User::where('email', $request->email)->where('id', '!=', $doctor->user_id)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $imageName = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'doctors/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            }

            $doctor->update([
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'clinic_id' => $request->clinic_id ,
                'specialty_id' => $request->specialty_id ,
                'gender' => $request->gender,
                'status' => $request->status,
                'work_start_time' => $request->work_start_time,
                'work_end_time' => $request->work_end_time,
                'working_days' => $request->working_days,
                'short_biography' => $request->short_biography,
            ]);

            $password = $user->password;
            if ($request->filled('password')) {
                $password = Hash::make($request->password);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password ,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $imageName,
            ]);

            return response()->json(['data' => 1]);
        }
    }




    public function deleteDoctor($id){
        $doctor = Doctor::findOrFail($id);
        $user = User::where('id', $doctor->user_id)->first();
        $doctor->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }





    public function searchDoctorSchedules(){
        $clinics = Clinic::all();
        $Specialties = Specialty::all();
        $doctors = Doctor::all();
        return view('Backend.admin.doctors.schedules', compact('clinics', 'Specialties', 'doctors'));
    }


    public function searchDoctchedules(Request $request){
        $doctor_id = $request->doctor_id;
        $clinic_id = $request->clinic_id;
        $specialty_id = $request->specialty_id;
        $offset = (int) $request->offset ?? 0;

        $clinics = Clinic::all();
        $Specialties = Specialty::all();
        $doctors = Doctor::all();

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addWeeks($offset);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->addWeeks($offset);

        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->whereBetween('appointment_date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();

        return view('Backend.admin.doctors.schedules', [
            'appointments' => $appointments,
            'selectedDoctor' => Doctor::find($doctor_id),
            'clinics' => $clinics,
            'Specialties' => $Specialties,
            'doctors' => $doctors,
            'clinic_id' => $clinic_id,
            'specialty_id' => $specialty_id,
            'doctor_id' => $doctor_id,
            'offset' => $offset,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
        ]);
    }





    //Patient
    public function addPatient(){
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        $doctors = Doctor::all();
        return view('Backend.admin.patients.add' , compact('specialties' , 'clinics' , 'doctors'));
    }


    public function storePatient(Request $request){
        $existingPatient = Patient::where('name', $request->name)->first();
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->name !== $request->name) {
            return response()->json(['data' => 0]);
        }
        else if ($existingPatient && $existingUser) {
            $alreadyExists = ClinicPatient::where('patient_id', $existingPatient->id)
            ->where('clinic_id', $request->clinic_id)->exists();

            if (!$alreadyExists) {
                ClinicPatient::create([
                    'patient_id' => $existingPatient->id,
                    'clinic_id' => $request->clinic_id,
                    'visit_date' => now(),
                ]);
            }

            SpecialtyPatient::create([
                'patient_id' => $existingPatient->id,
                'specialty_id' => $request->specialty_id,

            ]);

            $selectedDay = $request->appointment_day;
            $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();  // تحويله إلى تاريخ (أقرب تاريخ قادم لهذا اليوم)

            Appointment::create([
                'patient_id' => $existingPatient->id,
                'doctor_id' => $request->doctor_id,
                'clinic_id'  => $request->clinic_id,
                'specialty_id'  => $request->specialty_id,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 1]);
        }else{

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'patients/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('doctors'), $imageName);
            } else {
                $imageName = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->filled('address') ? $request->address : null,
                'image' => $imageName,
            ]);

            $patient = Patient::create([
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
                'user_id' => $user->id,
            ]);

            ClinicPatient::create([
                'patient_id' => $patient->id,
                'clinic_id' => $request->clinic_id,
                'visit_date' => now(),
            ]);

            SpecialtyPatient::create([
                'patient_id' => $patient->id,
                'specialty_id' => $request->specialty_id,

            ]);

            $selectedDay = $request->appointment_day;
            $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();  // تحويله إلى تاريخ (أقرب تاريخ قادم لهذا اليوم)

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'clinic_id'  => $request->clinic_id,
                'specialty_id'  => $request->specialty_id,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 2]);
        }
    }





    public function viewPatients(){
        $patients = Patient::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.patients.view' , compact('patients'));
    }





    public function profilePatient($id){
        $patient = Patient::findOrFail($id);
        return view('Backend.admin.patients.profile', compact('patient'));
    }





    public function editPatient($id){
        $patient = Patient::with(['user', 'clinics', 'doctors' , 'specialties'])->findOrFail($id);
        $user = User::where('id', $patient->user_id)->first();
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        return view('Backend.admin.patients.edit', compact('patient' , 'user' , 'specialties' , 'clinics'));
    }


    public function updatePatient(Request $request, $id){
        $patient = Patient::findOrFail($id);
        $user = User::where('id', $patient->user_id)->first();

        $existingUser = User::where('email', $request->email)->where('id', '!=', $user->id)->exists();

        if($existingUser){
            return response()->json(['data' => 0]);
        }else{
            $imageName = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'patients/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('patients'), $imageName);
            }

            $password = $user->password;
            if ($request->filled('password')){
                $password = Hash::make($request->password);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'phone' => $request->phone,
                'address' => $request->filled('address') ? $request->address : null,
                'image' => $imageName,
            ]);

            $patient->update([
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
            ]);

            ClinicPatient::updateOrCreate(
                ['patient_id' => $patient->id],
                ['clinic_id' => $request->clinic_id, 'visit_date' => now()]
            );

            SpecialtyPatient::updateOrCreate(
                ['patient_id' => $patient->id],
                ['specialty_id' => $request->specialty_id]
            );

            $selectedDay = $request->appointment_day;
            $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'clinic_id'  => $request->clinic_id,
                'specialty_id'  => $request->specialty_id,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
            ]);

            return response()->json(['data' => 1]);
        }
    }




    public function deletePatient($id){
        $patient = Patient::findOrFail($id);
        $user = User::where('id', $patient->user_id)->first();
        $patient->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }





    //Appointment
    public function addAppointment(){
        $patients = Patient::all();
        $clinics = Clinic::all();
        $specialties = Specialty::all();
        $doctors = Doctor::all();
        return view('Backend.admin.appointments.add' , compact('patients' , 'clinics' , 'specialties' , 'doctors'));
    }


    public function storeAppointment(Request $request){
        $selectedDay = $request->appointment_day;
        $appointmentDate = Carbon::parse("next $selectedDay")->toDateString();

        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_id', $request->clinic_id)
            ->where('specialty_id', $request->specialty_id)
            ->where('appointment_date', $appointmentDate)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
         }else{
            Appointment::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'clinic_id'  => $request->clinic_id,
                'specialty_id'  => $request->specialty_id,
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

        $appointments = Appointment::with(['patient', 'clinic', 'specialty', 'doctor']);

        if ($keyword) {
            switch ($filter) {
                case 'patient':
                    $appointments->whereHas('patient', fn($q) => $q->where('name', 'like', "$keyword%"));
                    break;
                case 'clinic':
                    $appointments->whereHas('clinic', fn($q) => $q->where('name', 'like', "$keyword%"));
                    break;
                case 'specialty':
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
            ->where('specialty_id', $request->specialty_id)
            ->where('appointment_date', $appointmentDate)
            ->where('appointment_time', $request->appointment_time)
            ->where('id', '!=', $id) // تجاهل الموعد الحالي
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        } else {
            $appointment = Appointment::findOrFail($id);
            $appointment->update([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'clinic_id' => $request->clinic_id,
                'specialty_id' => $request->specialty_id,
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





    //Medication
    public function addMedication(){
        $dosageForms = DosageForm::all();
        return view('Backend.admin.medications.add' , compact('dosageForms'));
    }


    public function storeMedication(Request $request){
        $existingMedication = Medication::where('name', $request->name)->where('dosage_form_id', $request->dosage_form_id)->first();
        if($existingMedication){
            return response()->json(['data' => 0]);
        }else{
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'medications/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('medications'), $imageName);
            } else {
                $imageName = null;
            }

            Medication::create([
                'name' => $request->name,
                'dosage_form_id' => $request->dosage_form_id,
                'strength' => $request->strength,
                'image' => $imageName,
                'description' => $request->description,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
            ]);
                return response()->json(['data' => 1]);
        }
    }





    public function viewMedications(){
        $medications = Medication::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.medications.view' , compact('medications'));
    }





    public function descriptionMedication($id){
        $medication = Medication::findOrFail($id);
        return view('Backend.admin.medications.description', compact('medication'));
    }





    public function editMedication($id){
        $medication = Medication::findOrFail($id);
        $dosageForms = DosageForm::all();
        return view('Backend.admin.medications.edit', compact('medication' , 'dosageForms'));
    }


    public function updateMedication(Request $request, $id){
        $medication = Medication::findOrFail($id);
        $imageName = $medication->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageFileName = time() . '_' . $file->getClientOriginalName();
            $imagePath = 'medications/' . $imageFileName;
            $file->move(public_path('medications'), $imageFileName);
            $imageName = $imagePath;
        }
            $medication->update([
                'name' => $request->name,
                'dosage_form_id' => $request->dosage_form_id,
                'strength' => $request->strength,
                'description' => $request->description,
                'image' => $imageName,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
            ]);
            return response()->json(['data' => 1]);
    }





    public function deleteMedication($id){
        $medication = Medication::findOrFail($id);
        $medication->delete();
        return response()->json(['success' => true]);
    }





    //Prescriptions
    public function viewPrescriptions(){
        $prescriptions = Prescription::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.prescriptions.view' , compact('prescriptions'));
    }


    public function descriptionPrescription($id){
        $prescriptionItems = PrescriptionItem::with('medications.dosageForm')->where('prescription_id', $id)->get();
        return view('Backend.admin.prescriptions.prescription_items', compact('prescriptionItems'));
    }





    //Medication Stock
    public function addToStock(){
        $clinics = Clinic::all();
        $medications = Medication::all();
        return view('Backend.admin.stocks.add' , compact('clinics' , 'medications'));
    }


    public function storeToStock(Request $request){
        MedicineStock::create([
            'clinic_id' => $request->clinic_id,
            'medication_id' => $request->medication_id,
            'quantity' => $request->quantity,
            'batch_number' => $request->batch_number,
            'manufacture_date' => $request->manufacture_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        return response()->json(['data' => 1]);
    }


    public function generateBatchNumber(Request $request){
        $clinic = Clinic::find($request->clinic_id);
        $medication = Medication::find($request->medication_id);

        if (!$clinic || !$medication) {
            return response()->json(['batch_number' => null]);
        }


        $prefix = strtoupper(substr($clinic->name, 0, 2)) . strtoupper(substr($medication->name, 0, 2));  // أول حرفين من العيادة وأول حرفين من الدواء

        $year = Carbon::now()->year;

        $count = MedicineStock::where('clinic_id', $clinic->id)->where('medication_id', $medication->id)->count() + 1;   // رقم تسلسلي: عدد الدفعات الموجودة مسبقًا + 1

        $batchNumber = $prefix . $year . '-' . $count;

        return response()->json(['batch_number' => $batchNumber]);
    }





    public function viewStocks(){
        $medicineStocks = MedicineStock::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.stocks.view' , compact('medicineStocks'));
    }





    public function descriptionStock($id){
        $stock = MedicineStock::findOrFail($id);
        return view('Backend.admin.stocks.description', compact('stock'));
    }





    public function editStock($id){
        $medicineStocks = MedicineStock::findOrFail($id);
        $medications = Medication::all();
        $clinics = Clinic::all();
        return view('Backend.admin.stocks.edit', compact('medicineStocks' , 'clinics' , 'medications'));
    }


    public function updateStock(Request $request, $id){
        $medicineStock = MedicineStock::findOrFail($id);
        $medicineStock->update([
            'clinic_id' => $request->clinic_id,
            'medication_id' => $request->medication_id,
            'quantity' => $request->quantity,
            'batch_number' => $request->batch_number,
            'manufacture_date' => $request->manufacture_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        return response()->json(['data' => 1]);
    }





    public function deleteStock($id){
        $medicineStocks = MedicineStock::findOrFail($id);
        $medicineStocks->delete();
        return response()->json(['success' => true]);
    }





    //Employee
    public function addEmployee(){
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        $jobTitles = JobTitle::all();
        return view('Backend.admin.employees.add' , compact('specialties' , 'clinics' , 'jobTitles'));
    }


    public function storeEmployee(Request $request){
        $existingEmployee = Employee::where('name', $request->name)->first();
        $existingUser = User::where('email', $request->email)->first();

        if($existingEmployee && $existingUser){
            return response()->json(['data' => 0]);
        }else{

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'employees/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('employees'), $imageName);
            } else {
                $imageName = null;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->filled('address') ? $request->address : null,
                'image' => $imageName,
                'role' => 'employee',
            ]);

            $user->syncRoles(['employee']);

            Employee::create([
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'clinic_id' => $request->clinic_id,
                'specialty_id' => $request->specialty_id,
                'job_title_id' => $request->job_title_id,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
                'gender' => $request->gender,
                'status' => $request->status,
                'user_id' => $user->id,
            ]);

            return response()->json(['data' => 1]);
        }
    }





    public function viewEmployees(){
        $employees = Employee::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.employees.view' , compact('employees'));
    }





    public function profileEmployee($id){
        $employee = Employee::findOrFail($id);
        return view('Backend.admin.employees.profile', compact('employee'));
    }





    public function editEmployee($id){
        $employee = Employee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->first();
        $specialties = Specialty::all();
        $clinics = Clinic::all();
        $jobTitles = JobTitle::all();
        return view('Backend.admin.employees.edit', compact('employee' , 'user' , 'specialties' , 'clinics' , 'jobTitles'));
    }


    public function updateEmployee(Request $request, $id){
        $employee = Employee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->first();

        if(Employee::where('name', $request->name)->where('id', '!=', $id)->exists() && User::where('email', $request->email)->where('id', '!=', $employee->user_id)->exists()){
            return response()->json(['data' => 0]);
        }else{
            $imageName = $user->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'employees/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('employees'), $imageName);
            }

            $password = $user->password;
            if ($request->filled('password')) {
                $password = Hash::make($request->password);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'phone' => $request->phone,
                'address' => $request->filled('address') ? $request->address : null,
                'image' => $imageName,
            ]);


            $employee->update([
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'clinic_id' => $request->clinic_id,
                'specialty_id' => $request->specialty_id,
                'job_title_id' => $request->job_title_id,
                'gender' => $request->gender,
                'short_biography' => $request->short_biography,
                'gender' => $request->gender,
                'status' => $request->status,
                'user_id' => $user->id,
            ]);
            return response()->json(['data' => 1]);
        }
    }




    public function deleteEmployee($id){
        $employee = Employee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->first();
        $employee->delete();
        $user->delete();
        return response()->json(['success' => true]);
    }





    //patients invoices
    public function viewInvoices(){
        $patientInvoices = PatientInvoice::with('clinic')->orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.finances.patientInvoice.view' , compact('patientInvoices'));
    }





    public function detailsInvoice($id){
        $patientInvoice = PatientInvoice::with(['patient', 'items'])->findOrFail($id);
        return view('Backend.admin.finances.patientInvoice.details' , compact('patientInvoice'));
    }





    public function editInvoice($id){
        $patientInvoice = PatientInvoice::findOrFail($id);
        $patients = Patient::all();
        return view('Backend.admin.finances.patientInvoice.edit' , compact('patientInvoice' , 'patients'));
    }


    public function updateInvoice(Request $request, $id){
        $patientInvoice = PatientInvoice::findOrFail($id);

        // $finalAmount = (float) $request->total_amount - (float) $request->discount;

        $exists = PatientInvoice::where('id', '!=', $id)
            ->where('appointment_id', $request->appointment_id)
            // ->where('total_amount', $request->total_amount)
            ->where('discount', $request->discount)
            // ->where('final_amount', $finalAmount)
            ->where('status', $request->status)
            ->where('notes', $request->notes)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'appointment_id' => $patientInvoice->appointment_id,
            'patient_id'     => $patientInvoice->patient_id,
            'total_amount'   => $patientInvoice->total_amount,
            'discount'       => $patientInvoice->discount,
            'final_amount'   => $patientInvoice->final_amount,
            'status'         => $patientInvoice->status,
            'notes'          => $patientInvoice->notes,
        ]);

        $patientInvoice->update([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'discount' => $request->discount,
            // 'final_amount' => $finalAmount,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $patientInvoice->refresh();

        $newData = json_encode([
            'appointment_id' => $patientInvoice->appointment_id,
            'patient_id'     => $patientInvoice->patient_id,
            'total_amount'   => $patientInvoice->total_amount,
            'discount'       => $patientInvoice->discount,
            'final_amount'   => $patientInvoice->final_amount,
            'status'         => $patientInvoice->status,
            'notes'          => $patientInvoice->notes,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Patient Invoices',
            'description' => 'The patient invoice with ID '. $id . ' has been Edited by the admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deleteInvoice(Request $request , $id){
        $patientInvoice = PatientInvoice::findOrFail($id);
        $oldData = json_encode([
            'appointment_id' => $patientInvoice->appointment_id,
            'patient_id'     => $patientInvoice->patient_id,
            'total_amount'   => $patientInvoice->total_amount,
            'discount'       => $patientInvoice->discount,
            'final_amount'   => $patientInvoice->final_amount,
            'status'         => $patientInvoice->status,
            'notes'          => $patientInvoice->notes,
        ]);
        $patientInvoice->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Patient Invoices',
            'description' => 'The patient invoice with ID '. $id . ' has been deleted by the admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Invoice deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }





    //patients payments
    public function viewPayments(){
        $payments = Payment::with(['invoice'])->orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.finances.patientPayment.view' , compact('payments'));
    }





    public function detailsPayment($id){
        $payment = Payment::with(['invoice', 'paymentDetails'])->findOrFail($id);
        $paymentDetails = $payment->paymentDetails;

        $finalAmount = $payment->invoice->final_amount ?? 0;
        $totalPaid = $paymentDetails->sum('amount_paid');

        return view('Backend.admin.finances.patientPayment.patientsPaymentsDetails.details', compact('paymentDetails', 'finalAmount', 'totalPaid', 'payment'));
    }





    public function editPayment($id){
        $payment = Payment::findOrFail($id);
        $patients = Patient::all();
        return view('Backend.admin.finances.patientPayment.edit' , compact('payment' , 'patients'));
    }


    public function updatePayment(Request $request, $id){
        $payment = Payment::findOrFail($id);
        $exists = Payment::where('id', '!=', $id)->where('invoice_id', $request->invoice_id)->exists();
        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'invoice_id'   => $payment->invoice_id,
        ]);

        $payment->update([
            'invoice_id'   => $request->invoice_id,
        ]);

        $payment->refresh();


        $newData = json_encode([
            'invoice_id'   => $payment->invoice_id,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Patient Payments',
            'description' => 'The Patient Payment With ID '. $id . ' Has Been Edited By The Admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deletePayment(Request $request , $id){
        $payment = Payment::findOrFail($id);
        $invoice = $payment->invoice;

        $oldData = json_encode([
            'invoice_id'   => $payment->invoice_id,
            'patient_id'     => $payment->patient_id,
            'final_amount'  => $invoice->final_amount,
        ]);

        $payment->delete();
        $payment->paymentDetails()->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Patient Payment',
            'description' => 'The patient payment with ID '. $id . ' has been deleted by the admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'payment deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }





    //patients payments details
    public function editPaymentDetails($id){
        $paymentDetail = PaymentDetail::findOrFail($id);
        return view('Backend.admin.finances.patientPayment.patientsPaymentsDetails.edit' , compact('paymentDetail'));
    }


    public function updatePaymentDetails(Request $request, $id){
        $paymentDetail = PaymentDetail::findOrFail($id);


        $oldData = json_encode([
            'amount_paid'   => $paymentDetail->amount_paid,
            'payment_method'     => $paymentDetail->payment_method,
            'payment_date'  => $paymentDetail->payment_date,
            'notes'  => $paymentDetail->notes,
        ]);

        $paymentDetail->update([
            'amount_paid'   => $request->amount_paid,
            'payment_method'     => $request->payment_method,
            'payment_date'  => $request->payment_date,
            'notes'  => $request->notes,
        ]);

        $paymentDetail->refresh();



        $newData = json_encode([
            'amount_paid'   => $paymentDetail->amount_paid,
            'payment_method'     => $paymentDetail->payment_method,
            'payment_date'  => $paymentDetail->payment_date,
            'notes'  => $paymentDetail->notes,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Patient Payments Details',
            'description' => 'The patient payment Details with ID '. $id . ' has been Edited by the admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deletePaymentDetails(Request $request , $id){
        $paymentDetail = PaymentDetail::findOrFail($id);

        $oldData = json_encode([
            'amount_paid'   => $paymentDetail->amount_paid,
            'payment_method'     => $paymentDetail->payment_method,
            'payment_date'  => $paymentDetail->payment_date,
            'notes'  => $paymentDetail->notes,
        ]);

        $paymentDetail->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Patient Payment Details',
            'description' => 'The Patient Payment Details with ID '. $id . ' has been deleted by the admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Patient payment Details deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }







    //vendors invoices
    public function viewVendorInvoices(){
        $vendorInvoices = VendorInvoice::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.finances.vendorInvoice.view' , compact('vendorInvoices'));
    }





    public function detailsVendorInvoice($id){
        $vendorInvoice = VendorInvoice::with('vendor')->findOrFail($id);
        return view('Backend.admin.finances.vendorInvoice.details' , compact('vendorInvoice'));
    }





    public function editVendorInvoice($id){
        $vendorInvoice = VendorInvoice::findOrFail($id);
        $vendors = Vendor::all();
        $clinics = Clinic::all();
        return view('Backend.admin.finances.vendorInvoice.edit' , compact('vendorInvoice','vendors','clinics'));
    }


    public function updateVendorInvoice(Request $request, $id){
        $vendorInvoice = VendorInvoice::findOrFail($id);
        $finalAmount = (float) $request->total_amount - (float) $request->discount;

        $exists = VendorInvoice::where('id', '!=', $id)
            ->where('vendor_id', $request->vendor_id)
            ->where('clinic_id', $request->clinic_id)
            ->where('invoice_date', $request->invoice_date)
            ->where('final_amount', $request->final_amount)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'vendor_id' => $vendorInvoice->vendor_id,
            'clinic_id' => $vendorInvoice->clinic_id,
            'invoice_date' => $vendorInvoice->invoice_date,
            'total_amount' => $vendorInvoice->total_amount,
            'discount' => $vendorInvoice->discount,
            'final_amount' => $vendorInvoice->final_amount,
            'status' => $vendorInvoice->status,
            'notes' => $vendorInvoice->notes,
        ]);

        $vendorInvoice->update([
            'vendor_id' => $request->vendor_id,
            'clinic_id' => $request->clinic_id,
            'invoice_date' => $request->invoice_date,
            'total_amount' => $request->total_amount,
            'discount' => $request->discount,
            'final_amount' => $finalAmount,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $vendorInvoice->refresh();

        $newData = json_encode([
            'vendor_id' => $vendorInvoice->vendor_id,
            'clinic_id' => $vendorInvoice->clinic_id,
            'invoice_date' => $vendorInvoice->invoice_date,
            'total_amount' => $vendorInvoice->total_amount,
            'discount' => $vendorInvoice->discount,
            'final_amount' => $vendorInvoice->final_amount,
            'status' => $vendorInvoice->status,
            'notes' => $vendorInvoice->notes,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Vendor Invoices',
            'description' => 'The Vendor Invoice With ID '. $id . ' Has Been Edited By The Admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deleteVendorInvoice(Request $request , $id){
        $vendorInvoice = VendorInvoice::findOrFail($id);
        $oldData = json_encode([
            'vendor_id' => $vendorInvoice->vendor_id,
            'clinic_id' => $vendorInvoice->clinic_id,
            'invoice_date' => $vendorInvoice->invoice_date,
            'total_amount' => $vendorInvoice->total_amount,
            'discount' => $vendorInvoice->discount,
            'final_amount' => $vendorInvoice->final_amount,
            'status' => $vendorInvoice->status,
            'notes' => $vendorInvoice->notes,
        ]);
        $vendorInvoice->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Vendor Invoices',
            'description' => 'The Vendor Invoice With ID '. $id . ' Has Been Deleted By The Admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Vendor Invoice deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }





    //expenses
    public function viewExpenses(){
        $expenses = Expense::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.finances.expense.view' , compact('expenses'));
    }





    public function detailsExpense($id){
        $expense = Expense::with(['vendorInvoice' , 'expenseItems'])->findOrFail($id);
        $expenseItems = $expense->expenseItems;

        $finalAmount = $expense->vendorInvoice->final_amount ?? 0;
        $totalPaid = $expenseItems->sum('total_amount');
        return view('Backend.admin.finances.expense.expensesdetails.details' , compact('expense' , 'expenseItems' , 'finalAmount' , 'totalPaid'));
    }





    public function editExpense($id){
        $expense = Expense::findOrFail($id);
        $clinics = Clinic::all();
        return view('Backend.admin.finances.expense.edit' , compact('expense' , 'clinics'));
    }


    public function updateExpense(Request $request, $id){
        $expense = Expense::findOrFail($id);

        $exists = Expense::where('id', '!=', $id)->where('vendor_invoice_id', $request->vendor_invoice_id)->exists();
        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'vendor_invoice_id' => $expense->vendor_invoice_id,


        ]);

        $expense->update([
            'vendor_invoice_id' => $request->vendor_invoice_id,
        ]);

        $expense->refresh();


        $newData = json_encode([
            'vendor_invoice_id' => $expense->vendor_invoice_id,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Expenses',
            'description' => 'The Expenses With ID '. $id . ' Has Been Edited By The Admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deleteExpense(Request $request , $id){
        $expense = Expense::findOrFail($id);
        $oldData = json_encode([
            'vendor_invoice_id' => $expense->vendor_invoice_id,

        ]);
        $expense->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Expenses',
            'description' => 'The Expenses With ID '. $id . ' Has Been Deleted By The Admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Expenses deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }





    //vendors expenses details
    public function editExpenseDetails($id){
        $expenseItem = ExpenseItem::findOrFail($id);
        return view('Backend.admin.finances.expense.expensesdetails.edit' , compact('expenseItem'));
    }


    public function updateExpenseDetails(Request $request, $id){
        $expenseItem = ExpenseItem::findOrFail($id);
        $vendorInvoice = $expenseItem->expense->vendorInvoice;

        $total_amount = ($request->unit_price * $request->quantity);

        $exists = ExpenseItem::where('id', '!=', $id)
        ->where('item_name', $request->item_name)
        ->where('quantity', $request->quantity)
        ->where('unit_price', $request->unit_price)
        ->where('total_amount', $total_amount)
        ->where('payment_method', $request->payment_method)
        ->where('expense_date', $request->expense_date)
        ->exists();
        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'item_name' => $expenseItem->item_name,
            'quantity' => $expenseItem->quantity,
            'unit_price' => $expenseItem->unit_price,
            'total_amount' => $expenseItem->total_amount,
            'payment_method' => $expenseItem->payment_method,
            'expense_date' => $expenseItem->expense_date,
            'notes' => $expenseItem->notes,
            'final_amount' => $vendorInvoice->final_amount,
        ]);

        $expenseItem->update([
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $total_amount,
            'payment_method' => $request->payment_method,
            'expense_date' => $request->expense_date,
            'notes' => $request->notes,
        ]);

        $expenseItem->refresh();


        $vendorInvoice->update([
            'total_amount' => $expenseItem->expense->expenseItems->sum('total_amount'),
            'discount' => 0,
            'final_amount' => $expenseItem->expense->expenseItems->sum('total_amount'),
        ]);

        $vendorInvoice->refresh();


        $newData = json_encode([
            'item_name' => $expenseItem->item_name,
            'quantity' => $expenseItem->quantity,
            'unit_price' => $expenseItem->unit_price,
            'total_amount' => $expenseItem->total_amount,
            'payment_method' => $expenseItem->payment_method,
            'expense_date' => $expenseItem->expense_date,
            'notes' => $expenseItem->notes,
            'final_amount' => $vendorInvoice->final_amount,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Expenses Details',
            'description' => 'The Expenses Details With ID '. $id . ' Has Been Edited By The Admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deleteExpenseDetails(Request $request , $id){
        $expenseItem = ExpenseItem::findOrFail($id);
        $oldData = json_encode([
            'item_name' => $expenseItem->item_name,
            'quantity' => $expenseItem->quantity,
            'unit_price' => $expenseItem->unit_price,
            'total_amount' => $expenseItem->total_amount,
            'payment_method' => $expenseItem->payment_method,
            'expense_date' => $expenseItem->expense_date,
            'notes' => $expenseItem->notes,
        ]);
        $expenseItem->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Expenses Details',
            'description' => 'The Expenses Details With ID '. $id . ' Has Been Deleted By The Admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Expenses Details Deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }





    //reports
    public function viewReports(){
        // $reports = Report::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.reports.view');
    }
}
