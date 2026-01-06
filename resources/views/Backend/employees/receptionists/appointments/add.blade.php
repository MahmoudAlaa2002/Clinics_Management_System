@extends('Backend.employees.receptionists.master')

@section('title' , 'Add New Appointment')

@section('content')

<style>
    .col-sm-6 { margin-bottom: 20px; }
    .card + .card { margin-top: 20px; }
    input[type="date"], input[type="time"] { direction: ltr; text-align: left; }

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

    select.no-arrow {
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        background-image: none !important;
        pointer-events: none;
    }

</style>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Payment Details</h5>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Doctor Consultation Fee</label>
                    <input type="text" class="form-control" id="consultation_fee" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Paid Amount <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="paid_amount" min="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Payment Method <span class="text-danger">*</span>
                    </label>

                    <select class="form-control" id="payment_method">
                        <option value="" disabled selected hidden>Select</option>

                        <option value="Cash">Cash</option>
                        <option value="Bank">Bank</option>
                        <option value="PayPal">PayPal</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="due_date">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="confirmPayment">Confirm Payment</button>
            </div>

        </div>
    </div>
</div>


<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Appointment</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form id="appointmentForm" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="clinic_id" name="clinic_id" value="{{ $clinic_id }}">
                    <input type="hidden" id="department_id" name="department_id" value="{{ $department_id }}">

                    <div class="card">
                        <div class="card-header">Appointment Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Clinic</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select class="form-control no-arrow" disabled>
                                            <option selected>
                                                {{ \App\Models\Clinic::find($clinic_id)->name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Department</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <select class="form-control no-arrow" disabled>
                                            <option selected>
                                                {{ \App\Models\Department::find($department_id)->name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select class="form-control" id="patient_id" name="patient_id">
                                            <option value="" disabled selected hidden>Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Assigned to Doctor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select class="form-control" id="doctor_id" name="doctor_id">
                                            <option value="" disabled selected hidden>Select Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->employee->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Appointment Day <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                        </div>
                                        <select name="appointment_day" id="appointment_day" class="form-control">
                                            <option value="" disabled selected hidden>Select Day</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Appointment Time<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select name="appointment_time" id="appointment_time" class="form-control">
                                            <option value="" disabled selected hidden>Select Appointment Time</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-3 card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="button" id="openPaymentModal" class="btn btn-primary submit-btn addBtn px-5 rounded-pill" style="text-transform: none !important;">
                            Add Appointment
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

    function isValidSelectValue(id) {
        let val = $(`#${id}`).val();
        return val && $(`#${id} option[value="${val}"]`).length > 0;
    }

    $(document).on('click', '#openPaymentModal', function(e){
        e.preventDefault();

        // فحص الحقول الأساسية قبل أي شيء
        if (!isValidSelectValue('patient_id') ||
            !isValidSelectValue('doctor_id') ||
            !isValidSelectValue('appointment_time') ||
            !isValidSelectValue('appointment_day')) {

            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please Enter All Required Fields',
                confirmButtonColor: '#00A8FF'
            });

            return;
        }

        let formData = new FormData(document.getElementById("appointmentForm"));

        $.ajax({
            url: "{{ route('receptionist.check_appointment') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                if (response.data == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'This patient already has an appointment at this time',
                        confirmButtonColor: '#00A8FF'
                    });
                }
                else if (response.data == 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'This appointment slot is already booked',
                        confirmButtonColor: '#00A8FF'
                    });
                }
                else if (response.data == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'This appointment time has already passed',
                        confirmButtonColor: '#00A8FF'
                    });
                }
                else if (response.data == 3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'You already have another appointment at this time',
                        confirmButtonColor: '#00A8FF'
                    });
                }
                else if (response.data == 4) {
                    $("#paymentModal").modal('show');
                }
            }
        });

    });


    $(document).on('click', '#confirmPayment', function () {

        let formData = new FormData(document.getElementById("appointmentForm"));

        let paid = $("#paid_amount").val();
        let method = $("#payment_method").val();
        let consultationFee = parseFloat(
            $("#consultation_fee").val().replace('$', '').trim()
        );


        if (paid === "" || paid < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Payment Info',
                text: 'Please fill all required payment fields',
                confirmButtonColor: '#00A8FF'
            });
            return;
        }

        if (paid > consultationFee) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Payment Amount',
                text: 'Paid amount cannot exceed the consultation fee',
                confirmButtonColor: '#00A8FF'
            });
            return;
        }

        if (paid > 0 && !method) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Payment Method',
                text: 'You must select a payment method when a payment amount is entered',
                confirmButtonColor: '#00A8FF'
            });
            return;
        }

        if (paid == 0 && method) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Payment Method',
                text: 'You cannot select a payment method when payment amount is $0',
                confirmButtonColor: '#00A8FF'
            });
            return;
        }

        formData.append('paid_amount', $("#paid_amount").val());
        formData.append('payment_method', method === "" ? null : method);
        formData.append('due_date', $("#due_date").val());

        $.ajax({
            url: "{{ route('receptionist.store_appointment') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                if (response.data == 4) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Appointment and Invoice Created Successfully',
                        confirmButtonColor: '#00A8FF'
                    })
                    .then(() => { window.location.href = `/employee/receptionist/invoice-pdf/view/${response.invoice_id}`;
                    });

                    return;
                }

                // لو صار خطأ غير متوقع
                Swal.fire({
                    icon:'error',
                    title:'Error!',
                    text:'Unexpected error occurred',
                    confirmButtonColor:'#00A8FF'
                });
            }
        });

    });


    $('#doctor_id').on('change', function () {
        var doctorId = $(this).val();

        if (doctorId) {
            $.ajax({
                url: '/clinics-management/get-doctor-info/' + doctorId,
                type: 'GET',
                success: function (data) {

                    $("#consultation_fee").val("$ " + data.consultation_fee);

                    let startParts = data.work_start_time.split(':');
                    let endParts = data.work_end_time.split(':');

                    let startHour = parseInt(startParts[0]);
                    let startMinute = parseInt(startParts[1]);

                    let endHour = parseInt(endParts[0]);
                    let endMinute = parseInt(endParts[1]);

                    let appointmentSelect = $('#appointment_time');
                    appointmentSelect.empty().append('<option disabled selected hidden>Select Appointment Time</option>');

                    let current = new Date();
                    current.setHours(startHour, startMinute, 0, 0);

                    let end = new Date();
                    end.setHours(endHour, endMinute, 0, 0);

                    while (current <= end) {
                        let hh = current.getHours().toString().padStart(2, '0');
                        let mm = current.getMinutes().toString().padStart(2, '0');
                        let timeLabel = `${hh}:${mm}`;
                        appointmentSelect.append(`<option value="${timeLabel}:00">${timeLabel}</option>`);
                        current.setMinutes(current.getMinutes() + 30);
                    }
                },
            });
        }
    });


    $('#doctor_id').on('change', function () {
        var doctorId = $(this).val();
        let daySelect = $('#appointment_day');
        daySelect.empty().append('<option disabled selected hidden>Select Day</option>');

        if (doctorId) {
            $.ajax({
                url: '/clinics-management/doctor-working-days/' + doctorId,
                type: 'GET',
                success: function (days) {
                    days.forEach(function(day) {
                        daySelect.append(`<option value="${day}">${day}</option>`);
                    });
                },
            });
        }
    });

</script>
@endsection




