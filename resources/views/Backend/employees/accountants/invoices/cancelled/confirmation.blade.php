@extends('Backend.employees.accountants.master')

@section('title', 'Cancelled Invoice Confirmation')

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
                <h4 class="mb-4 page-title">Cancelled Invoice Confirmation</h4>
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
                                    <label>Appointment ID</label>
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
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $invoice->patient->user->name ?? 'Unknown' }}" readonly>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <label>Total Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="total_amount" name="total_amount"
                                               value="{{ $invoice->total_amount }}" min="0" step="0.01" readonly>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <label>Paid Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="paid_amount" name="paid_amount"
                                               value="{{ $invoice->paid_amount }}" min="0" step="0.01" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Refund Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="refund_amount" name="refund_amount"
                                               value="{{ $invoice->refund_amount }}" min="0" step="0.01" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Payment Method</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="payment_method" name="payment_method" value="{{ $invoice->payment_method }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Refund Confirmation
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>Refund Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar-day"></i>
                                            </span>
                                        </div>
                                        <input type="date" class="form-control" id="refund_date" name="refund_date" value="{{ $invoice->refund_date }}">
                                    </div>
                                </div>

                                <div class="mt-3 col-md-12">
                                    <label>Notes</label>
                                    <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Write any notes about the refund (optional)...">{{ old('notes', $invoice->notes) }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>




                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn editBtn"
                                style="text-transform:none !important;">
                            Refund Confirmation
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

            let refund_date = $('#refund_date').val();
            let notes = $('#notes').val().trim();


            if (refund_date === '') {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter the refund date',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#00A8FF',
                });
                return;
            }

            let noChanges =
                refund_date === "{{ $invoice->refund_date }}" &&
                notes === "{{ $invoice->notes }}";

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
                url: "{{ route('accountant.update_refund_confirm', ['id' => $invoice->id]) }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (res) {
                    if (res.data == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Refund has been processed successfully',
                            icon: 'success',
                            confirmButtonColor: '#00A8FF'
                        }).then(() => {
                            window.location.href = '/employee/accountant/view/invoices';
                        });
                    } else{
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
