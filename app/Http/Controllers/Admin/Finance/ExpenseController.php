<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Models\Clinic;
use App\Models\Expense;
use App\Models\ActivityLog;
use App\Models\ExpenseItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller{

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





    //Vendors Expenses Details
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
}
