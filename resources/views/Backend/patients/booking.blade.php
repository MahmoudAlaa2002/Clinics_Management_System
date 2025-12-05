@extends('Frontend.master') {{-- استخدم الهيدر والفوتر من الماستر --}}

@section('title', 'Book Appointment')

@section('content')
<main class="main booking-page">
    <section class="section">
        <div class="container">
            <h2 class="mb-4" style="color: #00A8FF;">Book Your Appointment</h2>

            {{-- خطوات الحجز --}}
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="clinic">Select Clinic</label>
                    <select class="form-select" id="clinic">
                        <option value="">Choose Clinic</option>
                        @foreach ($clinics as $clinic)
                            <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 mb-3">
                    <label for="department">Select Department</label>
                    <select class="form-select" id="department" disabled>
                        <option value="">Choose Department</option>
                    </select>
                </div>

                <div class="col-lg-4 mb-3">
                    <label for="doctor">Select Doctor</label>
                    <select class="form-select" id="doctor" disabled>
                        <option value="">Choose Doctor</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-6">
                    <label for="date">Select Date</label>
                    <input type="date" class="form-control" id="date" disabled>
                </div>
                <div class="col-lg-6">
                    <label for="time">Select Time</label>
                    <select class="form-select" id="time" disabled>
                        <option value="">Choose Time</option>
                    </select>
                </div>
            </div>

            <div class="text-center mt-4">
                <button id="confirmBooking" class="btn btn-primary" style="background-color: #00A8FF;" disabled>
                    Confirm Appointment
                </button>
            </div>
        </div>
    </section>
</main>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // عند اختيار العيادة
    $('#clinic').change(function() {
        let clinic_id = $(this).val();
        if(clinic_id) {
            // هنا نعمل Ajax لجلب الأقسام الخاصة بالعيادة
            $.get("/get-departments/" + clinic_id, function(data) {
                $('#department').html('<option value="">Choose Department</option>');
                data.forEach(function(dep) {
                    $('#department').append('<option value="'+dep.id+'">'+dep.name+'</option>');
                });
                $('#department').prop('disabled', false);
            });
        } else {
            $('#department, #doctor, #date, #time').prop('disabled', true);
        }
    });

    // عند اختيار القسم
    $('#department').change(function() {
        let department_id = $(this).val();
        if(department_id) {
            // جلب الدكاترة
            $.get("/get-doctors/" + department_id, function(data) {
                $('#doctor').html('<option value="">Choose Doctor</option>');
                data.forEach(function(doc) {
                    $('#doctor').append('<option value="'+doc.id+'">'+doc.name+'</option>');
                });
                $('#doctor').prop('disabled', false);
            });
        } else {
            $('#doctor, #date, #time').prop('disabled', true);
        }
    });

    // عند اختيار الدكتور
    $('#doctor').change(function() {
        if($(this).val()) {
            $('#date').prop('disabled', false);
        } else {
            $('#date, #time').prop('disabled', true);
        }
    });

    // عند اختيار التاريخ
    $('#date').change(function() {
        let doctor_id = $('#doctor').val();
        let date = $(this).val();
        if(doctor_id && date) {
            // جلب الأوقات المتاحة
            $.get("/get-available-times/" + doctor_id + "/" + date, function(data) {
                $('#time').html('<option value="">Choose Time</option>');
                data.forEach(function(time) {
                    $('#time').append('<option value="'+time+'">'+time+'</option>');
                });
                $('#time').prop('disabled', false);
            });
        } else {
            $('#time').prop('disabled', true);
        }
    });

    // زر تأكيد الحجز
    $('#time').change(function() {
        if($(this).val()) {
            $('#confirmBooking').prop('disabled', false);
        } else {
            $('#confirmBooking').prop('disabled', true);
        }
    });

    $('#confirmBooking').click(function() {
        let data = {
            clinic_id: $('#clinic').val(),
            department_id: $('#department').val(),
            doctor_id: $('#doctor').val(),
            date: $('#date').val(),
            time: $('#time').val(),
            _token: '{{ csrf_token() }}'
        };

        $.post("/book-appointment", data, function(response){
            if(response.success){
                Swal.fire({
                    title: 'Success',
                    text: 'Appointment booked successfully!',
                    icon: 'success'
                }).then(()=> {
                    window.location.href = '/user/appointments';
                });
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        });
    });
});
</script>
@endsection
