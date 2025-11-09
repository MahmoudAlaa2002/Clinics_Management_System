<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Backend\Admin\ClinicController;
use App\Http\Controllers\Backend\Admin\DoctorController;
use App\Http\Controllers\Backend\Admin\PatientController;
use App\Http\Controllers\Backend\Admin\EmployeeController;
use App\Http\Controllers\Backend\Admin\DepartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Admin\AppointmentController;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Backend\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Backend\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Backend\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Backend\Employee\Nurse\DashboardController as NurseDashboardController;
use App\Http\Controllers\Backend\ClinicManager\DashboardController as ClinicManagerDashboardController;
use App\Http\Controllers\Backend\Employee\Receptionist\DashboardController as ReceptionistDashboardController;
use App\Http\Controllers\Backend\DepartmentManager\DashboardController as DepartmentManagerDashboardController;
use App\Http\Controllers\Backend\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Backend\Doctor\ReportController as DoctorReportController;
use App\Http\Controllers\Backend\Doctor\PatientController as DoctorPatientController;
use App\Http\Controllers\Backend\Doctor\MedicalRecordsController as DoctorMedicalRecordsController;
use App\Http\Controllers\Backend\Doctor\InvoicesController as DoctorInvoicesController;
use App\Http\Controllers\Backend\Doctor\ProfileController as DoctorProfileController;
use App\Http\Controllers\Backend\Doctor\ClinicController as DoctorClinicController;

Route::prefix('clinics-management')->group(function () {

    //Home
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::post('/contact', [HomeController::class, 'send'])->name('contact_send');


    //Auth
    Route::get('/login', [AuthenticatedSessionController::class, 'login'])->name('login')->middleware('guest');
    Route::post('/user/login', [AuthenticatedSessionController::class, 'userLogin'])->name('user_login')->middleware('guest');
    Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout')->middleware('auth');

    Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register')->middleware('guest');

});




//Admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/my_profile' , [AdminDashboardController::class , 'myProfile'])->name('my_profile');
    Route::get('/edit/profile' , [AdminDashboardController::class , 'editProfile'])->name('edit_profile');
    Route::put('/update/profile' , [AdminDashboardController::class , 'updateProfile'])->name('update_profile');


    //Clinics
    Route::get('/add/clinic' ,[ClinicController::class , 'addClinic'])->name('add_clinic');
    Route::post('/store/clinic' ,[ClinicController::class , 'storeClinic'])->name('store_clinic');
    Route::get('/view/clinics' ,[ClinicController::class , 'viewClinics'])->name('view_clinics');
    Route::get('/search/clinics',[ClinicController::class , 'searchClinics'])->name('search_clinics');
    Route::get('/details/clinic/{id}' ,[ClinicController::class , 'detailsClinic'])->name('details_clinic');
    Route::get('/edit/clinic/{id}' ,[ClinicController::class , 'editClinic'])->name('edit_clinic');
    Route::put('/update/clinic/{id}' ,[ClinicController::class , 'updateClinic'])->name('update_clinic');
    Route::delete('/delete/clinic/{id}' ,[ClinicController::class , 'deleteClinic'])->name('delete_clinic');

    Route::get('/view/clinics-managers' ,[ClinicController::class , 'viewClinicsManagers'])->name('view_clinics_managers');
    Route::get('/search/clinics-managers',[ClinicController::class , 'searchClinicsManagers'])->name('search_clinics_managers');
    Route::get('/profile/clinics-managers/{id}',[ClinicController::class , 'profileClinicsManagers'])->name('profile_clinics_managers');
    Route::get('/edit/clinics-managers/{id}' ,[ClinicController::class , 'editClinicsManagers'])->name('edit_clinics_managers');
    Route::put('/update/clinics-managers/{id}' ,[ClinicController::class , 'updateClinicsManagers'])->name('update_clinics_managers');
    Route::delete('/delete/clinics-managers/{id}' ,[ClinicController::class , 'deleteClinicsManagers'])->name('delete_clinics_managers');

    //Department
    Route::get('/add/department' ,[DepartmentController::class , 'addDepartment'])->name('add_department');
    Route::post('/store/department' ,[DepartmentController::class , 'storeDepartment'])->name('store_department');
    Route::get('/view/departments' ,[DepartmentController::class , 'viewDepartments'])->name('view_departments');
    Route::get('/details/department/{id}' ,[DepartmentController::class , 'detailsDepartment'])->name('details_department');
    Route::get('/edit/department/{id}' ,[DepartmentController::class , 'editDepartment'])->name('edit_department');
    Route::put('/update/department/{id}' ,[DepartmentController::class , 'updateDepartment'])->name('update_department');
    Route::delete('/delete/department/{id}' ,[DepartmentController::class , 'deleteDepartment'])->name('delete_department');

    Route::get('/view/departments-managers', [DepartmentController::class, 'viewDepartmentsManagers'])->name('view_departments_managers');
    Route::get('/search/departments-managers',[DepartmentController::class , 'searchDepartmentsManagers'])->name('search_departments_managers');
    Route::get('/profile/department-manager/{id}',[DepartmentController::class , 'profileDepartmentManager'])->name('profile_department_manager');
    Route::get('/edit/department-manager/{id}' ,[DepartmentController::class , 'editDepartmentManager'])->name('edit_department_manager');
    Route::put('/update/department-manager/{id}' ,[DepartmentController::class , 'updateDepartmentManager'])->name('update_department_manager');
    Route::delete('/delete/department-manager/{id}' ,[DepartmentController::class , 'deleteDepartmentManager'])->name('delete_department_manager');



    //Employee
    Route::get('/add/employee' ,[EmployeeController::class , 'addEmployee'])->name('add_employee');
    Route::post('/store/employee',[EmployeeController::class , 'storeEmployee'])->name('store_employee');
    Route::get('/view/employees' ,[EmployeeController::class , 'viewEmployees'])->name('view_employees');
    Route::get('/search/employees',[EmployeeController::class , 'searchEmployees'])->name('search_employees');
    Route::get('/profile/employee/{id}',[EmployeeController::class , 'profileEmployee'])->name('profile_employee');
    Route::get('/edit/employee/{id}' ,[EmployeeController::class , 'editEmployee'])->name('edit_employee');
    Route::put('/update/employee/{id}' ,[EmployeeController::class , 'updateEmployee'])->name('update_employee');
    Route::delete('/delete/employee/{id}' ,[EmployeeController::class , 'deleteEmployee'])->name('delete_employee');

    Route::post('/check-job-requires-department', [EmployeeController::class, 'checkJobRequiresDepartment'])->name('check_job_requires_department');


    //Doctor
    Route::get('/add/doctor' ,[DoctorController::class , 'addDoctor'])->name('add_doctor');
    Route::post('/store/doctor',[DoctorController::class , 'storeDoctor'])->name('store_doctor');
    Route::get('/view/doctors' ,[DoctorController::class , 'viewDoctors'])->name('view_doctors');
    Route::get('/search/doctors',[DoctorController::class , 'searchDoctors'])->name('search_doctors');
    Route::get('/profile/doctor/{id}',[DoctorController::class , 'profileDoctor'])->name('profile_doctor');
    Route::get('/edit/doctor/{id}' ,[DoctorController::class , 'editDoctor'])->name('edit_doctor');
    Route::put('/update/doctor/{id}' ,[DoctorController::class , 'updateDoctor'])->name('update_doctor');
    Route::delete('/delete/doctor/{id}' ,[DoctorController::class , 'deleteDoctor'])->name('delete_doctor');

    Route::get('/search/doctor/schedules',[DoctorController::class ,  'searchDoctorSchedules']);
    Route::post('/search/doctor/schedules',[DoctorController::class , 'searchDoctchedules'])->name('search_doctor_schedules');

    Route::get('/get-departments-by-clinic/{clinic_id}', [DoctorController::class, 'getDepartmentsByClinic']);    // حتى عندما أختار العيادة المحددة يحضر لي فقط تخصصاتها في فورم إضافة طبيب
    Route::get('/get-specialties-by-department/{department_id}', [DoctorController::class, 'getSpecialtiesByDepartment']);
    Route::get('/get-clinic-info/{id}', [DoctorController::class, 'getClinicInfo']);  // بحضر لي أوقات العيادة في فورم الطبيب عشان أختار أوقات الطبيب بناء ع وقت العيادة
    Route::get('/clinic-working-days/{id}', [DoctorController::class, 'getWorkingDays']);    // برجع الأيام المحددة


    //Patient
    Route::get('/add/patient' ,[PatientController::class , 'addPatient'])->name('add_patient');
    Route::post('/store/patient',[PatientController::class , 'storePatient'])->name('store_patient');
    Route::get('/view/patients' ,[PatientController::class , 'viewPatients'])->name('view_patients');
    Route::get('/search/patients' ,[PatientController::class , 'searchPatients'])->name('search_patients');
    Route::get('/profile/patient/{id}',[PatientController::class , 'profilePatient'])->name('profile_patient');
    Route::get('/edit/patient/{id}' ,[PatientController::class , 'editPatient'])->name('edit_patient');
    Route::put('/update/patient/{id}' ,[PatientController::class , 'updatePatient'])->name('update_patient');
    Route::delete('/delete/patient/{id}' ,[PatientController::class , 'deletePatient'])->name('delete_patient');

    Route::get('/get-departments-by-clinic/{clinic_id}', [PatientController::class, 'getDepartmentsByClinic']);    // عند اختيار العيادة – جلب التخصصات المرتبطة بها فقط
    Route::get('/get-doctors-by-clinic-and-department', [PatientController::class, 'getDoctorsByClinicAndDepartment'])->name('get_doctors_by_clinic_and_department');  //  عند اختيار التخصص – جلب الأطباء الذين ينتمون لهذا التخصص فقط ومن نفس العيادة فقط
    Route::get('/get-doctor-info/{id}', [PatientController::class, 'getDoctorInfo']);   // يرجع أوقات الدكتور للحجز معاه
    Route::get('/doctor-working-days/{id}', [PatientController::class, 'getWorkingDays']);  // يرجع أيام الدكتور للحجز معاه


    //Appointment
    Route::get('/add/appointment' ,[AppointmentController::class , 'addAppointment'])->name('add_appointment');
    Route::post('/store/appointment',[AppointmentController::class , 'storeAppointment'])->name('store_appointment');
    Route::get('/view/appointments' ,[AppointmentController::class , 'viewAppointments'])->name('view_appointments');
    Route::get('/search/appointments',[AppointmentController::class , 'searchAppointments'])->name('search_appointments');
    Route::get('/details/appointment/{id}',[AppointmentController::class , 'detailsAppointment'])->name('details_appointment');
    Route::get('/edit/appointment/{id}' ,[AppointmentController::class , 'editAppointment'])->name('edit_appointment');
    Route::put('/update/appointment/{id}' ,[AppointmentController::class , 'updateAppointment'])->name('update_appointment');
    Route::delete('/delete/appointment/{id}' ,[AppointmentController::class ,'deleteAppointment'])->name('delete_appointment');









    // Notifications

    Route::get('/notifications/details/medication/read/{id}', [AdminNotificationController::class, 'markExpiredAsRead'])
    ->name('notifications_details_medication_read');   // إشعار الأدوية المنتهية

    Route::get('/notifications/details/read/{id}', [AdminNotificationController::class, 'markDetailsAsRead'])
    ->name('notifications_details_read');  // إشعار موافقة/رفض  طلب


});





//Clinic Manager
Route::prefix('clinic-manager')->middleware(['auth', 'verified', 'role:clinic_manager'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [ClinicManagerDashboardController::class, 'clinicManagerDashboard'])->name('clinic_manager_dashboard');
    Route::get('/my_profile' , [ClinicManagerDashboardController::class , 'clinicManagerProfile'])->name('clinic_manager_profile');
    Route::get('/edit/profile' , [ClinicManagerDashboardController::class , 'clinicManagerEditProfile'])->name('clinic_manager_edit_profile');
    Route::put('/update/profile' , [ClinicManagerDashboardController::class , 'clinicManagerUpdateProfile'])->name('clinic_manager_update_profile');

});



//Department Manager
Route::prefix('department-manager')->middleware(['auth', 'verified', 'role:department_manager'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DepartmentManagerDashboardController::class, 'departmentManagerDashboard'])->name('department_manager_dashboard');
    Route::get('/my_profile' , [DepartmentManagerDashboardController::class , 'departmentManagerProfile'])->name('department_manager_profile');
    Route::get('/edit/profile' , [DepartmentManagerDashboardController::class , 'departmentManagerEditProfile'])->name('department_manager_edit_profile');
    Route::put('/update/profile' , [DepartmentManagerDashboardController::class , 'departmentManagerUpdateProfile'])->name('department_manager_update_profile');
    Route::delete('/delete', [DepartmentManagerDashboardController::class, 'departmentManagerDelete'])->name('department_manager_delete');

    Route::get('/search', [DepartmentManagerDashboardController::class, 'departmentManagersearch'])->name('search_departments_managers');

});





//Doctor
Route::prefix('doctor')->middleware(['auth', 'verified', 'role:doctor'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DoctorDashboardController::class, 'doctorDashboard'])->name('doctor_dashboard');
    Route::get('/my_profile' , [DoctorProfileController::class , 'profile'])->name('doctor_profile');
    Route::get('/profile/edit', [DoctorProfileController::class, 'edit'])->name('doctor.profile.edit');
    Route::put('/profile/update', [DoctorProfileController::class, 'update'])->name('doctor.profile.update');
    Route::get('/profile/settings', [DoctorProfileController::class, 'settings'])->name('doctor.profile.settings');
    Route::post('/profile/settings/update-password', [DoctorProfileController::class, 'updatePassword'])->name('doctor.profile.updatePassword');
    Route::post('logout-other-devices', [DoctorProfileController::class, 'logoutAll'])->name('doctor.profile.logoutOtherDevices');
    Route::get('/reports/monthly', [DoctorReportController::class, 'monthly'])->name('doctor.reports.monthly');
    Route::get('/appointments', [DoctorAppointmentController::class, 'allAppointments'])->name('doctor.appointments');
    Route::get('/appointments/{appointment}', [DoctorAppointmentController::class, 'show'])->name('doctor.appointment.show');
    Route::post('/appointments/confirm/{appointment}', [DoctorAppointmentController::class, 'confirmAppointment'])->name('doctor_confirm_appointment');
    Route::post('/appointments/reject/{appointment}', [DoctorAppointmentController::class, 'rejectAppointment'])->name('doctor_reject_appointment');
    Route::post('/appointments/cancel/{appointment}', [DoctorAppointmentController::class, 'cancelAppointment'])->name('doctor_cancel_appointment');
    Route::get('/clinics/{clinic}', [DoctorClinicController::class, 'show'])->name('doctor.clinic.show');
    Route::get('/patients', [DoctorPatientController::class, 'index'])->name('doctor.patients');
    Route::get('/patients/{patient}', [DoctorPatientController::class, 'show'])->name('doctor.patients.show');
    Route::get('/medical-records', [DoctorMedicalRecordsController::class, 'index'])->name('doctor.medical_records');
    Route::get('/medical-records/create', [DoctorMedicalRecordsController::class, 'create'])->name('doctor.medical_records.create');
    Route::post('/medical-records/store', [DoctorMedicalRecordsController::class, 'store'])->name('doctor.medical_records.store');
    Route::get('medical-records/{medicalRecord}', [DoctorMedicalRecordsController::class, 'show'])->name('doctor.medical_records.show');
    Route::get('/medical-records/{medicalRecord}/edit', [DoctorMedicalRecordsController::class, 'edit'])->name('doctor.medical_records.edit');
    Route::put('/medical-records/{medicalRecord}/update', [DoctorMedicalRecordsController::class, 'update'])->name('doctor.medical_records.update');
    Route::get('/invoices', [DoctorInvoicesController::class, 'index'])->name('doctor.invoices');
});





//Employees

/** Nurses **/
Route::prefix('employee/nurse')->middleware(['auth', 'verified', 'role:employee'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [NurseDashboardController::class, 'nurseDashboard'])->name('nurse_dashboard');
    Route::get('/profile' , [NurseDashboardController::class , 'nurseProfile'])->name('nurse_profile');
    Route::get('/edit/profile' , [NurseDashboardController::class , 'nurseEditProfile'])->name('nurse_edit_profile');
    Route::put('/update/profile' , [NurseDashboardController::class , 'nurseUpdateProfile'])->name('nurse_update_profile');




});





/** Receptionists **/
Route::prefix('employee/receptionist')->middleware(['auth', 'verified', 'role:employee'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [ReceptionistDashboardController::class, 'receptionistDashboard'])->name('receptionist_dashboard');
    Route::get('/profile' , [ReceptionistDashboardController::class , 'receptionistProfile'])->name('receptionist_profile');
    Route::get('/edit/profile' , [ReceptionistDashboardController::class , 'receptionistEditProfile'])->name('receptionist_edit_profile');
    Route::put('/update/profile' , [ReceptionistDashboardController::class , 'receptionistUpdateProfile'])->name('receptionist_update_profile');




});







//Patient
Route::prefix('patient')->middleware(['auth', 'verified', 'role:patient'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PatientDashboardController::class, 'patientDashboard'])->name('patient_dashboard');
    Route::get('/my_profile' , [PatientDashboardController::class , 'patientProfile'])->name('patient_profile');
    Route::get('/edit/profile' , [PatientDashboardController::class , 'patientEditProfile'])->name('patient_edit_profile');
    Route::put('/update/profile' , [PatientDashboardController::class , 'patientUpdateProfile'])->name('patient_update_profile');

});








