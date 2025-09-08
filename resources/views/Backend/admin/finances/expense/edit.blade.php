@extends('Backend.admin.master')

@section('title' , 'Edit Expense')

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
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Expense</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_expense' , ['id' => $expense->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Vendor Invoice ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="vendor_invoice_id" name="vendor_invoice_id" value="{{ $expense->vendor_invoice_id }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        function isValidSelectValue(selectId) {
            let val = $(`#${selectId}`).val();
            return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
        }

        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let vendor_invoice_id = $('#vendor_invoice_id').val().trim();

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('vendor_invoice_id', vendor_invoice_id);

                if (vendor_invoice_id === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Vendor Invoice ID',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: "{{ route('update_expense', ['id' => $expense->id]) }}",
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
                                text: 'The Expense Has Already Been Booked',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Expense Has Been Updated Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/view/expenses';
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
