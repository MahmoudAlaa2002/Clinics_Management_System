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
                        <div class="card-header">Basic Information</div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <label>Department Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter department name">
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-top: 40px;">
                                <label>Department Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter department description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">Select Specialties for this Department</div>
                        <div class="card-body">
                            <label>Specialties <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($specialties as $specialty)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                name="specialties[]" value="{{ $specialty->id }}"
                                                id="spec_{{ $specialty->id }}">
                                            <label class="form-check-label" for="spec_{{ $specialty->id }}">
                                                {{ $specialty->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
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
                let specialties = $('input[name="specialties[]"]:checked').map(function(){ return this.value; }).get();


                if (name == '' || specialties.length === 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
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
                            specialties: specialties,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.data == 0) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This Department Already Exists',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else if (response.data == 1) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Department Has Been Added Successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '/admin/add/department';
                                });
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
