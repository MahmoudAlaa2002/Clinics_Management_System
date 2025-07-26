@extends('Backend.master')

@section('title' , 'Edit Expense Details')

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
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Expense Details</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_expense_Details' , ['id' => $expenseItem->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Item Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="item_name" name="item_name" value="{{ $expenseItem->item_name }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Quantity <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="quantity" name="quantity" value="{{ $expenseItem->quantity }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Unit Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="unit_price" name="unit_price" value="{{ $expenseItem->unit_price }}">
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
                                                    'other' => 'Other'
                                                ];
                                            @endphp

                                            @foreach($methods as $value => $label)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_{{ $value }}" value="{{ $value }}"
                                                        {{ old('payment_method', $expenseItem->payment_method ?? '') == $value ? 'checked' : '' }}>
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
                                    <label>Expense Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="date" id="expense_date" name="expense_date" value="{{ \Carbon\Carbon::parse($expenseItem->payment_date)->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label>Notes </label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" cols="30">{{ $expenseItem->notes }}</textarea>
                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Expense Details</button>
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
                let id = {{ $expenseItem->expense_id }};
                let item_name = $('#item_name').val().trim();
                let quantity = $('#quantity').val().trim();
                let unit_price = $('#unit_price').val().trim();
                let payment_method = $('input[name="payment_method"]:checked').val();
                let expense_date = $('#expense_date').val().trim();
                let notes = $('#notes').val().trim();


                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('item_name', item_name);
                formData.append('quantity', quantity);
                formData.append('unit_price', unit_price);
                formData.append('payment_method', payment_method);
                formData.append('expense_date', expense_date);
                formData.append('notes', notes);

                if (item_name === '' || quantity === '' || unit_price === '' ||  !payment_method ||  expense_date === '') {
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
                    url: "{{ route('update_expense_Details', ['id' => $expenseItem->id]) }}",
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
                                text: 'The Expense Details Has Already Been Booked',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Expense Details Has Been Updated Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/details/expense/' + id;
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
