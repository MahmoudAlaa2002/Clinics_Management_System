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
                                    <label>Due Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="due_date" name="due_date"
                                               value="{{ $invoice->due_date }}">
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
                                    <label>Payment Status <span class="text-danger">*</span></label>
                                    <select id="payment_status" name="payment_status" class="form-control">
                                        <option value="Paid" {{ $invoice->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="Partially Paid" {{ $invoice->payment_status == 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                                        <option value="Unpaid" {{ $invoice->payment_status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    </select>
                                </div>

                            </div>
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

        let totalAmount = $('#total_amount').val().trim();

        if (totalAmount === '') {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter all required fields',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#007BFF',
            });
            return;
        }

        $.ajax({
            method: 'POST',
            url: "{{ route('update_invoice', ['id' => $invoice->id]) }}",
            data: formData,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (res) {
                if (res.data == 1){
                    Swal.fire(
                        'Success',
                        'Invoice has been updated successfully',
                        'success'
                    ).then(() => window.location.href = '/admin/view/invoices');
                }else{
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
