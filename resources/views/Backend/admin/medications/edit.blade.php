@extends('Backend.admin.master')

@section('title' , 'Edit Medication')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Medication</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form id="medicationForm" method="POST" action="{{ route('update_medication' , ['id' => $medication->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Medication Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="name" name="name" value="{{ $medication->name }}">
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
                                    <select class="form-control" id="dosage_form_id" name="dosage_form_id">
                                        <option value="" disabled hidden {{ old('dosage_form_id', isset($medication) ? $medication->dosage_form_id : '') == '' ? 'selected' : '' }}>
                                            Select Form
                                        </option>
                                        @foreach($dosageForms as $form)
                                            <option value="{{ $form->id }}"
                                                {{ old('dosage_form_id', isset($medication) ? $medication->dosage_form_id : '') == $form->id ? 'selected' : '' }}>
                                                {{ $form->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Strength <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="strength" name="strength" value="{{ $medication->strength }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Image</label>
                                <div class="profile-upload">
                                    <div class="upload-input">
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    </div>
                                    @if(!empty($medication->image))
                                        <div class="mt-2">
                                            <img src="{{ asset($medication->image) }}" alt="Current Image" width="100" height="100" style="border: 1px solid #ccc; padding: 2px;">
                                        </div>
                                    @endif
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
                                    <input class="form-control" type="number" id="purchase_price" name="purchase_price" value="{{ $medication->purchase_price }}">
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
                                    <input class="form-control" type="number" id="selling_price" name="selling_price" value="{{ $medication->selling_price }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label>Medication Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the medication...">{{ old('description', isset($medication) ? $medication->description : '') }}</textarea>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn" style="text-transform: none !important;">Edit Medication</button>
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
                formData.append('_method', 'PUT');
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
                    url: "{{ route('update_medication', ['id' => $medication->id]) }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data == 1) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Medication has been updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/view/medications';
                            });
                        }
                    },
                });
            });
        });
    </script>
@endsection
