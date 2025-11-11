@extends('Backend.admin.master')

@section('title', 'Add Department')

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
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Department</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ route('store_department') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">Name</div>
                        <div class="card-body">
                            <div class="col-sm-6">
                                <label>Department Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter department name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Description & Status</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Department Description</label>
                                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the department...">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="display-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="department_active" value="active" checked>
                                    <label class="form-check-label" for="department_active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="department_inactive" value="inactive">
                                    <label class="form-check-label" for="department_inactive">Inactive</label>
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
        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let name = $('#name').val().trim();
                let description = $('#description').val().trim();
                let status = $('input[name="status"]:checked').val();


                if (name == '') {
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
                        url: "{{ route('store_department') }}",
                        data: {
                            name: name,
                            description:description,
                            status: status,
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
                                    window.location.href = '/admin/view/departments';
                                });
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
