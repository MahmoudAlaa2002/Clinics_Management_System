@extends('Backend.admin.master')

@section('title', 'Add Specialty')

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
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Specialty</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ route('store_specialty') }}">
                    @csrf

                    {{-- 1) Basic Information --}}
                    <div class="card">
                        <div class="card-header">Basic Information</div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <label>Specialty Name <span class="text-danger">*</span></label>
                                <div class="input-group" style="margin-bottom: 20px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter specialty name">
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-top: 40px;">
                                <label>Specialty Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter specialty description"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- 2) Departments --}}
                    <div class="card">
                        <div class="card-header">This specialty belongs to the following departments</div>
                        <div class="card-body">
                            <label>Departments <span class="text-danger">*</span></label>
                            <div class="row gx-1">
                                @php
                                    $split = ceil($departments->count() / 2);
                                    $chunks = $departments->chunk($split);
                                @endphp

                                @foreach($chunks as $chunk)
                                    <div class="col-6">
                                        @foreach($chunk as $department)
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    class="form-check-input"
                                                    id="spec_{{ $department->id }}"
                                                    name="departments[]"
                                                    value="{{ $department->id }}">
                                                <label class="form-check-label" for="spec_{{ $department->id }}">
                                                    {{ $department->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn addBtn px-5 rounded-pill" style="text-transform: none !important;">
                            Add Specialty
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
                let departments = $('input[name="departments[]"]:checked').map(function(){ return this.value; }).get();

                if (name === '' || departments.length === 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                } else {
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('store_specialty') }}",
                        data: {
                            name: name,
                            description:description,
                            departments: departments,
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
                                    text: 'Specialty Has Been Added Successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '/admin/add/specialty';
                                });
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
