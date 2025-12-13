<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller{

    public function viewDepratments(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $departments = ClinicDepartment::with('department')->where('clinic_id', $clinic_id)->paginate(10);

        foreach ($departments as $item) {
            $item->invoices_count = Invoice::whereHas('appointment', function ($q) use ($item) {
                $q->where('clinic_department_id', $item->id);
            })->count();
        }

        $totalInvoices = $departments->sum('invoices_count');
        return view('Backend.employees.accountants.depratments.view', compact('departments' , 'totalInvoices'));
    }

}
