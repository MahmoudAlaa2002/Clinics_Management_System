@extends('Backend.master')

@section('title', 'Add New Specialty')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title mb-4">Add New Specialty</h4>

                <form method="POST" action="{{ route('store_specialty') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name">Specialty Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-stethoscope"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter specialty name">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="description">Specialty Description </label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter specialty description"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary submit-btn addBtn px-5 rounded-pill" style="text-transform: none !important;">Add Specialty</button>
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

                let name = $('#name').val().trim();
                let description = $('#description').val().trim();


                if (name == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Specialty Name',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }else{
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('store_specialty') }}",
                        data: {
                            name: name,
                            description:description,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.data == 0) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This Specialty Already Exists',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else if (response.data == 1) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Specialty has been added successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '/add/specialty';
                                });
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
