@extends('Backend.admin.master')

@section('title' , 'Edit Patient Payment')

@section('content')

    <style>
        .col-sm-6 {
            margin-bottom: 20px;
        }

        input[type="date"] {
            direction: ltr;
            text-align: left;
        }
    </style>


    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Patient Payment</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_payment' , ['id' => $payment->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Invoice ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="invoice_id" name="invoice_id" value="{{ $payment->invoice_id }}">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Patient Payment</button>
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
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let invoice_id = $('#invoice_id').val();

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('invoice_id', invoice_id);

                if (invoice_id === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: "{{ route('update_payment', ['id' => $payment->id]) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data == 0) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'The Patient Payment has already been booked',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Patient Payment has been updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/view/payments';
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
