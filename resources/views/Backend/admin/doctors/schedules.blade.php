@extends('Backend.master')

@section('title' , 'Doctors Schedules')

@section('content')
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            white-space: nowrap;
            font-size: 12px;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>

<div class="page-wrapper">
    <div class="content">
        <div>
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Search Doctors Schedules</h4>
            </div>
            <div class="card-body" style="margin-top: 50px;">
                <form id="doctor-schedule-form" method="POST" action="{{ route('search_doctor_schedules') }}">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-md-4">
                            <label><i class="fas fa-hospital-alt text-primary"></i> Clinic</label>
                            <select class="form-control" name="clinic_id" id="clinic_id" required>
                                <option value="" disabled {{ !isset($clinic_id) ? 'selected' : '' }} hidden>Select Clinic</option>
                                @foreach($clinics as $clinic)
                                    <option value="{{ $clinic->id }}" {{ (isset($clinic_id) && $clinic_id == $clinic->id) ? 'selected' : '' }}>
                                        {{ $clinic->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label><i class="fas fa-stethoscope text-primary"></i> Specialty</label>
                            <select class="form-control" name="specialty_id" id="specialty_id" required>
                                <option value="" disabled {{ !isset($specialty_id) ? 'selected' : '' }} hidden>Select Specialty</option>
                                @foreach($Specialties as $specialty)
                                    <option value="{{ $specialty->id }}" {{ (isset($specialty_id) && $specialty_id == $specialty->id) ? 'selected' : '' }}>
                                        {{ $specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label><i class="fas fa-user-md text-primary"></i> Doctor</label>
                            <select class="form-control" name="doctor_id" id="doctor_id" required>
                                <option value="" disabled {{ !isset($doctor_id) ? 'selected' : '' }} hidden>Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ (isset($doctor_id) && $doctor_id == $doctor->id) ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="offset" id="week_offset" value="{{ $offset ?? 0 }}">

                    <div class="text-right" style="margin-top: 30px;">
                        <button type="submit" class="px-4 btn btn-success"><i class="mr-2 fa fa-search"></i>Search</button>
                    </div>
                </form>

                @if(isset($selectedDoctor))
                <div class="mt-4 card border-0 shadow-sm">

                    {{-- العنوان الثابت --}}
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
                        <h5 class="mb-0">Weekly Schedule for Dr. {{ $selectedDoctor->name }}</h5>
                    </div>

                    <div class="card-body p-3">

                        {{-- ✅ أزرار التنقل والتاريخ (خارج الجدول والـ scroll) --}}
                        <div class="d-flex justify-content-between align-items-center bg-light p-3 border rounded mb-3 shadow-sm">
                            <button type="button" onclick="changeWeek(-1)" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-chevron-left"></i> Previous Week
                            </button>

                            <div class="fw-semibold text-dark text-center w-100" style="font-weight: bold;">
                                Week:
                                <span>{{ $startOfWeek->format('d/m/Y') }}</span>
                                –
                                <span>{{ $endOfWeek->format('d/m/Y') }}</span>

                                @if ($offset === 0)
                                    <div class="mt-1 text-success" style="font-size: 14px;">
                                        Current Week
                                    </div>
                                @endif
                            </div>

                            <button type="button" onclick="changeWeek(1)" class="btn btn-outline-primary btn-sm">
                                Next Week <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        {{-- ✅ جدول المواعيد مع scroll --}}
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle mb-0" style="min-width: 1000px; font-size: 14px;">
                                @php
                                    $startTime = \Carbon\Carbon::parse($selectedDoctor->work_start_time);
                                    $endTime = \Carbon\Carbon::parse($selectedDoctor->work_end_time);
                                    $timeSlots = [];

                                    while ($startTime <= $endTime) {
                                        $timeSlots[] = $startTime->format('H:i:s');
                                        $startTime->addMinutes(30);
                                    }

                                    $workingDays = is_string($selectedDoctor->working_days)
                                        ? json_decode($selectedDoctor->working_days)
                                        : $selectedDoctor->working_days;

                                    $appointmentsGrouped = $appointments->groupBy(function($a) {
                                        return \Carbon\Carbon::parse($a->appointment_date)->format('l') . '-' . $a->appointment_time;
                                    });
                                @endphp

                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width: 110px;">Day / Time</th>
                                        @foreach ($timeSlots as $slot)
                                            <th style="min-width: 70px;">{{ \Carbon\Carbon::parse($slot)->format('H:i') }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($workingDays as $day)
                                        <tr>
                                            <td class="fw-bold bg-light text-dark">{{ $day }}</td>

                                            @foreach ($timeSlots as $slot)
                                                @php
                                                    $key = $day . '-' . $slot;
                                                @endphp
                                                <td>
                                                    @if(isset($appointmentsGrouped[$key]))
                                                        <span class="text-success" style="font-size: 22px;">&#10004;</span>
                                                    @else
                                                        <span class="text-muted" style="font-size: 16px;">–</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
    <script>
        $('#clinic_id').on('change', function () {
            var clinicId = $(this).val();

            // إخفاء خيار "Select Clinic"
            $(this).find('option:first').hide();

            if (clinicId) {
                // جلب التخصصات من العيادة
                $.ajax({
                    url: '/get-specialties-by-clinic/' + clinicId,
                    type: 'GET',
                    success: function (data) {
                        let specialtySelect = $('#specialty_id');
                        specialtySelect.empty().append('<option value="" disabled selected hidden>Select Specialty</option>');

                        let doctorSelect = $('#doctor_id');
                        doctorSelect.empty().append('<option value="" disabled selected hidden>Select Doctor</option>');

                        $.each(data, function (key, specialty) {
                            specialtySelect.append('<option value="' + specialty.id + '">' + specialty.name + '</option>');
                        });
                    }
                });
            }
        });

        $('#specialty_id').on('change', function () {
            var specialtyId = $(this).val();
            var clinicId = $('#clinic_id').val(); // مهم جداً

            if (specialtyId && clinicId) {
                $.ajax({
                    url: '/get-doctors-by-clinic-and-specialty',
                    type: 'GET',
                    data: {
                        clinic_id: clinicId,
                        specialty_id: specialtyId
                    },
                    success: function (data) {
                        let doctorSelect = $('#doctor_id');
                        doctorSelect.empty().append('<option value="" disabled selected hidden>Select Doctor</option>');

                        $.each(data, function (key, doctor) {
                            doctorSelect.append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                        });
                    }
                });
            }
        });

        $('#doctor_id').on('change', function () {
            // إخفاء خيار "Select Doctor"
            $(this).find('option:first').hide();
        });

        $(document).ready(function () {
            const selectedClinicId = $('#clinic_id').val();
            const selectedSpecialtyId = '{{ $specialty_id ?? '' }}';
            const selectedDoctorId = '{{ $doctor_id ?? '' }}';

            if (selectedClinicId) {
                // جلب التخصصات بناءً على العيادة
                $.ajax({
                    url: '/get-specialties-by-clinic/' + selectedClinicId,
                    type: 'GET',
                    success: function (data) {
                        let specialtySelect = $('#specialty_id');
                        specialtySelect.empty().append('<option value="" disabled hidden>Select Specialty</option>');

                        $.each(data, function (key, specialty) {
                            let selected = (specialty.id == selectedSpecialtyId) ? 'selected' : '';
                            specialtySelect.append('<option value="' + specialty.id + '" ' + selected + '>' + specialty.name + '</option>');
                        });

                        // إذا كان يوجد تخصص محدد مسبقًا، جلب الأطباء
                        if (selectedSpecialtyId) {
                            $.ajax({
                                url: '/get-doctors-by-clinic-and-specialty',
                                type: 'GET',
                                data: {
                                    clinic_id: selectedClinicId,
                                    specialty_id: selectedSpecialtyId
                                },
                                success: function (doctors) {
                                    let doctorSelect = $('#doctor_id');
                                    doctorSelect.empty().append('<option value="" disabled hidden>Select Doctor</option>');

                                    $.each(doctors, function (key, doctor) {
                                        let selected = (doctor.id == selectedDoctorId) ? 'selected' : '';
                                        doctorSelect.append('<option value="' + doctor.id + '" ' + selected + '>' + doctor.name + '</option>');
                                    });
                                }
                            });
                        }
                    }
                });
            }
        });

        function changeWeek(direction) {
            event.preventDefault();
            let offsetField = document.getElementById('week_offset');
            let currentOffset = parseInt(offsetField.value);
            offsetField.value = currentOffset + direction;
            document.getElementById('doctor-schedule-form').submit();
        }
    </script>
@endsection
