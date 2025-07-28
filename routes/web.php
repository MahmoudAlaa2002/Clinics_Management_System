<?php

use App\Models\Doctor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ClinicManagerController;

Route::controller(FrontendController::class)->group(function () {
    Route::get('/login' , 'login')->name('login');
    Route::post('/user/login' , 'userLogin')->name('user_login');

    Route::get('/register' , 'register')->middleware('guest')->name('register');
    Route::post('/new_account' , 'newAccount');


    Route::get('/patient/dashboard/{id}','patientDashboard')->name('patient.dashboard');

    // Route::get('/user/forgot_password' , 'user_forgot_password')->name('user_forgot_password');
    // Route::post('/user/reset_password' , 'user_reset_password');
    // Route::get('/user/update_password/{id}' , 'user_update_password')->name('user_update_password');
    // Route::post('/user/update_password' , 'update_password');

    Route::middleware(['auth' , 'verified'])->group(function () {
        Route::get('/logout' , 'logout')->name('logout');
    });

});




Route::controller(AdminController::class)->group(function () {
    Route::middleware(['auth' , 'verified' ,'role:admin'])->group(function () {
        Route::get('/admin/dashboard' , 'adminDashboard')->name('admin_dashboard');

        //Clinics
        Route::get('/add/clinic' , 'addClinic')->name('add_clinic');
        Route::post('/store/clinic' , 'storeClinic')->name('store_clinic');

        Route::get('/view/clinics' , 'viewClinics')->name('view_clinics');

        Route::get('/description/clinic/{id}' , 'descriptionClinic')->name('description_clinic');

        Route::get('/edit/clinic/{id}' , 'editClinic')->name('edit_clinic');
        Route::put('/update/clinic/{id}' , 'updateClinic')->name('update_clinic');

        Route::delete('/delete/clinic/{id}' , 'deleteClinic')->name('delete_clinic');



        //Specialty
        Route::get('/add/specialty' , 'addSpecialty')->name('add_specialty');
        Route::post('/store/specialty' , 'storeSpecialty')->name('store_specialty');

        Route::get('/view/specialties' , 'viewSpecialties')->name('view_specialties');

        Route::get('/description/specialty/{id}' , 'descriptionSpecialty')->name('description_specialty');

        Route::get('/edit/specialty/{id}' , 'editSpecialty')->name('edit_specialty');
        Route::put('/update/specialty/{id}' , 'updateSpecialty')->name('update_specialty');

        Route::delete('/delete/specialty/{id}' , 'deleteSpecialty')->name('delete_specialty');


        //Doctor
        Route::get('/add/doctor' , 'addDoctor')->name('add_doctor');
        Route::post('/store/doctor', 'storeDoctor')->name('store_doctor');

        Route::get('/view/doctors' , 'viewDoctors')->name('view_doctors');
        Route::get('/view/clinic/managers' , 'viewClinicManagers')->name('view_clinic_managers');

        Route::get('/profile/doctor/{id}', 'profileDoctor')->name('profile_doctor');

        Route::get('/edit/doctor/{id}' , 'editDoctor')->name('edit_doctor');
        Route::put('/update/doctor/{id}' , 'updateDoctor')->name('update_doctor');

        Route::delete('/delete/doctor/{id}' , 'deleteDoctor')->name('delete_doctor');

        Route::get('/search/doctor/schedules',  'searchDoctorSchedules');
        Route::post('/search/doctor/schedules', 'searchDoctchedules')->name('search_doctor_schedules');


        //Patients
        Route::get('/add/patient' , 'addPatient')->name('add_patient');
        Route::post('/store/patient', 'storePatient')->name('store_patient');

        Route::get('/view/patients' , 'viewPatients')->name('view_patients');

        Route::get('/profile/patient/{id}', 'profilePatient')->name('profile_patient');

        Route::get('/edit/patient/{id}' , 'editPatient')->name('edit_patient');
        Route::put('/update/patient/{id}' , 'updatePatient')->name('update_patient');

        Route::delete('/delete/patient/{id}' , 'deletePatient')->name('delete_patient');


        //Appointment
        Route::get('/add/appointment' , 'addAppointment')->name('add_appointment');
        Route::post('/store/appointment', 'storeAppointment')->name('store_appointment');

        Route::get('/view/appointments' , 'viewAppointments')->name('view_appointments');
        Route::get('/search/appointments', 'searchAppointments')->name('search_appointments');

        Route::get('/description/appointment/{id}', 'descriptionAppointment')->name('description_appointment');

        Route::get('/edit/appointment/{id}' , 'editAppointment')->name('edit_appointment');
        Route::put('/update/appointment/{id}' , 'updateAppointment')->name('update_appointment');

        Route::delete('/delete/appointment/{id}' , 'deleteAppointment')->name('delete_appointment');

        //Medication
        Route::get('/add/medication' , 'addMedication')->name('add_medication');
        Route::post('/store/medication', 'storeMedication')->name('store_medication');

        Route::get('/view/medications' , 'viewMedications')->name('view_medications');

        Route::get('/description/medication/{id}', 'descriptionMedication')->name('description_medication');

        Route::get('/edit/medication/{id}' , 'editMedication')->name('edit_medication');
        Route::put('/update/medication/{id}' , 'updateMedication')->name('update_medication');

        Route::delete('/delete/medication/{id}' , 'deleteMedication')->name('delete_medication');



        //Prescriptions
        Route::get('/view/prescriptions' , 'viewPrescriptions')->name('view_prescriptions');
        Route::get('/description/prescription/{id}', 'descriptionPrescription')->name('description_prescription');


        //Medication Stock
        Route::get('/add/toStock' , 'addToStock')->name('add_to_stock');
        Route::post('/store/toStock', 'storeToStock')->name('store_to_stock');
        Route::get('/generate-batch-number', 'generateBatchNumber')->name('generate_batch_number');

        Route::get('/view/stocks' , 'viewStocks')->name('view_stocks');

        Route::get('/description/stock/{id}', 'descriptionStock')->name('description_stock');

        Route::get('/edit/stock/{id}' , 'editStock')->name('edit_stock');
        Route::put('/update/stock/{id}' , 'updateStock')->name('update_stock');

        Route::delete('/delete/stock/{id}' , 'deleteStock')->name('delete_stock');



        //Employee
        Route::get('/add/employee' , 'addEmployee')->name('add_employee');
        Route::post('/store/employee', 'storeEmployee')->name('store_employee');

        Route::get('/view/employees' , 'viewEmployees')->name('view_employees');

        Route::get('/profile/employee/{id}', 'profileEmployee')->name('profile_employee');

        Route::get('/edit/employee/{id}' , 'editEmployee')->name('edit_employee');
        Route::put('/update/employee/{id}' , 'updateEmployee')->name('update_employee');

        Route::delete('/delete/employee/{id}' , 'deleteEmployee')->name('delete_employee');


        //***Finance***//

        //patients invoices
        Route::get('/view/invoices' , 'viewInvoices')->name('view_invoices');
        Route::get('/details/invoice/{id}' , 'detailsInvoice')->name('details_invoice');
        Route::get('/edit/invoice/{id}' , 'editInvoice')->name('edit_invoice');
        Route::put('/update/invoice/{id}' , 'updateInvoice')->name('update_invoice');
        Route::delete('/delete/invoice/{id}' , 'deleteInvoice')->name('delete_invoice');



        //patients payments
        Route::get('/view/payments' , 'viewPayments')->name('view_payments');
        Route::get('/details/payment/{id}' , 'detailsPayment')->name('details_payment');
        Route::get('/edit/payment/{id}' , 'editPayment')->name('edit_payment');
        Route::put('/update/payment/{id}' , 'updatePayment')->name('update_payment');
        Route::delete('/delete/payment/{id}' , 'deletePayment')->name('delete_payment');

        Route::get('/edit/payment/Details/{id}' , 'editPaymentDetails')->name('edit_payment_Details');
        Route::put('/update/payment/Details/{id}' , 'updatePaymentDetails')->name('update_payment_Details');
        Route::delete('/delete/payment/Details/{id}' , 'deletePaymentDetails')->name('delete_payment_Details');



        //vendors invoices
        Route::get('/view/vendors/invoices' , 'viewVendorInvoices')->name('view_vendors_invoices');
        Route::get('/details/vendor/invoice/{id}' , 'detailsVendorInvoice')->name('details_vendor_invoice');
        Route::get('/edit/vendor/invoice/{id}' , 'editVendorInvoice')->name('edit_vendor_invoice');
        Route::put('/update/vendor/invoice/{id}' , 'updateVendorInvoice')->name('update_vendor_invoice');
        Route::delete('/delete/vendor/invoice/{id}' , 'deleteVendorInvoice')->name('delete_vendor_invoice');



        //expenses
        Route::get('/view/expenses' , 'viewExpenses')->name('view_expenses');
        Route::get('/details/expense/{id}' , 'detailsExpense')->name('details_expense');
        Route::get('/edit/expense/{id}' , 'editExpense')->name('edit_expense');
        Route::put('/update/expense/{id}' , 'updateExpense')->name('update_expense');
        Route::delete('/delete/expense/{id}' , 'deleteExpense')->name('delete_expense');

        Route::get('/edit/expense/Details/{id}' , 'editExpenseDetails')->name('edit_expense_Details');
        Route::put('/update/expense/Details/{id}' , 'updateExpenseDetails')->name('update_expense_Details');
        Route::delete('/delete/expense/Details/{id}' , 'deleteExpenseDetails')->name('delete_expense_Details');


        //Reports
        Route::get('/view/reports' , 'viewReports')->name('view_reports');
    });
});




// حتى عندما أختار العيادة المحددة يحضر لي فقط تخصصاتها في فورم إضافة طبيب
Route::get('/get-specialties-by-clinic/{clinic_id}', [DoctorController::class, 'getSpecialtiesByClinic']);

// بحضر لي أوقات العيادة في فورم الطبيب عشان أختار أوقات الطبيب بناء ع وقت العيادة
Route::get('/get-clinic-info/{id}', [DoctorController::class, 'getClinicInfo']);

Route::get('/clinic-working-days/{id}', [DoctorController::class, 'getWorkingDays']);    // برجع الأيام المحددة



// عند اختيار العيادة – جلب التخصصات المرتبطة بها فقط
Route::get('/get-specialties-by-clinic/{clinic_id}', [PatientController::class, 'getSpecialtiesByClinic']);

//  عند اختيار التخصص – جلب الأطباء الذين ينتمون لهذا التخصص فقط ومن نفس العيادة فقط
Route::get('/get-doctors-by-clinic-and-specialty', [PatientController::class, 'getDoctorsByClinicAndSpecialty']);

Route::get('/get-doctor-info/{id}', [PatientController::class, 'getDoctorInfo']);   // يرجع أوقات الدكتور للحجز معاه

Route::get('/doctor-working-days/{id}', [PatientController::class, 'getWorkingDays']);  // يرجع أيام الدكتور للحجز معاه








Route::controller(ClinicManagerController::class)->group(function () {
    Route::middleware(['auth' , 'verified' ,'role:clinic_manager'])->group(function () {

        Route::get('/clinic_manager/dashboard' , 'clinicManagerDashboard')->name('clinic_manager_dashboard');

    });
});






Route::controller(DoctorController::class)->group(function () {
    Route::middleware(['auth' , 'verified' ,'role:doctor'])->group(function () {

        Route::get('/doctor/dashboard' , 'doctorDashboard')->name('doctor_dashboard');

    });
});










Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
