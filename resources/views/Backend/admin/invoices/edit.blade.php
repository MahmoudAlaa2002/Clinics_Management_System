@extends('Backend.admin.master')

@section('title', 'Edit Invoice')

@section('content')
<style>
    .col-sm-6 { margin-bottom: 20px; }
    input[type="date"], input[type="text"], input[type="number"], select {
        direction: ltr;
        text-align: left;
    }
    .card {
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important;
        overflow: hidden !important;
    }
    .card-header {
        background-color: #00A8FF !important;
        color: #fff !important;
        font-weight: 600 !important;
        padding: 12px 15px !important;
        font-size: 16px !important;
        border-bottom: 1px solid #ddd !important;
    }
    .card-body {
        background-color: #fff;
        padding: 20px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="mb-4 page-title">Edit Invoice</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form id="editInvoiceForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">Invoice Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Appointment ID </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="appointment_id" name="appointment_id"
                                               value="{{ $invoice->appointment_id }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Patient Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $invoice->patient->user->name ?? 'Unknown' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Total Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="total_amount" name="total_amount"
                                               value="{{ $invoice->total_amount }}" min="0" step="0.01">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Paid Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="paid_amount" name="paid_amount"
                                               value="{{ $invoice->paid_amount }}" min="0" step="0.01">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Invoice Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                                               value="{{ $invoice->invoice_date }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Due Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="due_date" name="due_date"
                                               value="{{ $invoice->due_date }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Payment Method</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-credit-card"></i>
                                            </span>
                                        </div>

                                        <select class="form-control" id="payment_method" name="payment_method">
                                            <option value="" disabled hidden {{ is_null($invoice->payment_method) ? 'selected' : '' }}>
                                                Select Method
                                            </option>
                                            <option value="Cash"   {{ $invoice->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Bank"   {{ $invoice->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                                            <option value="PayPal" {{ $invoice->payment_method == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <textarea id="notes" name="notes" class="form-control" rows="4">{{ old('notes', $invoice->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn editBtn"
                                style="text-transform:none !important;">
                            Edit Invoice
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
$(document).ready(function () {
    $('.editBtn').on('click', function (e) {
        e.preventDefault();

        const form = $('#editInvoiceForm')[0];
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        // قيم نصية أولاً
        let invoice_date      = $('#invoice_date').val().trim();
        let due_date          = $('#due_date').val().trim();
        let total_amount_str  = $('#total_amount').val().trim();
        let paid_amount_str   = $('#paid_amount').val().trim();
        let payment_method    = $('#payment_method').val() || "";
        // ملاحظة: لو حابب تدخلها في noChanges ممكن تستخدمها
        // let notes             = $('#notes').val().trim();

        // التحقق من الحقول المطلوبة
        if (invoice_date === '' || total_amount_str === '' || paid_amount_str === '') {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter all required fields',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        // تحويل الأرقام
        let total_amount = parseFloat(total_amount_str);
        let paid_amount  = parseFloat(paid_amount_str);

        // التحقق من صحة الأرقام
        if (isNaN(total_amount) || total_amount < 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter a valid total amount',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        if (isNaN(paid_amount) || paid_amount < 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter a valid paid amount',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        // 1) لو المبلغ > 0 لازم يختار طريقة دفع
        if (paid_amount > 0 && payment_method === "") {
            Swal.fire({
                title: 'Error!',
                text: `Please choose a payment method when paid amount is $${paid_amount}`,
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        // 2) لو المبلغ = 0 ممنوع يختار طريقة دفع (Cash/Bank/PayPal)
        if (paid_amount === 0 && payment_method !== "") {
            Swal.fire({
                title: 'Error!',
                text: 'You cannot select a payment method when paid amount is $0',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        // التحقق من تواريخ الفاتورة والاستحقاق
        if (due_date !== '' && invoice_date !== '') {
            let invoiceDateObj = new Date(invoice_date);
            let dueDateObj     = new Date(due_date);

            if (dueDateObj < invoiceDateObj) {
                Swal.fire({
                    title: 'Invalid Date',
                    text: 'Due date must be after the invoice date',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#00A8FF',
                });
                return;
            }
        }

        // التحقق إذا ما في أي تغييرات
        let noChanges =
            invoice_date     === "{{ $invoice->invoice_date }}" &&
            due_date         === "{{ $invoice->due_date }}" &&
            total_amount_str === "{{ $invoice->total_amount }}" &&
            paid_amount_str  === "{{ $invoice->paid_amount }}" &&
            payment_method   === "{{ $invoice->payment_method ?? '' }}";

        if (noChanges) {
            Swal.fire({
                icon: 'warning',
                title: 'No Changes',
                text: 'No updates were made to this invoice',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        $.ajax({
            method: 'POST',
            url: "{{ route('update_invoice', ['id' => $invoice->id]) }}",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                if (res.data == 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Paid amount cannot be greater than total amount',
                        icon: 'error',
                        confirmButtonColor: '#00A8FF'
                    });
                } else if (res.data == 1) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Invoice has been updated successfully',
                        icon: 'success',
                        confirmButtonColor: '#00A8FF'
                    }).then(() => {
                        window.location.href = '/admin/view/invoices';
                    });
                } else {
                    Swal.fire('Info', 'Unknown response received', 'info');
                }
            },
            error: function () {
                Swal.fire('Error!', 'Unexpected error occurred while updating', 'error');
            }
        });
    });
});
</script>
@endsection
