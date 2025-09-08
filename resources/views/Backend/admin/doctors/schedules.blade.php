@extends('Backend.admin.master')

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
                            <label><i class="fas fa-stethoscope text-primary"></i> Department</label>
                            <select class="form-control" name="department_id" id="department_id" required>
                                <option value="" disabled {{ !isset($department_id) ? 'selected' : '' }} hidden>Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ (isset($department_id) && $department_id == $department->id) ? 'selected' : '' }}>
                                        {{ $department->name }}
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
                                        {{ $doctor->employee->user->name }}
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
                        <h5 class="mb-0">Weekly Schedule for Dr. {{ $selectedDoctor->employee->user->name }}</h5>
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
                                    $startTime = \Carbon\Carbon::parse($selectedDoctor->employee->work_start_time);
                                    $endTime = \Carbon\Carbon::parse($selectedDoctor->employee->work_end_time);
                                    $timeSlots = [];

                                    while ($startTime <= $endTime) {
                                        $timeSlots[] = $startTime->format('H:i:s');
                                        $startTime->addMinutes(30);
                                    }

                                    $workingDays = is_string($selectedDoctor->employee->working_days)
                                        ? json_decode($selectedDoctor->employee->working_days)
                                        : $selectedDoctor->employee->working_days;

                                    $appointmentsGrouped = $appointments->groupBy(function($a) {
                                        return \Carbon\Carbon::parse($a->date)->format('l') . '-' . $a->time;
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
        // عند تغيير العيادة: نفرّغ ونُعطّل التابعين، ثم نحمّل الأقسام
        $('#clinic_id').on('change', function () {
            var clinicId = $(this).val();

            // إخفاء خيار "Select Clinic"
            $(this).find('option:first').hide();

            let departmentSelect = $('#department_id');
            let doctorSelect     = $('#doctor_id');

            // صفّر وعطّل التابعين
            departmentSelect.prop('disabled', true).empty()
                .append('<option value="" disabled selected hidden>Select Department</option>');
            doctorSelect.prop('disabled', true).empty()
                .append('<option value="" disabled selected hidden>Select Doctor</option>');

            if (clinicId) {
                $.ajax({
                    url: '/admin/get-departments-by-clinic/' + clinicId,
                    type: 'GET',
                    success: function (data) {
                        // عبّي الأقسام وفعّل القائمة
                        $.each(data, function (key, department) {
                            departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
                        });
                        departmentSelect.prop('disabled', false);
                    }
                });
            }
        });

        // عند تغيير التخصّص: نفرّغ ونُعطّل الأطباء، ثم نحمّلهم حسب (العيادة + التخصص)
        $('#department_id').on('change', function () {
            var departmentId = $(this).val();
            var clinicId     = $('#clinic_id').val();

            let doctorSelect = $('#doctor_id');
            doctorSelect.prop('disabled', true).empty()
                .append('<option value="" disabled selected hidden>Select Doctor</option>');

            if (departmentId && clinicId) {
                $.ajax({
                    url: '/admin/get-doctors-by-clinic-and-department',
                    type: 'GET',
                    data: {
                        clinic_id: clinicId,
                        department_id: departmentId
                    },
                    success: function (data) {
                        $.each(data, function (key, doctor) {
                            doctorSelect.append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                        });
                        doctorSelect.prop('disabled', false);
                    }
                });
            }
        });

        // إخفاء خيار "Select Doctor" عند الاختيار
        $('#doctor_id').on('change', function () {
            $(this).find('option:first').hide();
        });

        // تهيئة الصفحة: عطّل القوائم التابعة إذا لا يوجد عيادة محددة
        $(document).ready(function () {
            const selectedClinicId     = $('#clinic_id').val();
            const selectedDepartmentId = '{{ $department_id ?? '' }}';
            const selectedDoctorId     = '{{ $doctor_id ?? '' }}';

            if (!selectedClinicId) {
                $('#department_id').prop('disabled', true).empty()
                    .append('<option value="" disabled selected hidden>Select Department</option>');
                $('#doctor_id').prop('disabled', true).empty()
                    .append('<option value="" disabled selected hidden>Select Doctor</option>');
                return;
            }

            // في حالة التعديل: حمّل الأقسام للعيادة المحددة ثم عيّن التخصص المختار
            $.ajax({
                url: '/admin/get-departments-by-clinic/' + selectedClinicId,
                type: 'GET',
                success: function (data) {
                    let departmentSelect = $('#department_id');
                    departmentSelect.empty().append('<option value="" disabled hidden>Select Department</option>');

                    $.each(data, function (key, department) {
                        let selected = (department.id == selectedDepartmentId) ? 'selected' : '';
                        departmentSelect.append('<option value="' + department.id + '" ' + selected + '>' + department.name + '</option>');
                    });
                    departmentSelect.prop('disabled', false);

                    // إذا كان يوجد تخصص محدد مسبقًا، حمّل الأطباء واضبط المختار
                    if (selectedDepartmentId) {
                        $.ajax({
                            url: '/admin/get-doctors-by-clinic-and-department',
                            type: 'GET',
                            data: {
                                clinic_id: selectedClinicId,
                                department_id: selectedDepartmentId
                            },
                            success: function (doctors) {
                                let doctorSelect = $('#doctor_id');
                                doctorSelect.empty().append('<option value="" disabled hidden>Select Doctor</option>');

                                $.each(doctors, function (key, doctor) {
                                    let selected = (doctor.id == selectedDoctorId) ? 'selected' : '';
                                    doctorSelect.append('<option value="' + doctor.id + '" ' + selected + '>' + doctor.name + '</option>');
                                });
                                doctorSelect.prop('disabled', false);
                            }
                        });
                    } else {
                        // ما في تخصص محدد مسبقًا: خلّي قائمة الأطباء معطّلة
                        $('#doctor_id').prop('disabled', true).empty()
                            .append('<option value="" disabled selected hidden>Select Doctor</option>');
                    }
                }
            });
        });

        function changeWeek(direction) {
            // تأكد إنهم مش disabled عشان يروحوا مع POST
            $('#department_id, #doctor_id').prop('disabled', false);

            var form        = document.getElementById('doctor-schedule-form');
            var offsetField = document.getElementById('week_offset');

            // لو (offset) مش موجود لأي سبب، أنشئه
            if (!offsetField) {
                offsetField       = document.createElement('input');
                offsetField.type  = 'hidden';
                offsetField.name  = 'offset';
                offsetField.id    = 'week_offset';
                offsetField.value = '0';
                form.appendChild(offsetField);
            }

            var current = parseInt(offsetField.value || '0', 10);
            offsetField.value = (isNaN(current) ? 0 : current) + Number(direction);

            form.submit();
            }
        </script>
@endsection
