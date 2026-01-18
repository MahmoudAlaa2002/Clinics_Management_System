@extends('Backend.patients.master')

@section('title','Book Appointment')

@section('content')

<style>
    .booking-wrapper{max-width:1100px;margin:auto;padding:50px 15px;}
    .booking-card{background:#fff;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,.08);padding:40px;}
    .booking-title{text-align:center;margin-bottom:40px;}
    .booking-title h2{color:#00A8FF;font-weight:900;}
    .booking-title p{color:#6b7280;}
    .form-group{margin-bottom:20px;}
    .form-label{font-weight:700;font-size:13px;color:#374151;margin-bottom:6px;display:block;}
    .form-control,.form-select{padding:14px 16px;border:1px solid #e5e7eb;font-size:14px;}
    .form-control:focus,.form-select:focus{border-color:#00A8FF;box-shadow:0 0 0 3px rgba(0,168,255,.15);}
    .booking-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;}
    .booking-btn{background:#00A8FF;color:#fff;border:none;padding:14px;border-radius:14px;font-size:16px;font-weight:800;width:100%;margin-top:30px;}
    .booking-btn:hover{background:#0090dd;}
    .section-box{background:#f7fbff;border:1px solid #e6f0fb;border-radius:16px;padding:20px;margin-bottom:30px;}
    .section-box h5{font-weight:800;margin-bottom:15px;color:#1f2937;}
</style>

<div class="booking-wrapper">
    <div class="booking-card">

    <div class="booking-title">
        <h2>Book An Appointment</h2>
        <p>Schedule your visit in just a few easy steps</p>
    </div>

    <form method="POST" action="{{ route('patient.appointment_hold') }}">
        @csrf

        @if(isset($doctorId))
            <input type="hidden" id="preselected_doctor" value="{{ $doctorId }}">
            <input type="hidden" id="preselected_department" value="{{ $department }}">
        @endif

        <div class="section-box">
            <h5>Select Clinic</h5>
            <label class="form-label">Clinic <span class="text-danger">*</span></label>
            <select id="clinic_id" name="clinic_id" class="form-select">
                <option value="" disabled selected hidden {{ empty($clinic)?'selected':'' }}>Select clinic</option>
                @foreach($clinics as $c)
                    <option value="{{ $c->id }}" {{ isset($clinic)&&$clinic->id==$c->id?'selected':'' }}>
                    {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="section-box">
            <h5>Doctor & Department</h5>
            <div class="booking-grid">
                <div class="form-group">
                    <label class="form-label">Department <span class="text-danger">*</span></label>
                    <select id="department_id" name="department_id" class="form-select">
                        <option disabled selected hidden>Select department</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Doctor <span class="text-danger">*</span></label>
                    <select id="doctor_id" name="doctor_id" class="form-select">
                        <option disabled selected hidden>Select doctor</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="section-box">
            <h5>Date & Time</h5>
            <div class="booking-grid">
                <div class="form-group">
                    <label class="form-label">Day <span class="text-danger">*</span></label>
                    <select id="appointment_day" name="appointment_day" class="form-select">
                        <option disabled selected hidden>Select day</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Time <span class="text-danger">*</span></label>
                    <select id="appointment_time" name="appointment_time" class="form-select">
                        <option disabled selected hidden>Select time</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="section-box">
            <h5>Notes (optional)</h5>
            <textarea name="notes" class="form-control" rows="3" placeholder="Write notes for doctor..."></textarea>
        </div>

        <button type="submit" class="booking-btn">Confirm Appointment</button>

    </form>
    </div>
</div>

@endsection


@section('js')
<script>
    $(document).ready(function () {

        $('.booking-btn').on('click', function (e) {
            e.preventDefault();

            let btn = $(this);
            btn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: "{{ route('patient.appointment_hold') }}",
                method: "POST",
                data: {
                    clinic_id: $('#clinic_id').val(),
                    department_id: $('#department_id').val(),
                    doctor_id: $('#doctor_id').val(),
                    appointment_day: $('#appointment_day').val(),
                    appointment_time: $('#appointment_time').val(),
                    notes: $('textarea[name="notes"]').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {

                    btn.prop('disabled', false).text('Confirm Appointment');

                    if (res.ok) {
                        window.location.href = "/patient/payment/" + res.hold_id;
                        return;
                    }

                    // الحالات
                    if (res.data === -1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'This appointment time has already passed',
                            confirmButtonColor: '#00A8FF'
                        });

                    } else if (res.data === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'You already booked this appointment',
                            confirmButtonColor: '#00A8FF'
                        });

                    } else if (res.data === 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'You already have another appointment at this time',
                            confirmButtonColor: '#00A8FF'
                        });

                    } else if (res.data === 2) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: 'This time slot is already taken',
                            confirmButtonColor: '#00A8FF'
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to reserve appointment. Try again.',
                            confirmButtonColor: '#00A8FF'
                        });
                    }

                },
                error: function () {
                    btn.prop('disabled', false).text('Confirm Appointment');
                    Swal.fire('Error', 'Server error. Please try again.', 'error');
                }
            });
        });


        let preDepartment = $('#preselected_department').val() || null;
        let preDoctor     = $('#preselected_doctor').val() || null;

        let departmentSelected = false;
        let doctorSelected = false;

        // ============================
        // عند تغيير العيادة
        // ============================
        $('#clinic_id').on('change', function () {

            let clinicId = $(this).val();
            if (!clinicId) return;

            $('#department_id').html('<option disabled selected hidden>Loading...</option>');
            $('#doctor_id').html('<option disabled selected hidden>Select doctor</option>');
            $('#appointment_day').html('<option disabled selected hidden>Select day</option>');
            $('#appointment_time').html('<option disabled selected hidden>Select time</option>');

            $.get('/clinics-management/get-departments-by-clinic/' + clinicId, function (data) {

                let dept = $('#department_id');
                dept.empty().append('<option disabled selected hidden>Select department</option>');

                data.forEach(d => {
                    dept.append(`<option value="${d.id}">${d.name}</option>`);
                });

                // اختر القسم تلقائيًا مرة واحدة فقط
                if (preDepartment && !departmentSelected) {
                    dept.val(preDepartment).trigger('change');
                    departmentSelected = true;
                }
            });
        });

        // ============================
        // عند تغيير القسم
        // ============================
        $('#department_id').on('change', function () {

            let clinicId = $('#clinic_id').val();
            let deptId   = $(this).val();
            if (!clinicId || !deptId) return;

            $('#doctor_id').html('<option disabled selected hidden>Loading...</option>');

            $.get('/clinics-management/get-doctors-by-clinic-and-department', {
                clinic_id: clinicId,
                department_id: deptId
            }, function (data) {

                let doc = $('#doctor_id');
                doc.empty().append('<option disabled selected hidden>Select doctor</option>');

                data.forEach(d => {
                    doc.append(`<option value="${d.id}">${d.name}</option>`);
                });

                // اختر الطبيب تلقائيًا مرة واحدة فقط
                if (preDoctor && !doctorSelected) {
                    doc.val(preDoctor).trigger('change');
                    doctorSelected = true;
                }
            });
        });

        // ============================
        // عند تغيير الطبيب
        // ============================
        $('#doctor_id').on('change', function () {

            let doctorId = $(this).val();
            if (!doctorId) return;

            $('#appointment_day').html('<option disabled selected hidden>Loading...</option>');
            $('#appointment_time').html('<option disabled selected hidden>Loading...</option>');

            // الأيام
            $.get('/clinics-management/doctor-working-days/' + doctorId, function (days) {

                let day = $('#appointment_day');
                day.empty().append('<option disabled selected hidden>Select day</option>');

                days.forEach(d => {
                    day.append(`<option value="${d}">${d}</option>`);
                });
            });

            // الأوقات
            $.get('/clinics-management/get-doctor-info/' + doctorId, function (d) {

                let start = d.work_start_time.split(':');
                let end   = d.work_end_time.split(':');

                let current = new Date();
                current.setHours(start[0], start[1], 0, 0);

                let endTime = new Date();
                endTime.setHours(end[0], end[1], 0, 0);

                let time = $('#appointment_time');
                time.empty().append('<option disabled selected hidden>Select time</option>');

                while (current <= endTime) {
                    let hh = current.getHours().toString().padStart(2, '0');
                    let mm = current.getMinutes().toString().padStart(2, '0');
                    let label = `${hh}:${mm}`;

                    time.append(`<option value="${label}:00">${label}</option>`);
                    current.setMinutes(current.getMinutes() + 30);
                }
            });
        });


        if ($('#clinic_id').val()) {
            $('#clinic_id').trigger('change');
        }

    });
</script>
@endsection
