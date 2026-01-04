<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


use App\Http\Controllers\Backend\Shared\CommonClinicController;
use App\Http\Controllers\Backend\Shared\CommonDoctorController;
use App\Http\Controllers\Backend\Shared\NotificationController;
use App\Http\Controllers\Backend\Shared\ChatController;


use App\Http\Controllers\Backend\Admin\{
    DashboardController as AdminDashboardController,
    ChartController as AdminChartController,
    ClinicController as AdminClinicController,
    DepartmentController as AdminDepartmentController,
    DoctorController as AdminDoctorController,
    PatientController as AdminPatientController,
    EmployeeController as AdminEmployeeController,
    AppointmentController as AdminAppointmentController,
    InvoiceController as AdminInvoiceController,
    MedicalRecordController as AdminMedicalRecordController,
    AnalyticController as AdminAnalyticController,
};

use App\Http\Controllers\Backend\Admin\Report\{
    PatientController as AdminReportPatientController,
    EmployeeController as AdminReportEmployeeController,
    DoctorController as AdminReportDoctorController,
    InvoiceController as AdminReportInvoiceController,
    AppointmentController as AdminReportAppointmentController
};

use App\Http\Controllers\Backend\ClinicManager\{
    DashboardController as ClinicManagerDashboardController,
    ClinicController as ClinicManagerClinicController,
    DoctorController as ClinicManagerDoctorController,
    PatientController as ClinicManagerPatientController,
    EmployeeController as ClinicManagerEmployeeController,
    DepartmentController as ClinicManagerDepartmentController,
    AppointmentController as ClinicManagerAppointmentController,
    InvoiceController as ClinicManagerInvoiceController,
    ReportController as ClinicManagerReportController,
    ChartController as ClinicManagerChartController
};

use App\Http\Controllers\Backend\DepartmentManager\{
    DashboardController as DepartmentManagerDashboardController,
    ClinicController as DepartmentManagerClinicController,
    DepartmentController as DepartmentManagerDepartmentController,
    DoctorController as DepartmentManagerDoctorController,
    PatientController as DepartmentManagerPatientController,
    EmployeeController as DepartmentManagerEmployeeController,
    AppointmentController as DepartmentManagerAppointmentController,
    ReportController as DepartmentManagerReportController,
    ChartController as DepartmentManagerChartController
};

use App\Http\Controllers\Backend\Doctor\{
    DashboardController as DoctorDashboardController,
    ProfileController as DoctorProfileController,
    AppointmentController as DoctorAppointmentController,
    PatientController as DoctorPatientController,
    InvoicesController as DoctorInvoicesController,
    MedicalRecordsController as DoctorMedicalRecordsController,
    ReportController as DoctorReportController,
    NurseTaskController as DoctorNurseTaskController,
    ClinicController as DoctorClinicController
};


use App\Http\Controllers\Backend\Employee\Nurse\{
    DashboardController as NurseDashboardController,
    ClinicController as NurseClinicController,
    DepartmentController as NurseDepartmentController,
    DoctorController as NurseDoctorController,
    PatientController as NursePatientController,
    AppointmentController as NurseAppointmentController,
    VitalSignsController as NurseVitalSignsController,
    MedicalRecordController as NurseMedicalRecordController,
    NurseTaskController as NurseTaskController
};

use App\Http\Controllers\Backend\Employee\Accountant\{
    DashboardController as AccountantDashboardController,
    ClinicController as AccountantClinicController,
    DepartmentController as AccountantDepartmentController,
    DoctorController as AccountantDoctorController,
    PatientController as AccountantPatientController,
    AppointmentController as AccountantAppointmentController,
    NotificationController as AccountantNotificationController,
    InvoiceController as AccountantInvoiceController
};

use App\Http\Controllers\Backend\Employee\Receptionist\{
    DashboardController as ReceptionistDashboardController,
    ClinicController as ReceptionistClinicController,
    DepartmentController as ReceptionistDepartmentController,
    DoctorController as ReceptionistDoctorController,
    PatientController as ReceptionistPatientController,
    AppointmentController as ReceptionistAppointmentController,
    InvoiceController as ReceptionistInvoiceController
};

use App\Http\Controllers\Backend\Patient\{
    DashboardController as PatientDashboardController,
    ProfileController as PatientProfileController,
    AppointmentController as PatientAppointmentController,
    InvoiceController as PatientInvoiceController,
    MedicalRecordController as PatientMedicalRecordController
};


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


    //Forgot Password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'showForgotForm'])->middleware('guest')->name('password_request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'sendResetLink'])->middleware('guest')->name('password_email');

    Route::get('/reset-password/{token}', [PasswordResetLinkController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [PasswordResetLinkController::class, 'resetPassword'])->middleware('guest')->name('password.update');


    Route::post('/check-email', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'email' => 'required|email:rfc,dns',
        ]);
        return response()->json(['valid' => true]);
    })->name('check_email');


    //Shared
    Route::get('/get-doctors-by-clinic-and-department', [CommonDoctorController::class, 'getDoctorsByClinicAndDepartment'])->name('get_doctors_by_clinic_and_department');
    Route::get('/get-doctor-info/{id}', [CommonDoctorController::class, 'getDoctorInfo']);   // يرجع أوقات الدكتور للحجز معاه
    Route::get('/doctor-working-days/{id}', [CommonDoctorController::class, 'getWorkingDays']);  // يرجع أيام الدكتور للحجز معاه


    // Notifications
    Route::get('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications_read');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications_index');

    Route::get('/notifications/render/{id}', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        return view('partials.notifications.item', compact('notification'))->render();
    })->name('notifications.render');



    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat_index');    // قائمة المحادثات
    Route::get('/chat/open/{id}', [ChatController::class, 'open'])->name('chat_open');   // فتح محادثة
    Route::post('/chat/{conversation}/send', [ChatController::class, 'send'])->name('chat_send');  // إرسال رسالة Ajax

    Route::get('/chat/contacts', [ChatController::class, 'contacts'])->name('chat_contacts');

    Route::post('/set-offline', function () {
        if (auth()->check()) {
            auth()->user()->update(['is_online' => false]);
        }
    });

    Route::post('/chat/{conversation}/mark-read', [ChatController::class, 'markRead'])->name('chat_mark_read');



    //Shared
    Route::get('/get-departments-by-clinic/{clinic_id}', [CommonClinicController::class, 'getDepartmentsByClinic']);    // حتى عندما أختار العيادة المحددة يحضر لي فقط أقسامها في فورم إضافة طبيب
    Route::get('/get-clinic-info/{id}', [CommonClinicController::class, 'getClinicInfo']);  // بحضر لي أوقات العيادة في فورم الطبيب عشان أختار أوقات الطبيب بناء ع وقت العيادة
    Route::get('/clinic-working-days/{id}', [CommonClinicController::class, 'getWorkingDays']);    // برجع الأيام المحددة


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
    Route::get('/appointments-trash',[AdminAppointmentController::class, 'trash'])->name('appointments_trash');   // عرض سلة محذوفات المواعيد
    Route::get('/appointments-trash/search', [AdminAppointmentController::class, 'searchAppointmentsTrash'])->name('appointments_trash_search');
    Route::post('/appointments/restore/{id}',[AdminAppointmentController::class, 'restore'])->name('appointment_restore');   // استرجاع موعد من سلة المحذوفات
    Route::delete('/appointments/force-delete/{id}',[AdminAppointmentController::class, 'forceDelete'])->name('appointment_forceDelete');  // حذف نهائي من سلة المحذوفات


    //Medical Records
    Route::get('/view/medical-records' ,[AdminMedicalRecordController::class , 'viewMedicalRecords'])->name('view_medical_records');
    Route::get('/search/medical-records',[AdminMedicalRecordController::class , 'searchMedicalRecords'])->name('search_medical_records');
    Route::get('/details/medical-record/{id}',[AdminMedicalRecordController::class , 'detailsMedicalRecord'])->name('details_medical_record');


    //Invoices
    Route::get('/view/invoices' ,[AdminInvoiceController::class , 'viewInvoices'])->name('view_invoices');
    Route::get('/search/invoices',[AdminInvoiceController::class , 'searchInvoices'])->name('search_invoices');
    Route::get('/details/invoice/{id}',[AdminInvoiceController::class , 'detailsInvoice'])->name('details_invoice');
    Route::get('/details/refund-invoice/{id}',[AdminInvoiceController::class , 'detailsRefundInvoice'])->name('details_refund_invoice');
    Route::get('/edit/invoice/{id}' ,[AdminInvoiceController::class , 'editInvoice'])->name('edit_invoice');
    Route::put('/update/invoice/{id}' ,[AdminInvoiceController::class , 'updateInvoice'])->name('update_invoice');
    Route::delete('/delete/invoice/{id}' ,[AdminInvoiceController::class ,'deleteInvoice'])->name('delete_invoice');


    Route::get('/invoice-pdf/view/{id}', [AdminInvoiceController::class, 'invoicePDF'])->name('invoice_pdf');
    Route::get('/invoice-pdf/raw/{id}', [AdminInvoiceController::class, 'invoicePDFRaw'])->name('invoice_pdf_raw');
    Route::get('/cancelled-invoice-pdf/view/{id}', [AdminInvoiceController::class, 'cancelledinvoicePDF'])->name('cancelled_invoice_pdf');
    Route::get('/cancelled-invoice-pdf/raw/{id}', [AdminInvoiceController::class, 'cancelledinvoicePDFRaw'])->name('cancelled_invoice_pdf_raw');


    //Reports

    //Printable Employee Report
    Route::get('/employees/reports/view', [AdminReportEmployeeController::class, 'employeesReportsView'])->name('employees_reports_view');
    Route::get('/employees/reports/pdf', [AdminReportEmployeeController::class, 'employeesReportsRaw'])->name('employees_reports_raw');

    //Printable Doctor Report
    Route::get('/doctors/reports/view', [AdminReportDoctorController::class, 'doctorsReportsView'])->name('doctors_reports_view');
    Route::get('/doctors/reports/pdf', [AdminReportDoctorController::class, 'doctorsReportsRaw'])->name('doctors_reports_raw');

    //Printable Patient Report
    Route::get('/patients/reports/view', [AdminReportPatientController::class, 'patientsReportsView'])->name('patients_reports_view');
    Route::get('/patients/reports/pdf', [AdminReportPatientController::class, 'patientsReportsRaw'])->name('patients_reports_raw');

    //Printable Appointment Report
    Route::get('/appointments/reports/view', [AdminReportAppointmentController::class, 'appointmentsReportsView'])->name('appointments_reports_view');
    Route::get('/appointments/reports/pdf', [AdminReportAppointmentController::class, 'appointmentsReportsRaw'])->name('appointments_reports_raw');

    //Printable Invoice Report
    Route::get('/invoices/reports/view', [AdminReportInvoiceController::class, 'invoicesReportsView'])->name('invoices_reports_view');
    Route::get('/invoices/reports/pdf', [AdminReportInvoiceController::class, 'invoicesReportsRaw'])->name('invoices_reports_raw');


    //Analytics
    Route::get('/employees/analytics', [AdminAnalyticController::class, 'employeesAnalytics'])->name('employees_analytics');
    Route::get('/doctors/analytics', [AdminAnalyticController::class, 'doctorsAnalytics'])->name('doctors_analytics');
    Route::get('/patients/analytics', [AdminAnalyticController::class, 'patientsAnalytics'])->name('patients_analytics');
    Route::get('/appointments/analytics', [AdminAnalyticController::class, 'appointmentsAnalytics'])->name('appointments_analytics');
    Route::get('/invoices/analytics', [AdminAnalyticController::class, 'invoicesAnalytics'])->name('invoices_analytics');



    //Chart
    Route::get('/chart/employees/monthly', [AdminChartController::class, 'employeesMonthly'])->name('employees_monthly');
    Route::get('/chart/doctors-monthly', [AdminChartController::class, 'doctorsMonthly'])->name('doctors_monthly');
    Route::get('/chart/doctors-by-department', [AdminChartController::class, 'doctorsByDepartment'])->name('doctors_by_department');
    Route::get('/chart/patients-per-clinic', [AdminChartController::class, 'patientsPerClinic'])->name('patients_per_clinic');
    Route::get('/chart/patients-monthly', [AdminChartController::class, 'patientsPerMonth'])->name('patients_monthly');
    Route::get('/chart/appointments-by-clinic', [AdminChartController::class, 'getAppointmentsByClinic'])->name('appointments_by_clinic');
    Route::get('/chart/appointments-monthly', [AdminChartController::class, 'appointmentsMonthly'])->name('appointments_monthly');
    Route::get('/chart/revenue-monthly', [AdminChartController::class, 'monthlyRevenue'])->name('monthly_revenue');
    Route::get('/chart/revenue-per-clinic', [AdminChartController::class, 'revenuePerClinic'])->name('revenue_per_clinic');

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

    Route::get('/view/departments-managers', [ClinicManagerDepartmentController::class, 'viewDepartmentsManagers'])->name('clinic.view_departments_managers');
    Route::get('/search/departments-managers',[ClinicManagerDepartmentController::class , 'searchDepartmentsManagers'])->name('clinic.search_departments_managers');
    Route::get('/profile/department-manager/{id}',[ClinicManagerDepartmentController::class , 'profileDepartmentManager'])->name('clinic.profile_department_manager');
    Route::get('/edit/department-manager/{id}' ,[ClinicManagerDepartmentController::class , 'editDepartmentManager'])->name('clinic.edit_department_manager');
    Route::put('/update/department-manager/{id}' ,[ClinicManagerDepartmentController::class , 'updateDepartmentManager'])->name('clinic.update_department_manager');
    Route::delete('/delete/department-manager/{id}' ,[ClinicManagerDepartmentController::class , 'deleteDepartmentManager'])->name('clinic.delete_department_manager');


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
    Route::get('/add/patient' ,[ClinicManagerPatientController::class , 'addPatient'])->name('clinic.add_patient');
    Route::post('/store/patient',[ClinicManagerPatientController::class , 'storePatient'])->name('clinic.store_patient');
    Route::get('/view/patients' ,[ClinicManagerPatientController::class , 'viewPatients'])->name('clinic.view_patients');
    Route::get('/search/patients' ,[ClinicManagerPatientController::class , 'searchPatients'])->name('clinic.search_patients');
    Route::get('/profile/patient/{id}',[ClinicManagerPatientController::class , 'profilePatient'])->name('clinic.profile_patient');
    Route::get('/edit/patient/{id}' ,[ClinicManagerPatientController::class , 'editPatient'])->name('clinic.edit_patient');
    Route::put('/update/patient/{id}' ,[ClinicManagerPatientController::class , 'updatePatient'])->name('clinic.update_patient');
    Route::delete('/delete/patient/{id}' ,[ClinicManagerPatientController::class , 'deletePatient'])->name('clinic.delete_patient');


    //Appointment
    Route::get('/view/appointments' ,[ClinicManagerAppointmentController::class , 'viewAppointments'])->name('clinic.view_appointments');
    Route::get('/search/appointments',[ClinicManagerAppointmentController::class , 'searchAppointments'])->name('clinic.search_appointments');
    Route::get('/details/appointment/{id}',[ClinicManagerAppointmentController::class , 'detailsAppointment'])->name('clinic.details_appointment');

    Route::delete('/delete/appointment/{id}' ,[ClinicManagerAppointmentController::class ,'deleteAppointment'])->name('clinic.delete_appointment');
    Route::get('/appointments-trash',[ClinicManagerAppointmentController::class, 'trash'])->name('clinic.appointments_trash');   // عرض سلة محذوفات المواعيد
    Route::get('/appointments-trash/search', [ClinicManagerAppointmentController::class, 'searchAppointmentsTrash'])->name('clinic.appointments_trash_search');
    Route::post('/appointments/restore/{id}',[ClinicManagerAppointmentController::class, 'restore'])->name('clinic.appointment_restore');   // استرجاع موعد من سلة المحذوفات
    Route::delete('/appointments/force-delete/{id}',[ClinicManagerAppointmentController::class, 'forceDelete'])->name('clinic.appointment_forceDelete');  // حذف نهائي من سلة المحذوفات


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
    Route::get('/details/refund-invoice/{id}',[ClinicManagerInvoiceController::class , 'detailsRefundInvoice'])->name('clinic.details_refund_invoice');

    Route::get('/invoice-pdf/view/{id}', [ClinicManagerInvoiceController::class, 'invoicePDF'])->name('clinic.invoice_pdf');
    Route::get('/invoice-pdf/raw/{id}', [ClinicManagerInvoiceController::class, 'invoicePDFRaw'])->name('clinic.invoice_pdf_raw');
    Route::get('/cancelled-invoice-pdf/view/{id}', [ClinicManagerInvoiceController::class, 'cancelledinvoicePDF'])->name('clinic.cancelled_invoice_pdf');
    Route::get('/cancelled-invoice-pdf/raw/{id}', [ClinicManagerInvoiceController::class, 'cancelledinvoicePDFRaw'])->name('clinic.cancelled_invoice_pdf_raw');



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
    Route::get('/profile' , [DoctorProfileController::class , 'profile'])->name('doctor_profile');
    Route::get('/profile/edit', [DoctorProfileController::class, 'edit'])->name('doctor.profile.edit');
    Route::put('/profile/update', [DoctorProfileController::class, 'update'])->name('doctor_update_profile');
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
    Route::get('vital-signs/show/{vitalSigns}', [DoctorAppointmentController::class, 'vitalSignsShow'])->name('doctor.vital_signs_show');


    Route::get('/doctor/assign-task/{appointment}/{nurse}', [DoctorNurseTaskController::class, 'assignTask'])->name('doctor.assign_task');
    Route::post('/doctor/assign-task/store', [DoctorNurseTaskController::class, 'assignTaskStore'])->name('doctor.assign_task.store');
    Route::get('/doctor/nurse-task/{id}', [DoctorNurseTaskController::class, 'detailsTask'])->name('doctor.nurse_task_details');

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


    //Clinic
    Route::get('/clinic-profile', [NurseClinicController::class, 'clinicProfile'])->name('nurse.clinic_profile');


    //Department
    Route::get('/depratment-profile', [NurseDepartmentController::class, 'depratmentProfile'])->name('nurse.depratment_profile');


    //Doctors
    Route::get('/view/doctors' ,[NurseDoctorController::class , 'viewDoctors'])->name('nurse.view_doctors');
    Route::get('/search/doctors',[NurseDoctorController::class , 'searchDoctors'])->name('nurse.search_doctors');
    Route::get('/profile/doctor/{id}',[NurseDoctorController::class , 'profileDoctor'])->name('nurse.profile_doctor');

    Route::get('/search/schedules',[NurseDoctorController::class ,  'searchSchedules'])->name('nurse.search_schedules');
    Route::post('/search/doctor/schedule',[NurseDoctorController::class , 'searchDoctchedule'])->name('nurse.search_doctor_schedule');


    //Patient
    Route::get('/view/patients' ,[NursePatientController::class , 'viewPatients'])->name('nurse.view_patients');
    Route::get('/search/patients' ,[NursePatientController::class , 'searchPatients'])->name('nurse.search_patients');
    Route::get('/profile/patient/{id}',[NursePatientController::class , 'profilePatient'])->name('nurse.profile_patient');


    //Appointment
    Route::get('/view/appointments' ,[NurseAppointmentController::class , 'viewAppointments'])->name('nurse.view_appointments');
    Route::get('/search/appointments',[NurseAppointmentController::class , 'searchAppointments'])->name('nurse.search_appointments');


    //Vital Signs
    Route::get('/add/vital-signs/{appointment_id}' ,[NurseVitalSignsController::class , 'addVitalSigns'])->name('nurse.add_vital_signs');
    Route::post('/store/vital-signs' ,[NurseVitalSignsController::class , 'storeVitalSigns'])->name('nurse.store_vital_signs');
    Route::get('/view/vital-signs/{appointment_id}' ,[NurseVitalSignsController::class , 'viewVitalSigns'])->name('nurse.view_vital_signs');
    Route::get('/search/vital-signs',[NurseVitalSignsController::class , 'searchVitalSigns'])->name('nurse.search_vital_signs');
    Route::get('/edit/vital-signs/{id}' ,[NurseVitalSignsController::class , 'editVitalSigns'])->name('nurse.edit_vital_signs');
    Route::put('/update/vital-signs/{id}' ,[NurseVitalSignsController::class , 'updateVitalSigns'])->name('nurse.update_vital_signs');


    //Medical Record
    Route::get('/view/medical-records' ,[NurseMedicalRecordController::class , 'viewMedicalRecords'])->name('nurse.view_medical_records');
    Route::get('/search/medical-records',[NurseMedicalRecordController::class , 'searchMedicalRecords'])->name('nurse.search_medical_records');
    Route::get('/details/medical-record/{id}' ,[NurseMedicalRecordController::class , 'detailsMedicalRecord'])->name('nurse.details_medical_record');


    //Nurse Tasks
    Route::get('/view/nurse-tasks' ,[NurseTaskController::class , 'viewNurseTasks'])->name('nurse.view_nurse_tasks');
    Route::get('/search/nurse-tasks',[NurseTaskController::class , 'searchNurseTasks'])->name('nurse.search_nurse_tasks');
    Route::get('/details/nurse-task/{id}' ,[NurseTaskController::class , 'detailsNurseTask'])->name('nurse.details_nurse_task');
    Route::post('/completed/nurse-task/{id}' ,[NurseTaskController::class , 'completedNurseTask'])->name('nurse.completed_nurse_task');

});





/** Receptionists **/
Route::prefix('employee/receptionist')->middleware(['auth', 'verified', 'role:employee'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [ReceptionistDashboardController::class, 'receptionistDashboard'])->name('receptionist_dashboard');
    Route::get('/profile' , [ReceptionistDashboardController::class , 'receptionistProfile'])->name('receptionist_profile');
    Route::get('/edit/profile' , [ReceptionistDashboardController::class , 'receptionistEditProfile'])->name('receptionist_edit_profile');
    Route::put('/update/profile' , [ReceptionistDashboardController::class , 'receptionistUpdateProfile'])->name('receptionist_update_profile');


    //Clinic
    Route::get('/clinic-profile', [ReceptionistClinicController::class, 'clinicProfile'])->name('receptionist.clinic_profile');


    //Department
    Route::get('/depratment-profile', [ReceptionistDepartmentController::class, 'depratmentProfile'])->name('receptionist.depratment_profile');


    //Doctors
    Route::get('/view/doctors' ,[ReceptionistDoctorController::class , 'viewDoctors'])->name('receptionist.view_doctors');
    Route::get('/search/doctors',[ReceptionistDoctorController::class , 'searchDoctors'])->name('receptionist.search_doctors');
    Route::get('/profile/doctor/{id}',[ReceptionistDoctorController::class , 'profileDoctor'])->name('receptionist.profile_doctor');

    Route::get('/search/schedules',[ReceptionistDoctorController::class ,  'searchSchedules'])->name('receptionist.search_schedules');
    Route::post('/search/doctor/schedule',[ReceptionistDoctorController::class , 'searchDoctchedule'])->name('receptionist.search_doctor_schedule');


    //Patient
    Route::get('/add/patient' ,[ReceptionistPatientController::class , 'addPatient'])->name('receptionist.add_patient');
    Route::post('/store/patient' ,[ReceptionistPatientController::class , 'storePatient'])->name('receptionist.store_patient');
    Route::get('/view/patients' ,[ReceptionistPatientController::class , 'viewPatients'])->name('receptionist.view_patients');
    Route::get('/search/patients' ,[ReceptionistPatientController::class , 'searchPatients'])->name('receptionist.search_patients');
    Route::get('/profile/patient/{id}',[ReceptionistPatientController::class , 'profilePatient'])->name('receptionist.profile_patient');
    Route::get('/edit/patient/{id}' ,[ReceptionistPatientController::class , 'editPatient'])->name('receptionist.edit_patient');
    Route::put('/update/patient/{id}' ,[ReceptionistPatientController::class , 'updatePatient'])->name('receptionist.update_patient');
    Route::delete('/delete/patient/{id}' ,[ReceptionistPatientController::class , 'deletePatient'])->name('receptionist.delete_patient');


    //Appointment
    Route::get('/add/appointment' ,[ReceptionistAppointmentController::class , 'addAppointment'])->name('receptionist.add_appointment');
    Route::post('/store/appointment',[ReceptionistAppointmentController::class , 'storeAppointment'])->name('receptionist.store_appointment');
    Route::get('/view/appointments' ,[ReceptionistAppointmentController::class , 'viewAppointments'])->name('receptionist.view_appointments');
    Route::get('/search/appointments',[ReceptionistAppointmentController::class , 'searchAppointments'])->name('receptionist.search_appointments');
    Route::get('/details/appointment/{id}',[ReceptionistAppointmentController::class , 'detailsAppointment'])->name('receptionist.details_appointment');
    Route::get('/edit/appointment/{id}' ,[ReceptionistAppointmentController::class , 'editAppointment'])->name('receptionist.edit_appointment');
    Route::put('/update/appointment/{id}' ,[ReceptionistAppointmentController::class , 'updateAppointment'])->name('receptionist.update_appointment');

    Route::post('/appointments/update-status/{id}', [ReceptionistAppointmentController::class, 'updateStatus']);
    Route::post('/check-appointment', [ReceptionistAppointmentController::class, 'checkAppointment'])->name('receptionist.check_appointment');


    //Invoices
    Route::get('/view/invoices' ,[ReceptionistInvoiceController::class , 'viewInvoices'])->name('receptionist.view_invoices');
    Route::get('/search/invoices',[ReceptionistInvoiceController::class , 'searchInvoices'])->name('receptionist.search_invoices');
    Route::get('/details/invoice/{id}',[ReceptionistInvoiceController::class , 'detailsInvoice'])->name('receptionist.details_invoice');

    Route::get('/invoice-pdf/view/{id}', [ReceptionistInvoiceController::class, 'invoicePDF'])->name('receptionist.invoice_pdf');
    Route::get('/invoice-pdf/raw/{id}', [ReceptionistInvoiceController::class, 'invoicePDFRaw'])->name('receptionist.invoice_pdf_raw');

});





/**  Accountants **/
Route::prefix('employee/accountant')->middleware(['auth', 'verified', 'role:employee'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [AccountantDashboardController::class, 'accountantDashboard'])->name('accountant_dashboard');
    Route::get('/profile' , [AccountantDashboardController::class , 'accountantProfile'])->name('accountant_profile');
    Route::get('/edit/profile' , [AccountantDashboardController::class , 'accountantEditProfile'])->name('accountant_edit_profile');
    Route::put('/update/profile' , [AccountantDashboardController::class , 'accountantUpdateProfile'])->name('accountant_update_profile');


    //Clinic
    Route::get('/clinic-profile', [AccountantClinicController::class, 'clinicProfile'])->name('accountant.clinic_profile');


    //Departments
    Route::get('/view/depratments', [AccountantDepartmentController::class, 'viewDepratments'])->name('accountant.view_depratments');


    //Doctors
    Route::get('/view/doctors' ,[AccountantDoctorController::class , 'viewDoctors'])->name('accountant.view_doctors');
    Route::get('/search/doctors',[AccountantDoctorController::class , 'searchDoctors'])->name('accountant.search_doctors');
    Route::get('/profile/doctor/{id}',[AccountantDoctorController::class , 'profileDoctor'])->name('accountant.profile_doctor');



    //Patient
    Route::get('/view/patients' ,[AccountantPatientController::class , 'viewPatients'])->name('accountant.view_patients');
    Route::get('/search/patients' ,[AccountantPatientController::class , 'searchPatients'])->name('accountant.search_patients');
    Route::get('/profile/patient/{id}',[AccountantPatientController::class , 'profilePatient'])->name('accountant.profile_patient');
    Route::get('/view/invoices-patients/{id}' ,[AccountantPatientController::class , 'viewInvoicesPatients'])->name('accountant.view_invoices_patients');
    Route::get('/search/invoices-patients/{id}' ,[AccountantPatientController::class , 'searchInvoicesPatients'])->name('accountant.search_invoices_patients');



    //Appointment
    Route::get('/view/appointments' ,[AccountantAppointmentController::class , 'viewAppointments'])->name('accountant.view_appointments');
    Route::get('/search/appointments',[AccountantAppointmentController::class , 'searchAppointments'])->name('accountant.search_appointments');
    Route::get('/details/appointment/{id}',[AccountantAppointmentController::class , 'detailsAppointment'])->name('accountant.details_appointment');



    //Invoices
    Route::get('/view/invoices' ,[AccountantInvoiceController::class , 'viewInvoices'])->name('accountant.view_invoices');
    Route::get('/search/invoices',[AccountantInvoiceController::class , 'searchInvoices'])->name('accountant.search_invoices');
    Route::get('/details/invoice/{id}',[AccountantInvoiceController::class , 'detailsInvoice'])->name('accountant.details_invoice');
    Route::get('/edit/invoice/{id}' ,[AccountantInvoiceController::class , 'editInvoice'])->name('accountant.edit_invoice');
    Route::put('/update/invoice/{id}' ,[AccountantInvoiceController::class , 'updateInvoice'])->name('accountant.update_invoice');

    Route::get('/details/refund-invoice/{id}',[AccountantInvoiceController::class , 'detailsRefundInvoice'])->name('accountant.details_refund_invoice');
    Route::get('/refund-confirm/{id}' ,[AccountantInvoiceController::class , 'refundConfirmation'])->name('accountant.refund_confirm');
    Route::put('/update/refund-confirm/{id}' ,[AccountantInvoiceController::class , 'updateRefundConfirmation'])->name('accountant.update_refund_confirm');


    Route::get('/invoice-pdf/view/{id}', [AccountantInvoiceController::class, 'invoicePDF'])->name('accountant.invoice_pdf');
    Route::get('/invoice-pdf/raw/{id}', [AccountantInvoiceController::class, 'invoicePDFRaw'])->name('accountant.invoice_pdf_raw');
    Route::get('/cancelled-invoice-pdf/view/{id}', [AccountantInvoiceController::class, 'cancelledinvoicePDF'])->name('accountant.cancelled_invoice_pdf');
    Route::get('/cancelled-invoice-pdf/raw/{id}', [AccountantInvoiceController::class, 'cancelledinvoicePDFRaw'])->name('accountant.cancelled_invoice_pdf_raw');

});







//Patient
Route::prefix('patient')->middleware(['auth', 'verified', 'role:patient'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PatientDashboardController::class, 'patientDashboard'])->name('patient_dashboard');
    Route::get('/my_profile' , [PatientDashboardController::class , 'patientProfile'])->name('patient_profile');
    Route::get('/edit/profile' , [PatientDashboardController::class , 'patientEditProfile'])->name('patient_edit_profile');
    Route::put('/update/profile' , [PatientDashboardController::class , 'patientUpdateProfile'])->name('patient_update_profile');

});








