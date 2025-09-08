@extends('Backend.admin.master')

@section('title' , 'Edit Vendor Invoice')

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
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Vendor Invoice</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_vendor_invoice' , ['id' => $vendorInvoice->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Vendor Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <select class="form-control" id="vendor_id" name="vendor_id" required>
                                            <option value="" disabled hidden>Select Vendor</option>
                                            @php
                                                $selectedVendorId = old('vendor_id', $vendorInvoice->vendor_id ?? null);
                                            @endphp
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" {{ $vendor->id == $selectedVendorId ? 'selected' : '' }}>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Clinic Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                        </div>
                                        <select class="form-control" id="clinic_id" name="clinic_id" required>
                                            <option value="" disabled hidden>Select Clinic</option>
                                            @php
                                                $selectedClinicId = old('clinic_id', $vendorInvoice->clinic_id ?? null);
                                            @endphp
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" {{ $clinic->id == $selectedClinicId ? 'selected' : '' }}>
                                                    {{ $clinic->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Invoice Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="date" id="invoice_date" name="invoice_date" value="{{ \Carbon\Carbon::parse($vendorInvoice->invoice_date)->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Total Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="total_amount" name="total_amount" value="{{ $vendorInvoice->total_amount }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Discount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="discount" name="discount" value="{{ $vendorInvoice->discount }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="display-block">Status <span class="text-danger">*</span></label>

                                    @php
                                        $status = old('status', $vendorInvoice->status ?? 'unpaid');
                                    @endphp

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_paid" value="paid" {{ $status === 'paid' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_paid">paid</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_unpaid" value="unpaid" {{ $status === 'unpaid' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_unpaid">unpaid</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_partial" value="partial" {{ $status === 'partial' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_partial">partial</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Notes </label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" cols="30">{{ $vendorInvoice->notes }}</textarea>
                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Vendor Invoice</button>
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

                let vendor_id = $('#vendor_id').val();
                let clinic_id = $('#clinic_id').val();
                let invoice_date = $('#invoice_date').val().trim();
                let total_amount = $('#total_amount').val().trim();
                let discount = $('#discount').val().trim();
                let status = $('input[name="status"]:checked').val();
                let notes = $('#notes').val().trim();

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('vendor_id', vendor_id);
                formData.append('clinic_id', clinic_id);
                formData.append('invoice_date', invoice_date);
                formData.append('total_amount', total_amount);
                formData.append('discount', discount);
                formData.append('status', status);
                formData.append('notes', notes);

                if (!isValidSelectValue('vendor_id') || !isValidSelectValue('clinic_id') ||  invoice_date === '' || total_amount === '' || discount === '' || !status === '') {
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
                    url: "{{ route('update_vendor_invoice', ['id' => $vendorInvoice->id]) }}",
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
                                text: 'The Vendor Invoice Has Already Been Booked',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Vendor Invoice Has Been Updated Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/view/vendors/invoices';
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
