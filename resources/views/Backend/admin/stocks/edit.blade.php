@extends('Backend.master')

@section('title' , 'Edit Medication Stock')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="mb-4 page-title">Edit Medication Stock</h4>
                <form id="medicationForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Clinic Name -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Clinic Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                    </div>
                                    <select class="form-control" id="clinic_id" name="clinic_id">
                                        <option value="" disabled {{ old('clinic_id', $medicineStocks->clinic_id ?? '') == '' ? 'selected' : '' }} hidden>Select Clinic</option>
                                        @foreach($clinics as $clinic)
                                            <option value="{{ $clinic->id }}" {{ old('clinic_id', $medicineStocks->clinic_id ?? '') == $clinic->id ? 'selected' : '' }}>
                                                {{ $clinic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Medication Name -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Medication Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                                    </div>
                                    <select class="form-control" id="medication_id" name="medication_id">
                                        <option value="" disabled {{ old('medication_id', $medicineStocks->medication_id ?? '') == '' ? 'selected' : '' }} hidden>
                                            Select Medication
                                        </option>
                                        @foreach($medications as $medication)
                                            <option value="{{ $medication->id }}"
                                                {{ old('medication_id', $medicineStocks->medication_id ?? '') == $medication->id ? 'selected' : '' }}>
                                                {{ $medication->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Quantity <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="quantity" name="quantity" value="{{ $medicineStocks->quantity }}">
                                </div>
                            </div>
                        </div>

                        <!-- Batch Number -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Batch Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="batch_number" name="batch_number" readonly value="{{ $medicineStocks->batch_number }}">
                                </div>
                            </div>
                        </div>

                        <!-- Manufacture Date -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Manufacture Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" id="manufacture_date" name="manufacture_date" class="form-control" dir="ltr" lang="en" value="{{ $medicineStocks->manufacture_date }}">
                                </div>
                            </div>
                        </div>

                        <!-- Expiry Date -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Expiry Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" id="expiry_date" name="expiry_date" class="form-control" dir="ltr" lang="en" value="{{ $medicineStocks->expiry_date }}">
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label>Medication Stock Description</label>
                                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the medication...">
                            {{ old('description', $medicineStocks->description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Medication Stock</button>
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
            $('#medicationForm').on('submit', function (e) {
                e.preventDefault();

                let clinic_id = $('#clinic_id').val();
                let medication_id = $('#medication_id').val();
                let quantity = $('#quantity').val();
                let batch_number = $('#batch_number').val().trim();
                let manufacture_date = $('#manufacture_date').val();
                let expiry_date = $('#expiry_date').val().trim();
                let description = $('#description').val().trim();



                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('clinic_id', clinic_id);
                formData.append('medication_id', medication_id);
                formData.append('quantity', quantity);
                formData.append('batch_number', batch_number);
                formData.append('manufacture_date', manufacture_date);
                formData.append('expiry_date', expiry_date);
                formData.append('description', description);


                if (!clinic_id || !medication_id || quantity === '' || batch_number === '' || manufacture_date === '' || expiry_date === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }else if(isNaN(quantity) || quantity <= 0){
                    Swal.fire({
                        title: 'Invalid Input!',
                        text: 'Quantity must be positive numbers',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }else{
                    $.ajax({
                    method: 'POST',
                    url: "{{ route('update_stock', ['id' => $medicineStocks->id]) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'The medication stock has been successfully updated',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/view/stocks';
                            });
                        }
                    },
                });
            }
        });
    });


        $(document).ready(function () {
            $('#clinic_id, #medication_id').on('change', function () {
                let clinic_id = $('#clinic_id').val();
                let medication_id = $('#medication_id').val();

                if (clinic_id && medication_id) {
                    $.ajax({
                        url: '{{ route('generate_batch_number') }}',
                        type: 'GET',
                        data: {
                            clinic_id: clinic_id,
                            medication_id: medication_id
                        },
                        success: function (response) {
                            if (response.batch_number) {
                                $('#batch_number').val(response.batch_number);
                            } else {
                                $('#batch_number').val('');
                            }
                        },
                        error: function () {
                            $('#batch_number').val('');
                        }
                    });
                } else {
                    $('#batch_number').val('');
                }
            });
        });
    </script>
@endsection
