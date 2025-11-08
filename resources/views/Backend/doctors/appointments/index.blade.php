@extends('Backend.doctors.master')

@section('title', 'View Appointments')

@section('content')

    <style>
        .status-badge {
            min-width: 140px;
            display: inline-block;
            text-align: center;
            padding: 4px 12px;
            font-size: 16px;
            border-radius: 50px;
            color: white;
            font-weight: 500;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .status-accepted {
            background-color: #189de4;
        }

        .status-rejected {
            background-color: #f90d25;
        }

        .status-cancelled {
            background-color: #6c757d;
        }

        .status-completed {
            background-color: #14ea6d;
        }
    </style>

    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6 col-12">
                    <h4 class="page-title mb-0">View Appointments</h4>
                </div>
            </div>

            {{-- Filters & Search --}}
            <div class="card-box p-3 mb-4 shadow-sm">
                <form method="GET" action="{{ route('doctor.appointments') }}">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="keyword">Filter</label>
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                placeholder="Search appointments..." value="{{ request('keyword') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold" for="from_date">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold" for="to_date">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-2 text-end mt-3 mt-md-0">
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">
                                <i class="fa fa-search me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 📋 Table --}}
            <div class="card-box shadow-sm p-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Clinic</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if ($appointments->count() > 0)
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            <a href="{{ route('doctor.patients.show', $appointment->patient) }}">
                                                {{ $appointment->patient->user->name }}
                                            </a>
                                        </td>
                                        <td>{{ $appointment->clinic->name }}</td>
                                        <td>{{ $appointment->department->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                                        <td>
                                            <span
                                                class="status-badge
                                                @if ($appointment->status === 'Pending') status-pending
                                                @elseif($appointment->status === 'Accepted') status-accepted
                                                @elseif($appointment->status === 'Rejected') status-rejected
                                                @elseif($appointment->status === 'Cancelled') status-cancelled
                                                @elseif($appointment->status === 'Completed') status-completed @endif">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('doctor.appointment.show', $appointment) }}"
                                                    class="mr-1 btn btn-outline-success btn-sm"><i
                                                        class="fa fa-eye"></i> Details</a>
                                                @if ($appointment->status === 'Pending')
                                                    <form action="{{ route('doctor_confirm_appointment', $appointment) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="mr-1 btn btn-outline-success btn-sm"
                                                            data-bs-toggle="tooltip" title="Accept this Appointment">
                                                            <i class="fa fa-check"></i> Accept
                                                        </button>
                                                    </form>

                                                    {{-- Reject --}}
                                                    <form action="{{ route('doctor_reject_appointment', $appointment) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="mr-1 btn btn-outline-danger btn-sm"
                                                            data-bs-toggle="tooltip" title="Reject this Appointment">
                                                            <i class="fa fa-times"></i> Reject
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($appointment->status === 'Accepted')
                                                    {{-- Cancel --}}
                                                    <form action="{{ route('doctor_cancel_appointment', $appointment) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="mr-1 btn btn-outline-warning btn-sm"
                                                            data-bs-toggle="tooltip" title="Cancel this Appointment">
                                                            <i class="fa fa-ban"></i> Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            @if (request('date') === 'today')
                                                No Appointments today
                                            @else
                                                No appointments found
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $appointments->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form.d-inline').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // منع الإرسال الافتراضي مؤقتًا

                    let action = '';
                    if (form.querySelector('button i.fa-check')) action = 'accept';
                    if (form.querySelector('button i.fa-times')) action = 'reject';
                    if (form.querySelector('button i.fa-ban')) action = 'cancel';

                    if (action) {
                        let confirmTitle = '';
                        let confirmMessage = '';
                        let iconType = 'question';
                        let inputRequired = false;

                        switch (action) {
                            case 'accept':
                                confirmTitle = 'Accept Appointment';
                                confirmMessage =
                                'Are you sure you want to accept this appointment?';
                                iconType = 'success';
                                break;
                            case 'reject':
                                confirmTitle = 'Reject Appointment';
                                confirmMessage =
                                'Are you sure you want to reject this appointment?';
                                iconType = 'error';
                                break;
                            case 'cancel':
                                confirmTitle = 'Cancel Appointment';
                                confirmMessage = 'Please enter the reason for cancellation:';
                                iconType = 'warning';
                                inputRequired = true;
                                break;
                        }

                        Swal.fire({
                            title: confirmTitle,
                            text: confirmMessage,
                            icon: iconType,
                            input: inputRequired ? 'text' : null,
                            inputPlaceholder: inputRequired ? 'Enter reason here...' : '',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                            preConfirm: (inputValue) => {
                                if (inputRequired && !inputValue) {
                                    Swal.showValidationMessage(
                                        'You must enter a reason!');
                                }
                                return inputValue;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (inputRequired) {
                                    // نضيف input hidden للفورم
                                    let input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'note';
                                    input.value = result.value;
                                    form.appendChild(input);
                                }
                                form.submit(); // تنفيذ الفورم
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
