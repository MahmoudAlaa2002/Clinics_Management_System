@extends('Backend.admin.master')

@section('title' , 'Edit Patient Payment Details')

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
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Patient Payment Details</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_payment_Details' , ['id' => $paymentDetail->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Amount Paid <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="amount_paid" name="amount_paid" value="{{ $paymentDetail->amount_paid }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group" style="margin-left:20px;">
                                    <label>Payment Method <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        </div>
                                        <div class="form-control p-2" style="border: none; background: transparent;">
                                            @php
                                                $methods = [
                                                    'cash' => 'Cash',
                                                    'credit_card' => 'Credit Card',
                                                    'bank_transfer' => 'Bank Transfer',
                                                    'insurance' => 'Insurance'
                                                ];
                                            @endphp

                                            @foreach($methods as $value => $label)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_{{ $value }}" value="{{ $value }}"
                                                        {{ old('payment_method', $paymentDetail->payment_method ?? '') == $value ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="payment_{{ $value }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Payment Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="date" id="payment_date" name="payment_date" value="{{ \Carbon\Carbon::parse($paymentDetail->payment_date)->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label>Notes </label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" cols="30">{{ $paymentDetail->notes }}</textarea>
                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Patient Payment Details</button>
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
                let id = {{ $paymentDetail->id }};
                let amount_paid = $('#amount_paid').val().trim();
                let payment_method = $('input[name="payment_method"]:checked').val();
                let payment_date = $('#payment_date').val().trim();
                let notes = $('#notes').val().trim();


                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('amount_paid', amount_paid);
                formData.append('payment_method', payment_method);
                formData.append('payment_date', payment_date);
                formData.append('notes', notes);

                if (amount_paid === '' ||  !payment_method ||  payment_date === '') {
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
                    url: "{{ route('update_payment_Details', ['id' => $paymentDetail->id]) }}",
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
                                text: 'The Patient Payment Details Has Already Been Booked',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Patient Payment Detail Has Been Updated Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/details/payment/' + id;
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
