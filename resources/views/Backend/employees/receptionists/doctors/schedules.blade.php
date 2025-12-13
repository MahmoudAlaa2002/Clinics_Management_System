@extends('Backend.employees.receptionists.master')

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
                <form id="doctor-schedule-form" method="POST" action="{{ route('receptionist.search_doctor_schedule') }}">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-md-4">
                            <label>Clinic <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hospital text-primary"></i></span>
                                </div>
                                <input type="text" class="form-control" value="{{ $clinic->name }}" readonly>
                                <input type="hidden" id="clinic_id" name="clinic_id" value="{{ $clinic->id }}">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <label>Department <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-stethoscope text-primary"></i></span>
                                </div>
                                <input type="text" class="form-control" value="{{ $department->name }}" readonly>
                                <input type="hidden" id="department_id" name="department_id" value="{{ $department->id }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label>Doctor <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user-md text-primary"></i>
                                    </span>
                                </div>

                                <select class="form-control" name="doctor_id" id="doctor_id" required>
                                    <option value="" disabled {{ !isset($doctor_id) ? 'selected' : '' }} hidden>Select Doctor</option>

                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                            {{ (isset($doctor_id) && $doctor_id == $doctor->id) ? 'selected' : '' }}>
                                            {{ $doctor->employee->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="offset" id="week_offset" value="{{ $offset ?? 0 }}">

                    <div class="text-right" style="margin-top: 30px;">
                        <button type="submit" class="px-4 btn btn-success"><i class="mr-2 fa fa-search"></i>Search</button>
                    </div>
                </form>

                @if(isset($selectedDoctor))
                <div class="mt-4 border-0 shadow-sm card">

                    <div class="text-white card-header bg-primary d-flex justify-content-between align-items-center rounded-top">
                        <h5 class="mb-0">Weekly Schedule for Dr. {{ $selectedDoctor->employee->user->name }}</h5>
                    </div>

                    <div class="p-3 card-body">

                        <div class="p-3 mb-3 border rounded shadow-sm d-flex justify-content-between align-items-center bg-light">
                            <button type="button" onclick="changeWeek(-1)" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-chevron-left"></i> Previous Week
                            </button>

                            <div class="text-center fw-semibold text-dark w-100" style="font-weight: bold;">
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

                        <div class="table-responsive">
                            <table class="table mb-0 text-center align-middle table-bordered" style="min-width: 1000px; font-size: 14px;">
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
    function changeWeek(direction) {
        const form = document.getElementById('doctor-schedule-form');
        let offsetField = document.getElementById('week_offset');

        if (!offsetField) {
            offsetField = document.createElement('input');
            offsetField.type = 'hidden';
            offsetField.name = 'offset';
            offsetField.id   = 'week_offset';
            offsetField.value = '0';
            form.appendChild(offsetField);
        }

        const current = parseInt(offsetField.value || '0', 10);
        offsetField.value = current + Number(direction);

        form.submit();
    }
</script>

@endsection
