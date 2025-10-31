@extends('Backend.admin.master')

@section('title', 'Edit Medical Record')

@section('content')
<style>
    .col-sm-6 { margin-bottom: 20px; }
    input[type="date"], input[type="text"], input[type="number"], select, textarea {
        direction: ltr;
        text-align: left;
    }
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
                <h4 class="mb-4 page-title">Edit Medical Record</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form id="editMedicalRecordForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">Medical Record Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Appointment ID </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="appointment_id" name="appointment_id"
                                               value="{{ $medical_record->appointment_id }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Patient Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control"
                                               value="{{ $medical_record->patient->user->name ?? 'Unknown' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Doctor Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user-md"></i></span>
                                        </div>
                                        <input type="text" class="form-control"
                                               value="{{ $medical_record->doctor->employee->user->name ?? 'Unknown' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Diagnosis <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-stethoscope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="diagnosis" name="diagnosis"
                                               value="{{ $medical_record->diagnosis }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Treatment <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pills"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="treatment" name="treatment"
                                               value="{{ $medical_record->treatment }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Record Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="record_date" name="record_date"
                                               value="{{ $medical_record->record_date }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card mt-4">
                        <div class="card-header">Prescriptions & Attachments</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12 mb-3">
                                    <label>Prescriptions <span class="text-danger">*</span></label>
                                    <textarea id="prescriptions" name="prescriptions" class="form-control" rows="3"
                                              placeholder="Enter prescriptions...">{{ $medical_record->prescriptions }}</textarea>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <label>Attachments (optional)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-paperclip"></i></span>
                                        </div>
                                        <input type="text" id="attachments" name="attachments" class="form-control"
                                               placeholder="Add email, link, or file reference"
                                               value="{{ $medical_record->attachments }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Notes</label>
                                    <textarea id="notes" name="notes" class="form-control" rows="3"
                                        placeholder="Additional notes...">{{ $medical_record->notes }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn editBtn"
                                style="text-transform:none !important;">
                            Edit Medical Record
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
        $('.editBtn').on('click', function (e) {
            e.preventDefault();

            const form = $('#editMedicalRecordForm')[0];
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            $.ajax({
                method: 'POST',
                url: "{{ route('update_medical_record', ['id' => $medical_record->id]) }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (res) {
                    if (res.data == 1){
                        Swal.fire(
                            'Success',
                            'Medical Record Has Been Updated Successfully',
                            'success'
                        ).then(() => window.location.href = '/admin/view/medical-records');
                    }else{
                        Swal.fire('Info', 'Unknown response received', 'info');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Unexpected error occurred while updating', 'error');
                }
            });
        });
    });
</script>
@endsection
