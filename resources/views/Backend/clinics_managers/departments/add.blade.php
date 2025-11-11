@extends('Backend.clinics_managers.master')

@section('title', 'Add Department to Clinic')

@section('content')

<style>
    .col-sm-6 { margin-bottom: 20px; }
    .card + .card { margin-top: 20px; }
    input[type="time"] { direction: ltr; text-align: left; }

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
                <h4 class="page-title" style="margin-bottom: 30px;">Add Department to Clinic</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ route('clinic.store_department') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">Department</div>
                        <div class="card-body">
                            <div class="col-sm-6">
                                <label>Department Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-building"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="department_id" name="department_id">
                                        <option value="" hidden selected>Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn addBtn px-5 rounded-pill" style="text-transform: none !important;">
                            Add Department
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
        function isValidSelectValue(selectId) {
            let val = $(`#${selectId}`).val();
            return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
        }

        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let department_id = $('#department_id').val();

                if (!isValidSelectValue('department_id')) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter all required fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }else{
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('clinic.store_department') }}",
                        data: {
                            department_id: department_id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.data == 0) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This department already exists',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else if (response.data == 1) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Department has been added successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '/clinic-manager/view/departments';
                                });
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
