@extends('Backend.master')

@section('title' , 'Add New Employee')

@section('content')
<style>
    .col-sm-6 { margin-bottom: 20px; }
    input[type="date"] { direction: ltr; text-align: left; }
    .card { border: 1px solid #ddd !important; border-radius: 8px !important; box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important; overflow: hidden !important; }
    .card-header { background-color: #00A8FF !important; color: #fff !important; font-weight: 600 !important; padding: 12px 15px !important; font-size: 16px !important; border-bottom: 1px solid #ddd !important; }
    .card-body { background-color: #fff; padding: 20px; }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom:30px;">Add New Employee</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ route('store_employee') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- 1) Employee Information --}}
                    <div class="card">
                        <div class="card-header">Employee Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Employee Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <img alt="" src="{{ asset('assets/img/user.jpg') }}">
                                        </div>
                                        <div class="upload-input">
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group gender-select">
                                      <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                      <div class="form-check-inline">
                                        <label class="form-check-label">
                                          <input type="radio" id="gender" name="gender" class="form-check-input" value="male">Male
                                        </label>
                                      </div>
                                      <div class="form-check-inline">
                                        <label class="form-check-label">
                                          <input type="radio" id="gender" name="gender" class="form-check-input" value="female">Female
                                        </label>
                                      </div>
                                    </div>
                                  </div>

                            </div>
                        </div>
                    </div>

                    {{-- 2) Work Assignment --}}
                    <div class="card">
                        <div class="card-header">Work Assignment</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Clinic <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                        </div>
                                        <select id="clinic_id" name="clinic_id" class="form-control">
                                            <option disabled selected hidden>Select Clinic</option>
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <select id="department_id" name="department_id" class="form-control">
                                            <option disabled selected hidden>Select Department</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Job Title <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-id-badge"></i></span>
                                        </div>
                                        <select id="job_title_id" name="job_title_id" class="form-control">
                                            <option disabled selected hidden>Select Job Title</option>
                                            @foreach($job_titles as $title)
                                                <option value="{{ $title->id }}">{{ $title->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3) Status --}}
                    <div class="card">
                        <div class="card-header">Status</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="display-block">Account Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive">
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn" style="text-transform:none !important;">
                            Add Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
