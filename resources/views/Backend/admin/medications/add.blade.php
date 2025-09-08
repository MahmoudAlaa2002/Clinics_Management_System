@extends('Backend.admin.master')

@section('title' , 'Add New Medication')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Medication</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form id="medicationForm" method="POST" action="{{ route('store_medication') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Medication Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="name" name="name">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Form <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-vial"></i></span>
                                    </div>
                                    <select class="form-control" id="form" name="form" required>
                                        <option value="" disabled selected hidden>Select Form</option>
                                        <option value="Tablet">Tablet</option>
                                        <option value="Capsule">Capsule</option>
                                        <option value="Syrup">Syrup</option>
                                        <option value="Injection">Injection</option>
                                        <option value="Suppository">Suppository</option>
                                        <option value="Ointment">Ointment</option>
                                        <option value="Cream">Cream</option>
                                        <option value="Drop">Drop</option>
                                        <option value="Spray">Spray</option>
                                        <option value="Powder">Powder</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Purchase Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input class="form-control" type="number" id="purchase_price" name="purchase_price">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Selling Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input class="form-control" type="number" id="selling_price" name="selling_price">
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label>Medication Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the medication...">{{ old('description') }}</textarea>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn" style="text-transform: none !important;">Add Medication</button>
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

        let name = $('#name').val().trim();
        let dosage_form_id = $('#dosage_form_id').val();
        let strength = $('#strength').val().trim();
        let description = $('#description').val().trim();
        let purchase_price = $('#purchase_price').val().trim();
        let selling_price = $('#selling_price').val().trim();
        let image = document.querySelector('#image').files[0];

        if (name === '' || !dosage_form_id || strength === '' || purchase_price === '' || selling_price === '') {
            Swal.fire({
                title: 'Error!',
                text: 'Please Enter All Required Fields',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        let formData = new FormData();
        formData.append('name', name);
        formData.append('dosage_form_id', dosage_form_id);
        formData.append('strength', strength);
        formData.append('description', description);
        formData.append('purchase_price', purchase_price);
        formData.append('selling_price', selling_price);
        if (image) {
            formData.append('image', image);
        }

        $.ajax({
            method: 'POST',
            url: "{{ route('store_medication') }}",
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
                        text: 'This medication already exists',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (response.data == 1) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Medication has been added successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/add/medication';
                    });
                }
            },
        });
    });
});
</script>
@endsection
