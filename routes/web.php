<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClinicController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Finance\ExpenseController;
use App\Http\Controllers\Admin\Finance\PaymentController;
use App\Http\Controllers\Admin\MedicationStockController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Finance\VendorInvoiceController;
use App\Http\Controllers\Admin\Finance\PatientInvoiceController;

//Auth
Route::get('/login', [AuthenticatedSessionController::class, 'login'])->name('login')->middleware('guest');
Route::post('/user/login', [AuthenticatedSessionController::class, 'userLogin'])->name('user_login')->middleware('guest');
Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register')->middleware('guest');


//Admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/my_profile' , [DashboardController::class , 'myProfile'])->name('my_profile');
    Route::get('/edit/profile' , [DashboardController::class , 'editProfile'])->name('edit_profile');
    Route::put('/update/profile' , [DashboardController::class , 'updateProfile'])->name('update_profile');


    //Clinics
    Route::get('/add/clinic' ,[ClinicController::class , 'addClinic'])->name('add_clinic');
    Route::post('/store/clinic' ,[ClinicController::class , 'storeClinic'])->name('store_clinic');
    Route::get('/view/clinics' ,[ClinicController::class , 'viewClinics'])->name('view_clinics');
    Route::get('/description/clinic/{id}' ,[ClinicController::class , 'descriptionClinic'])->name('description_clinic');
    Route::get('/edit/clinic/{id}' ,[ClinicController::class , 'editClinic'])->name('edit_clinic');
    Route::put('/update/clinic/{id}' ,[ClinicController::class , 'updateClinic'])->name('update_clinic');
    Route::delete('/delete/clinic/{id}' ,[ClinicController::class , 'deleteClinic'])->name('delete_clinic');


    //Specialty
    Route::get('/add/specialty' ,[SpecialtyController::class , 'addSpecialty'])->name('add_specialty');
    Route::post('/store/specialty' ,[SpecialtyController::class , 'storeSpecialty'])->name('store_specialty');
    Route::get('/view/specialties' ,[SpecialtyController::class , 'viewSpecialties'])->name('view_specialties');
    Route::get('/description/specialty/{id}' ,[SpecialtyController::class , 'descriptionSpecialty'])->name('description_specialty');
    Route::get('/edit/specialty/{id}' ,[SpecialtyController::class , 'editSpecialty'])->name('edit_specialty');
    Route::put('/update/specialty/{id}' ,[SpecialtyController::class , 'updateSpecialty'])->name('update_specialty');
    Route::delete('/delete/specialty/{id}' ,[SpecialtyController::class , 'deleteSpecialty'])->name('delete_specialty');


    //Doctor
    Route::get('/add/doctor' ,[DoctorController::class , 'addDoctor'])->name('add_doctor');
    Route::post('/store/doctor',[DoctorController::class , 'storeDoctor'])->name('store_doctor');
    Route::get('/view/doctors' ,[DoctorController::class , 'viewDoctors'])->name('view_doctors');
    Route::get('/view/clinic/managers' ,[DoctorController::class , 'viewClinicManagers'])->name('view_clinic_managers');
    Route::get('/profile/doctor/{id}',[DoctorController::class , 'profileDoctor'])->name('profile_doctor');
    Route::get('/edit/doctor/{id}' ,[DoctorController::class , 'editDoctor'])->name('edit_doctor');
    Route::put('/update/doctor/{id}' ,[DoctorController::class , 'updateDoctor'])->name('update_doctor');
    Route::delete('/delete/doctor/{id}' ,[DoctorController::class , 'deleteDoctor'])->name('delete_doctor');

    Route::get('/search/doctor/schedules',[DoctorController::class ,  'searchDoctorSchedules']);
    Route::post('/search/doctor/schedules',[DoctorController::class , 'searchDoctchedules'])->name('search_doctor_schedules');

    Route::get('/get-specialties-by-clinic/{clinic_id}', [DoctorController::class, 'getSpecialtiesByClinic']);    // حتى عندما أختار العيادة المحددة يحضر لي فقط تخصصاتها في فورم إضافة طبيب
    Route::get('/get-clinic-info/{id}', [DoctorController::class, 'getClinicInfo']);  // بحضر لي أوقات العيادة في فورم الطبيب عشان أختار أوقات الطبيب بناء ع وقت العيادة
    Route::get('/clinic-working-days/{id}', [DoctorController::class, 'getWorkingDays']);    // برجع الأيام المحددة



    //Patient
    Route::get('/add/patient' ,[PatientController::class , 'addPatient'])->name('add_patient');
    Route::post('/store/patient',[PatientController::class , 'storePatient'])->name('store_patient');
    Route::get('/view/patients' ,[PatientController::class , 'viewPatients'])->name('view_patients');
    Route::get('/profile/patient/{id}',[PatientController::class , 'profilePatient'])->name('profile_patient');
    Route::get('/edit/patient/{id}' ,[PatientController::class , 'editPatient'])->name('edit_patient');
    Route::put('/update/patient/{id}' ,[PatientController::class , 'updatePatient'])->name('update_patient');
    Route::delete('/delete/patient/{id}' ,[PatientController::class , 'deletePatient'])->name('delete_patient');

    Route::get('/get-specialties-by-clinic/{clinic_id}', [PatientController::class, 'getSpecialtiesByClinic']);    // عند اختيار العيادة – جلب التخصصات المرتبطة بها فقط
    Route::get('/get-doctors-by-clinic-and-specialty', [PatientController::class, 'getDoctorsByClinicAndSpecialty']);   //  عند اختيار التخصص – جلب الأطباء الذين ينتمون لهذا التخصص فقط ومن نفس العيادة فقط
    Route::get('/get-doctor-info/{id}', [PatientController::class, 'getDoctorInfo']);   // يرجع أوقات الدكتور للحجز معاه
    Route::get('/doctor-working-days/{id}', [PatientController::class, 'getWorkingDays']);  // يرجع أيام الدكتور للحجز معاه


    //Appointment
    Route::get('/add/appointment' ,[AppointmentController::class , 'addAppointment'])->name('add_appointment');
    Route::post('/store/appointment',[AppointmentController::class , 'storeAppointment'])->name('store_appointment');
    Route::get('/view/appointments' ,[AppointmentController::class , 'viewAppointments'])->name('view_appointments');
    Route::get('/search/appointments',[AppointmentController::class , 'searchAppointments'])->name('search_appointments');
    Route::get('/description/appointment/{id}',[AppointmentController::class , 'descriptionAppointment'])->name('description_appointment');
    Route::get('/edit/appointment/{id}' ,[AppointmentController::class , 'editAppointment'])->name('edit_appointment');
    Route::put('/update/appointment/{id}' ,[AppointmentController::class , 'updateAppointment'])->name('update_appointment');
    Route::delete('/delete/appointment/{id}' ,[AppointmentController::class ,'deleteAppointment'])->name('delete_appointment');


    //Medication
    Route::get('/add/medication' ,[MedicationController::class , 'addMedication'])->name('add_medication');
    Route::post('/store/medication',[MedicationController::class , 'storeMedication'])->name('store_medication');
    Route::get('/view/medications' ,[MedicationController::class , 'viewMedications'])->name('view_medications');
    Route::get('/description/medication/{id}',[MedicationController::class , 'descriptionMedication'])->name('description_medication');
    Route::get('/edit/medication/{id}' ,[MedicationController::class , 'editMedication'])->name('edit_medication');
    Route::put('/update/medication/{id}' ,[MedicationController::class , 'updateMedication'])->name('update_medication');
    Route::delete('/delete/medication/{id}' ,[MedicationController::class , 'deleteMedication'])->name('delete_medication');


    //Prescription
    Route::get('/view/prescriptions' ,[PrescriptionController::class , 'viewPrescriptions'])->name('view_prescriptions');
    Route::get('/description/prescription/{id}',[PrescriptionController::class , 'descriptionPrescription'])->name('description_prescription');


    //Medication Stock
    Route::get('/add/toStock' ,[MedicationStockController::class , 'addToStock'])->name('add_to_stock');
    Route::post('/store/toStock',[MedicationStockController::class , 'storeToStock'])->name('store_to_stock');
    Route::get('/generate-batch-number',[MedicationStockController::class , 'generateBatchNumber'])->name('generate_batch_number');
    Route::get('/view/stocks' ,[MedicationStockController::class , 'viewStocks'])->name('view_stocks');
    Route::get('/description/stock/{id}',[MedicationStockController::class , 'descriptionStock'])->name('description_stock');
    Route::get('/edit/stock/{id}' ,[MedicationStockController::class , 'editStock'])->name('edit_stock');
    Route::put('/update/stock/{id}' ,[MedicationStockController::class , 'updateStock'])->name('update_stock');
    Route::delete('/delete/stock/{id}' ,[MedicationStockController::class , 'deleteStock'])->name('delete_stock');


    //Employee
    Route::get('/add/employee' ,[EmployeeController::class , 'addEmployee'])->name('add_employee');
    Route::post('/store/employee',[EmployeeController::class , 'storeEmployee'])->name('store_employee');
    Route::get('/view/employees' ,[EmployeeController::class , 'viewEmployees'])->name('view_employees');
    Route::get('/profile/employee/{id}',[EmployeeController::class , 'profileEmployee'])->name('profile_employee');
    Route::get('/edit/employee/{id}' ,[EmployeeController::class , 'editEmployee'])->name('edit_employee');
    Route::put('/update/employee/{id}' ,[EmployeeController::class , 'updateEmployee'])->name('update_employee');
    Route::delete('/delete/employee/{id}' ,[EmployeeController::class , 'deleteEmployee'])->name('delete_employee');


    //***Finance***//

    //patient invoice
    Route::get('/view/invoices' ,[PatientInvoiceController::class , 'viewInvoices'])->name('view_invoices');
    Route::get('/details/invoice/{id}' ,[PatientInvoiceController::class , 'detailsInvoice'])->name('details_invoice');
    Route::get('/edit/invoice/{id}' ,[PatientInvoiceController::class , 'editInvoice'])->name('edit_invoice');
    Route::put('/update/invoice/{id}' ,[PatientInvoiceController::class , 'updateInvoice'])->name('update_invoice');
    Route::delete('/delete/invoice/{id}' ,[PatientInvoiceController::class , 'deleteInvoice'])->name('delete_invoice');


    //patient payment
    Route::get('/view/payments' ,[PaymentController::class , 'viewPayments'])->name('view_payments');
    Route::get('/details/payment/{id}' ,[PaymentController::class , 'detailsPayment'])->name('details_payment');
    Route::get('/edit/payment/{id}' ,[PaymentController::class , 'editPayment'])->name('edit_payment');
    Route::put('/update/payment/{id}' ,[PaymentController::class , 'updatePayment'])->name('update_payment');
    Route::delete('/delete/payment/{id}' ,[PaymentController::class , 'deletePayment'])->name('delete_payment');

    Route::get('/edit/payment/Details/{id}' ,[PaymentController::class , 'editPaymentDetails'])->name('edit_payment_Details');
    Route::put('/update/payment/Details/{id}' ,[PaymentController::class , 'updatePaymentDetails'])->name('update_payment_Details');
    Route::delete('/delete/payment/Details/{id}' ,[PaymentController::class , 'deletePaymentDetails'])->name('delete_payment_Details');


    //vendor invoice
    Route::get('/view/vendors/invoices' ,[VendorInvoiceController::class , 'viewVendorInvoices'])->name('view_vendors_invoices');
    Route::get('/details/vendor/invoice/{id}' ,[VendorInvoiceController::class , 'detailsVendorInvoice'])->name('details_vendor_invoice');
    Route::get('/edit/vendor/invoice/{id}' ,[VendorInvoiceController::class , 'editVendorInvoice'])->name('edit_vendor_invoice');
    Route::put('/update/vendor/invoice/{id}' ,[VendorInvoiceController::class , 'updateVendorInvoice'])->name('update_vendor_invoice');
    Route::delete('/delete/vendor/invoice/{id}' ,[VendorInvoiceController::class , 'deleteVendorInvoice'])->name('delete_vendor_invoice');


    //expense
    Route::get('/view/expenses' ,[ExpenseController::class , 'viewExpenses'])->name('view_expenses');
    Route::get('/details/expense/{id}' ,[ExpenseController::class , 'detailsExpense'])->name('details_expense');
    Route::get('/edit/expense/{id}' ,[ExpenseController::class , 'editExpense'])->name('edit_expense');
    Route::put('/update/expense/{id}' ,[ExpenseController::class , 'updateExpense'])->name('update_expense');
    Route::delete('/delete/expense/{id}' ,[ExpenseController::class , 'deleteExpense'])->name('delete_expense');

    Route::get('/edit/expense/Details/{id}' ,[ExpenseController::class , 'editExpenseDetails'])->name('edit_expense_Details');
    Route::put('/update/expense/Details/{id}' ,[ExpenseController::class , 'updateExpenseDetails'])->name('update_expense_Details');
    Route::delete('/delete/expense/Details/{id}' ,[ExpenseController::class , 'deleteExpenseDetails'])->name('delete_expense_Details');


    //Reports
    Route::get('/view/reports' ,[ReportController::class , 'viewReports'])->name('view_reports');

});





//Clinic_Manager
Route::prefix('clinic-manager')->middleware(['auth', 'verified', 'role:clinic_manager'])->group(function () {

});





//Doctor
Route::prefix('doctor')->middleware(['auth', 'verified', 'role:doctor'])->group(function () {

});





//Employee
Route::prefix('employee')->middleware(['auth', 'verified', 'role:employee'])->group(function () {

});





//Patient
Route::prefix('patient')->middleware(['auth', 'verified', 'role:patient'])->group(function () {

});








