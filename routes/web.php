<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Backend\Shared\CommonDoctorController;

use App\Http\Controllers\Backend\Admin\ChartController as AdminChartController;
use App\Http\Controllers\Backend\Admin\ClinicController as AdminClinicController;
use App\Http\Controllers\Backend\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Backend\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Backend\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Backend\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Backend\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Backend\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Backend\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Backend\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Backend\Admin\MedicalRecordController as AdminMedicalRecordController;

use App\Http\Controllers\Backend\ClinicManager\ChartController as ClinicManagerChartController;
use App\Http\Controllers\Backend\ClinicManager\ClinicController as ClinicManagerClinicController;
use App\Http\Controllers\Backend\ClinicManager\DoctorController as ClinicManagerDoctorController;
use App\Http\Controllers\Backend\ClinicManager\ReportController as ClinicManagerReportController;
use App\Http\Controllers\Backend\ClinicManager\InvoiceController as ClinicManagerInvoiceController;
use App\Http\Controllers\Backend\ClinicManager\PatientController as ClinicManagerPatientController;
use App\Http\Controllers\Backend\ClinicManager\EmployeeController as ClinicManagerEmployeeController;
use App\Http\Controllers\Backend\ClinicManager\DashboardController as ClinicManagerDashboardController;
use App\Http\Controllers\Backend\ClinicManager\DepartmentController as ClinicManagerDepartmentController;
use App\Http\Controllers\Backend\ClinicManager\AppointmentController as ClinicManagerAppointmentController;


use App\Http\Controllers\Backend\DepartmentManager\DashboardController as DepartmentManagerDashboardController;
use App\Http\Controllers\Backend\DepartmentManager\ClinicController as DepartmentManagerClinicController;
use App\Http\Controllers\Backend\DepartmentManager\DepartmentController as DepartmentManagerDepartmentController;
use App\Http\Controllers\Backend\DepartmentManager\EmployeeController as DepartmentManagerEmployeeController;
use App\Http\Controllers\Backend\DepartmentManager\DoctorController as DepartmentManagerDoctorController;
use App\Http\Controllers\Backend\DepartmentManager\PatientController as DepartmentManagerPatientController;
use App\Http\Controllers\Backend\DepartmentManager\AppointmentController as DepartmentManagerAppointmentController;
use App\Http\Controllers\Backend\DepartmentManager\ReportController as DepartmentManagerReportController;
use App\Http\Controllers\Backend\DepartmentManager\ChartController as DepartmentManagerChartController;


use App\Http\Controllers\Backend\Doctor\ClinicController as DoctorClinicController;
use App\Http\Controllers\Backend\Doctor\ReportController as DoctorReportController;
use App\Http\Controllers\Backend\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Backend\Doctor\MedicalRecordsController as DoctorMedicalRecordsController;
use App\Http\Controllers\Backend\Doctor\PatientController as DoctorPatientController;
use App\Http\Controllers\Backend\Doctor\ProfileController as DoctorProfileController;
use App\Http\Controllers\Backend\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Backend\Doctor\InvoicesController as DoctorInvoicesController;


use App\Http\Controllers\Backend\Employee\Receptionist\DashboardController as ReceptionistDashboardController;


use App\Http\Controllers\Backend\Employee\Nurse\DashboardController as NurseDashboardController;


use App\Http\Controllers\Backend\Patient\DashboardController as PatientDashboardController;


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


    //Shared
    Route::get('/get-doctors-by-clinic-and-department', [CommonDoctorController::class, 'getDoctorsByClinicAndDepartment'])->name('get_doctors_by_clinic_and_department');
    Route::get('/get-doctor-info/{id}', [CommonDoctorController::class, 'getDoctorInfo']);   // يرجع أوقات الدكتور للحجز معاه
    Route::get('/doctor-working-days/{id}', [CommonDoctorController::class, 'getWorkingDays']);  // يرجع أيام الدكتور للحجز معاه



});




//Admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/my_profile' , [AdminDashboardController::class , 'myProfile'])->name('my_profile');
    Route::get('/edit/profile' , [AdminDashboardController::class , 'editProfile'])->name('edit_profile');
    Route::put('/update/profile' , [AdminDashboardController::class , 'updateProfile'])->name('update_profile');


    //Clinics
    Route::get('/add/clinic' ,[AdminClinicController::class , 'addClinic'])->name('add_clinic');
    Route::post('/store/clinic' ,[AdminClinicController::class , 'storeClinic'])->name('store_clinic');
    Route::get('/view/clinics' ,[AdminClinicController::class , 'viewClinics'])->name('view_clinics');
    Route::get('/search/clinics',[AdminClinicController::class , 'searchClinics'])->name('search_clinics');
    Route::get('/details/clinic/{id}' ,[AdminClinicController::class , 'detailsClinic'])->name('details_clinic');
    Route::get('/edit/clinic/{id}' ,[AdminClinicController::class , 'editClinic'])->name('edit_clinic');
    Route::put('/update/clinic/{id}' ,[AdminClinicController::class , 'updateClinic'])->name('update_clinic');
    Route::delete('/delete/clinic/{id}' ,[AdminClinicController::class , 'deleteClinic'])->name('delete_clinic');

    Route::get('/view/clinics-managers' ,[AdminClinicController::class , 'viewClinicsManagers'])->name('view_clinics_managers');
    Route::get('/search/clinics-managers',[AdminClinicController::class , 'searchClinicsManagers'])->name('search_clinics_managers');
    Route::get('/profile/clinics-managers/{id}',[AdminClinicController::class , 'profileClinicsManagers'])->name('profile_clinics_managers');
    Route::get('/edit/clinics-managers/{id}' ,[AdminClinicController::class , 'editClinicsManagers'])->name('edit_clinics_managers');
    Route::put('/update/clinics-managers/{id}' ,[AdminClinicController::class , 'updateClinicsManagers'])->name('update_clinics_managers');
    Route::delete('/delete/clinics-managers/{id}' ,[AdminClinicController::class , 'deleteClinicsManagers'])->name('delete_clinics_managers');

    //Departments
    Route::get('/add/department' ,[AdminDepartmentController::class , 'addDepartment'])->name('add_department');
    Route::post('/store/department' ,[AdminDepartmentController::class , 'storeDepartment'])->name('store_department');
    Route::get('/view/departments' ,[AdminDepartmentController::class , 'viewDepartments'])->name('view_departments');
    Route::get('/details/department/{id}' ,[AdminDepartmentController::class , 'detailsDepartment'])->name('details_department');
    Route::get('/edit/department/{id}' ,[AdminDepartmentController::class , 'editDepartment'])->name('edit_department');
    Route::put('/update/department/{id}' ,[AdminDepartmentController::class , 'updateDepartment'])->name('update_department');
    Route::delete('/delete/department/{id}' ,[AdminDepartmentController::class , 'deleteDepartment'])->name('delete_department');

    Route::get('/view/departments-managers', [AdminDepartmentController::class, 'viewDepartmentsManagers'])->name('view_departments_managers');
    Route::get('/search/departments-managers',[AdminDepartmentController::class , 'searchDepartmentsManagers'])->name('search_departments_managers');
    Route::get('/profile/department-manager/{id}',[AdminDepartmentController::class , 'profileDepartmentManager'])->name('profile_department_manager');
    Route::get('/edit/department-manager/{id}' ,[AdminDepartmentController::class , 'editDepartmentManager'])->name('edit_department_manager');
    Route::put('/update/department-manager/{id}' ,[AdminDepartmentController::class , 'updateDepartmentManager'])->name('update_department_manager');
    Route::delete('/delete/department-manager/{id}' ,[AdminDepartmentController::class , 'deleteDepartmentManager'])->name('delete_department_manager');



    //Employee
    Route::get('/add/employee' ,[AdminEmployeeController::class , 'addEmployee'])->name('add_employee');
    Route::post('/store/employee',[AdminEmployeeController::class , 'storeEmployee'])->name('store_employee');
    Route::get('/view/employees' ,[AdminEmployeeController::class , 'viewEmployees'])->name('view_employees');
    Route::get('/search/employees',[AdminEmployeeController::class , 'searchEmployees'])->name('search_employees');
    Route::get('/profile/employee/{id}',[AdminEmployeeController::class , 'profileEmployee'])->name('profile_employee');
    Route::get('/edit/employee/{id}' ,[AdminEmployeeController::class , 'editEmployee'])->name('edit_employee');
    Route::put('/update/employee/{id}' ,[AdminEmployeeController::class , 'updateEmployee'])->name('update_employee');
    Route::delete('/delete/employee/{id}' ,[AdminEmployeeController::class , 'deleteEmployee'])->name('delete_employee');

    Route::post('/check-job-requires-department', [AdminEmployeeController::class, 'checkJobRequiresDepartment'])->name('check_job_requires_department');


    //Doctor
    Route::get('/add/doctor' ,[AdminDoctorController::class , 'addDoctor'])->name('add_doctor');
    Route::post('/store/doctor',[AdminDoctorController::class , 'storeDoctor'])->name('store_doctor');
    Route::get('/view/doctors' ,[AdminDoctorController::class , 'viewDoctors'])->name('view_doctors');
    Route::get('/search/doctors',[AdminDoctorController::class , 'searchDoctors'])->name('search_doctors');
    Route::get('/profile/doctor/{id}',[AdminDoctorController::class , 'profileDoctor'])->name('profile_doctor');
    Route::get('/edit/doctor/{id}' ,[AdminDoctorController::class , 'editDoctor'])->name('edit_doctor');
    Route::put('/update/doctor/{id}' ,[AdminDoctorController::class , 'updateDoctor'])->name('update_doctor');
    Route::delete('/delete/doctor/{id}' ,[AdminDoctorController::class , 'deleteDoctor'])->name('delete_doctor');

    Route::get('/search/schedules',[AdminDoctorController::class ,  'searchSchedules'])->name('search_schedules');
    Route::post('/search/doctor/schedule',[AdminDoctorController::class , 'searchDoctSchedule'])->name('search_doctor_schedule');

    Route::get('/get-departments-by-clinic/{clinic_id}', [AdminDoctorController::class, 'getDepartmentsByClinic']);    // حتى عندما أختار العيادة المحددة يحضر لي فقط أقسامها في فورم إضافة طبيب
    Route::get('/get-clinic-info/{id}', [AdminDoctorController::class, 'getClinicInfo']);  // بحضر لي أوقات العيادة في فورم الطبيب عشان أختار أوقات الطبيب بناء ع وقت العيادة
    Route::get('/clinic-working-days/{id}', [AdminDoctorController::class, 'getWorkingDays']);    // برجع الأيام المحددة


    //Patient
    Route::get('/add/patient' ,[AdminPatientController::class , 'addPatient'])->name('add_patient');
    Route::post('/store/patient',[AdminPatientController::class , 'storePatient'])->name('store_patient');
    Route::get('/view/patients' ,[AdminPatientController::class , 'viewPatients'])->name('view_patients');
    Route::get('/search/patients' ,[AdminPatientController::class , 'searchPatients'])->name('search_patients');
    Route::get('/profile/patient/{id}',[AdminPatientController::class , 'profilePatient'])->name('profile_patient');
    Route::get('/edit/patient/{id}' ,[AdminPatientController::class , 'editPatient'])->name('edit_patient');
    Route::put('/update/patient/{id}' ,[AdminPatientController::class , 'updatePatient'])->name('update_patient');
    Route::delete('/delete/patient/{id}' ,[AdminPatientController::class , 'deletePatient'])->name('delete_patient');


    //Appointment
    Route::get('/add/appointment' ,[AdminAppointmentController::class , 'addAppointment'])->name('add_appointment');
    Route::post('/store/appointment',[AdminAppointmentController::class , 'storeAppointment'])->name('store_appointment');
    Route::get('/view/appointments' ,[AdminAppointmentController::class , 'viewAppointments'])->name('view_appointments');
    Route::get('/search/appointments',[AdminAppointmentController::class , 'searchAppointments'])->name('search_appointments');
    Route::get('/details/appointment/{id}',[AdminAppointmentController::class , 'detailsAppointment'])->name('details_appointment');
    Route::get('/edit/appointment/{id}' ,[AdminAppointmentController::class , 'editAppointment'])->name('edit_appointment');
    Route::put('/update/appointment/{id}' ,[AdminAppointmentController::class , 'updateAppointment'])->name('update_appointment');
    Route::delete('/delete/appointment/{id}' ,[AdminAppointmentController::class ,'deleteAppointment'])->name('delete_appointment');



    //Invoices
    Route::get('/view/invoices' ,[AdminInvoiceController::class , 'viewInvoices'])->name('view_invoices');
    Route::get('/search/invoices',[AdminInvoiceController::class , 'searchInvoices'])->name('search_invoices');
    Route::get('/details/invoice/{id}',[AdminInvoiceController::class , 'detailsInvoice'])->name('details_invoice');
    Route::get('/edit/invoice/{id}' ,[AdminInvoiceController::class , 'editInvoice'])->name('edit_invoice');
    Route::put('/update/invoice/{id}' ,[AdminInvoiceController::class , 'updateInvoice'])->name('update_invoice');
    Route::delete('/delete/invoice/{id}' ,[AdminInvoiceController::class ,'deleteInvoice'])->name('delete_invoice');


    //Reports
    Route::get('/view/reports' ,[AdminReportController::class , 'viewReports'])->name('view_reports');
    Route::get('/details/patients-reports' ,[AdminReportController::class , 'detailsPatientsReports'])->name('details_patients_reports');
    Route::get('/details/appointments-reports' ,[AdminReportController::class , 'detailsAppointmentsReports'])->name('details_appointments_reports');
    Route::get('/details/invoices-reports' ,[AdminReportController::class , 'detailsInvoicesReports'])->name('details_invoices_reports');
    Route::get('/details/doctors-reports' ,[AdminReportController::class , 'detailsDoctorsReports'])->name('details_doctors_reports');


    //Medical Records
    Route::get('/view/medical-records' ,[AdminMedicalRecordController::class , 'viewMedicalRecords'])->name('view_medical_records');
    Route::get('/search/medical-records',[AdminMedicalRecordController::class , 'searchMedicalRecords'])->name('search_medical_records');
    Route::get('/details/medical-record/{id}',[AdminMedicalRecordController::class , 'detailsMedicalRecord'])->name('details_medical_record');
    Route::get('/edit/medical-record/{id}' ,[AdminMedicalRecordController::class , 'editMedicalRecord'])->name('edit_medical_record');
    Route::put('/update/medical-record/{id}' ,[AdminMedicalRecordController::class , 'updateMedicalRecord'])->name('update_medical_record');
    Route::delete('/delete/medical-record/{id}' ,[AdminMedicalRecordController::class ,'deleteMedicalRecord'])->name('delete_medical_record');


    //Chart
    Route::get('/chart/appointments-monthly', [AdminChartController::class, 'appointmentsMonthly'])->name('appointments_monthly');
    Route::get('/chart/patients-per-clinic', [AdminChartController::class, 'patientsPerClinic'])->name('patients_per_clinic');
    Route::get('/chart/patients-monthly', [AdminChartController::class, 'patientsPerMonth'])->name('patients_monthly');
    Route::get('/chart/appointments-by-clinic', [AdminChartController::class, 'getAppointmentsByClinic'])->name('appointments_by_clinic');
    Route::get('/chart/revenue-monthly', [AdminChartController::class, 'monthlyRevenue'])->name('monthly_revenue');
    Route::get('/chart/revenue-per-clinic', [AdminChartController::class, 'revenuePerClinic'])->name('revenue_per_clinic');
    Route::get('/chart/doctors-monthly', [AdminChartController::class, 'doctorsMonthly'])->name('doctors_monthly');
    Route::get('/chart/doctors-by-department', [AdminChartController::class, 'doctorsByDepartment'])->name('doctors_by_department');



    // Notifications
    Route::get('/notifications/details/medication/read/{id}', [AdminNotificationController::class, 'markExpiredAsRead'])
    ->name('notifications_details_medication_read');   // إشعار الأدوية المنتهية

    Route::get('/notifications/details/read/{id}', [AdminNotificationController::class, 'markDetailsAsRead'])
    ->name('notifications_details_read');  // إشعار موافقة/رفض  طلب


});





//Clinic Manager
Route::prefix('clinic-manager')->middleware(['auth', 'verified', 'role:clinic_manager'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [ClinicManagerDashboardController::class, 'clinicManagerDashboard'])->name('clinic_manager_dashboard');
    Route::get('/profile' , [ClinicManagerDashboardController::class , 'clinicManagerProfile'])->name('clinic_manager_profile');
    Route::get('/edit/profile' , [ClinicManagerDashboardController::class , 'clinicManagerEditProfile'])->name('clinic_manager_edit_profile');
    Route::put('/update/profile' , [ClinicManagerDashboardController::class , 'clinicManagerUpdateProfile'])->name('clinic_manager_update_profile');


    //Clinics
    Route::get('/clinic-profile', [ClinicManagerClinicController::class, 'clinicProfile'])->name('clinic_profile');
    Route::get('/edit/clinic-profile', [ClinicManagerClinicController::class, 'editClinicProfile'])->name('edit_clinic_profile');
    Route::put('/update/clinic-profile', [ClinicManagerClinicController::class, 'updateClinicProfile'])->name('update_clinic_profile');


    //Departments
    Route::get('/view/departments' ,[ClinicManagerDepartmentController::class , 'viewDepartments'])->name('clinic.view_departments');
    Route::get('/add/department/toClinic' ,[ClinicManagerDepartmentController::class , 'addDepartmentToClinic'])->name('clinic.add_department');
    Route::post('/store/department/toClinic' ,[ClinicManagerDepartmentController::class , 'storeDepartmentToClinic'])->name('clinic.store_department');
    Route::get('/details/department/{id}' ,[ClinicManagerDepartmentController::class , 'detailsDepartment'])->name('clinic.details_department');
    Route::delete('/delete/department/{id}' ,[ClinicManagerDepartmentController::class , 'deleteDepartment'])->name('clinic.delete_department');


    //Employees
    Route::get('/add/employee' ,[ClinicManagerEmployeeController::class , 'addEmployee'])->name('clinic.add_employee');
    Route::post('/store/employee',[ClinicManagerEmployeeController::class , 'storeEmployee'])->name('clinic.store_employee');
    Route::get('/view/employees' ,[ClinicManagerEmployeeController::class , 'viewEmployees'])->name('clinic.view_employees');
    Route::get('/search/employees',[ClinicManagerEmployeeController::class , 'searchEmployees'])->name('clinic.search_employees');
    Route::get('/profile/employee/{id}',[ClinicManagerEmployeeController::class , 'profileEmployee'])->name('clinic.profile_employee');
    Route::get('/edit/employee/{id}' ,[ClinicManagerEmployeeController::class , 'editEmployee'])->name('clinic.edit_employee');
    Route::put('/update/employee/{id}' ,[ClinicManagerEmployeeController::class , 'updateEmployee'])->name('clinic.update_employee');
    Route::delete('/delete/employee/{id}' ,[ClinicManagerEmployeeController::class , 'deleteEmployee'])->name('clinic.delete_employee');


    //Doctors
    Route::get('/add/doctor' ,[ClinicManagerDoctorController::class , 'addDoctor'])->name('clinic.add_doctor');
    Route::post('/store/doctor',[ClinicManagerDoctorController::class , 'storeDoctor'])->name('clinic.store_doctor');
    Route::get('/view/doctors' ,[ClinicManagerDoctorController::class , 'viewDoctors'])->name('clinic.view_doctors');
    Route::get('/search/doctors',[ClinicManagerDoctorController::class , 'searchDoctors'])->name('clinic.search_doctors');
    Route::get('/profile/doctor/{id}',[ClinicManagerDoctorController::class , 'profileDoctor'])->name('clinic.profile_doctor');
    Route::get('/edit/doctor/{id}' ,[ClinicManagerDoctorController::class , 'editDoctor'])->name('clinic.edit_doctor');
    Route::put('/update/doctor/{id}' ,[ClinicManagerDoctorController::class , 'updateDoctor'])->name('clinic.update_doctor');
    Route::delete('/delete/doctor/{id}' ,[ClinicManagerDoctorController::class , 'deleteDoctor'])->name('clinic.delete_doctor');

    Route::get('/search/schedules',[ClinicManagerDoctorController::class ,  'searchSchedules'])->name('clinic.search_schedules');
    Route::post('/search/doctor/schedule',[ClinicManagerDoctorController::class , 'searchDoctchedule'])->name('clinic.search_doctor_schedule');


    //Patient
    Route::get('/view/patients' ,[ClinicManagerPatientController::class , 'viewPatients'])->name('clinic.view_patients');
    Route::get('/search/patients' ,[ClinicManagerPatientController::class , 'searchPatients'])->name('clinic.search_patients');
    Route::get('/profile/patient/{id}',[ClinicManagerPatientController::class , 'profilePatient'])->name('clinic.profile_patient');


    //Appointment
    Route::get('/view/appointments' ,[ClinicManagerAppointmentController::class , 'viewAppointments'])->name('clinic.view_appointments');
    Route::get('/search/appointments',[ClinicManagerAppointmentController::class , 'searchAppointments'])->name('clinic.search_appointments');
    Route::get('/details/appointment/{id}',[ClinicManagerAppointmentController::class , 'detailsAppointment'])->name('clinic.details_appointment');
    Route::delete('/delete/appointment/{id}' ,[ClinicManagerAppointmentController::class ,'deleteAppointment'])->name('clinic.delete_appointment');


    //Reports
    Route::get('/view/reports' ,[ClinicManagerReportController::class , 'viewReports'])->name('clinic.view_reports');
    Route::get('/details/patients-reports' ,[ClinicManagerReportController::class , 'detailsPatientsReports'])->name('clinic.details_patients_reports');
    Route::get('/details/appointments-reports' ,[ClinicManagerReportController::class , 'detailsAppointmentsReports'])->name('clinic.details_appointments_reports');
    Route::get('/details/invoices-reports' ,[ClinicManagerReportController::class , 'detailsInvoicesReports'])->name('clinic.details_invoices_reports');
    Route::get('/details/doctors-reports' ,[ClinicManagerReportController::class , 'detailsDoctorsReports'])->name('clinic.details_doctors_reports');


    //Invoices
    Route::get('/view/invoices' ,[ClinicManagerInvoiceController::class , 'viewInvoices'])->name('clinic.view_invoices');
    Route::get('/search/invoices',[ClinicManagerInvoiceController::class , 'searchInvoices'])->name('clinic.search_invoices');
    Route::get('/details/invoice/{id}',[ClinicManagerInvoiceController::class , 'detailsInvoice'])->name('clinic.details_invoice');


    //Chart
    Route::get('/clinic-manager/appointments-per-month', [ClinicManagerChartController::class, 'clinicAppointmentsPerMonth'])->name('clinic_manager.appointments_per_month');
    Route::get('/clinic-patients-monthly', [ClinicManagerChartController::class, 'clinicPatientsMonthly'])->name('clinic_patients_monthly');
    Route::get('/clinic-revenue-monthly', [ClinicManagerChartController::class, 'clinicMonthlyRevenue'])->name('clinic_monthly_revenue');
    Route::get('/clinic-doctors-monthly', [ClinicManagerChartController::class, 'clinicDoctorsMonthly'])->name('clinic_doctors_monthly');

});



//Department Manager
Route::prefix('department-manager')->middleware(['auth', 'verified', 'role:department_manager'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DepartmentManagerDashboardController::class, 'departmentManagerDashboard'])->name('department_manager_dashboard');
    Route::get('/profile' , [DepartmentManagerDashboardController::class , 'departmentManagerProfile'])->name('department_manager_profile');
    Route::get('/edit/profile' , [DepartmentManagerDashboardController::class , 'departmentManagerEditProfile'])->name('department_manager_edit_profile');
    Route::put('/update/profile' , [DepartmentManagerDashboardController::class , 'departmentManagerUpdateProfile'])->name('department_manager_update_profile');
    Route::delete('/delete', [DepartmentManagerDashboardController::class, 'departmentManagerDelete'])->name('department_manager_delete');


    //Clinic
    Route::get('/clinic-profile', [DepartmentManagerClinicController::class, 'clinicProfile'])->name('department.clinic_profile');


    //Department
    Route::get('/depratment-profile', [DepartmentManagerDepartmentController::class, 'depratmentProfile'])->name('depratment_profile');
    Route::get('/edit/depratment-profile', [DepartmentManagerDepartmentController::class, 'editDepratmentProfile'])->name('edit_depratment_profile');
    Route::put('/update/depratment-profile', [DepartmentManagerDepartmentController::class, 'updateDepratmentProfile'])->name('update_depratment_profile');


    //Employees
    Route::get('/view/employees' ,[DepartmentManagerEmployeeController::class , 'viewEmployees'])->name('department.view_employees');
    Route::get('/search/employees',[DepartmentManagerEmployeeController::class , 'searchEmployees'])->name('department.search_employees');
    Route::get('/profile/employee/{id}',[DepartmentManagerEmployeeController::class , 'profileEmployee'])->name('department.profile_employee');


    //Doctors
    Route::get('/view/doctors' ,[DepartmentManagerDoctorController::class , 'viewDoctors'])->name('department.view_doctors');
    Route::get('/search/doctors',[DepartmentManagerDoctorController::class , 'searchDoctors'])->name('department.search_doctors');
    Route::get('/profile/doctor/{id}',[DepartmentManagerDoctorController::class , 'profileDoctor'])->name('department.profile_doctor');

    Route::get('/search/schedules',[DepartmentManagerDoctorController::class ,  'searchSchedules'])->name('department.search_schedules');
    Route::post('/search/doctor/schedule',[DepartmentManagerDoctorController::class , 'searchDoctchedule'])->name('department.search_doctor_schedule');


    //Patient
    Route::get('/view/patients' ,[DepartmentManagerPatientController::class , 'viewPatients'])->name('department.view_patients');
    Route::get('/search/patients' ,[DepartmentManagerPatientController::class , 'searchPatients'])->name('department.search_patients');
    Route::get('/profile/patient/{id}',[DepartmentManagerPatientController::class , 'profilePatient'])->name('department.profile_patient');


    //Appointment
    Route::get('/view/appointments' ,[DepartmentManagerAppointmentController::class , 'viewAppointments'])->name('department.view_appointments');
    Route::get('/search/appointments',[DepartmentManagerAppointmentController::class , 'searchAppointments'])->name('department.search_appointments');
    Route::get('/details/appointment/{id}',[DepartmentManagerAppointmentController::class , 'detailsAppointment'])->name('department.details_appointment');
    Route::delete('/delete/appointment/{id}' ,[DepartmentManagerAppointmentController::class ,'deleteAppointment'])->name('department.delete_appointment');


    //Reports
    Route::get('/view/reports' ,[DepartmentManagerReportController::class , 'viewReports'])->name('department.view_reports');
    Route::get('/details/patients-reports' ,[DepartmentManagerReportController::class , 'detailsPatientsReports'])->name('department.details_patients_reports');
    Route::get('/details/appointments-reports' ,[DepartmentManagerReportController::class , 'detailsAppointmentsReports'])->name('department.details_appointments_reports');
    Route::get('/details/invoices-reports' ,[DepartmentManagerReportController::class , 'detailsInvoicesReports'])->name('department.details_invoices_reports');
    Route::get('/details/doctors-reports' ,[DepartmentManagerReportController::class , 'detailsDoctorsReports'])->name('department.details_doctors_reports');


    //Chart
    Route::get('/department-manager/appointments-per-month', [DepartmentManagerChartController::class, 'departmentAppointmentsPerMonth'])->name('department_manager.appointments_per_month');
    Route::get('/department-patients-monthly', [DepartmentManagerChartController::class, 'departmentPatientsMonthly'])->name('department_patients_monthly');
    Route::get('/department-doctors-monthly', [DepartmentManagerChartController::class, 'departmentDoctorsMonthly'])->name('department_doctors_monthly');

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
    Route::get('/calendar', [DoctorAppointmentController::class, 'calendar'])->name('doctor.calendar');
    Route::get('/reports/monthly', [DoctorReportController::class, 'monthly'])->name('doctor.reports.monthly');
    Route::get('/appointments', [DoctorAppointmentController::class, 'allAppointments'])->name('doctor.appointments');
    Route::get('/appointments/{appointment}', [DoctorAppointmentController::class, 'show'])->name('doctor.appointment.show');
    Route::post('/appointments/confirm/{appointment}', [DoctorAppointmentController::class, 'confirmAppointment'])->name('doctor_confirm_appointment');
    Route::post('/appointments/reject/{appointment}', [DoctorAppointmentController::class, 'rejectAppointment'])->name('doctor_reject_appointment');
    Route::post('/appointments/cancel/{appointment}', [DoctorAppointmentController::class, 'cancelAppointment'])->name('doctor_cancel_appointment');
    Route::get('/clinics/{clinic}', [DoctorClinicController::class, 'show'])->name('doctor.clinic.show');
    Route::get('/patients', [DoctorPatientController::class, 'index'])->name('doctor.patients');
    Route::get('/patients/{patient}', [DoctorPatientController::class, 'show'])->name('doctor.patients.show');
    Route::get('patients/{patient}/records', [DoctorMedicalRecordsController::class, 'patientRecords'])->name('doctor.patient.records');
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








