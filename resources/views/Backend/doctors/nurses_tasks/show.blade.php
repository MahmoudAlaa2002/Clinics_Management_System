@extends('Backend.doctors.master')

@section('title', 'Assign Task to Nurse')

@section('content')

    <style>
        .card {
            border: 1px solid #ddd !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card-header {
            background-color: #00A8FF !important;
            color: #fff !important;
            font-weight: 600;
            padding: 14px 18px;
            font-size: 16px;
        }

        .card-body {
            background-color: #fff;
            padding: 22px;
        }

        .info-item {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .info-item strong {
            color: #333;
            min-width: 110px;
            display: inline-block;
        }

        .divider {
            border-left: 1px dashed #ccc;
            height: 100%;
        }

        textarea {
            resize: none;
        }
    </style>

    <div class="page-wrapper">
        <div class="content">

            {{-- Page Title --}}
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="page-title">Assign Task to Nurse</h4>
                </div>
            </div>

            <form action="{{ route('doctor.assign_task.store') }}" method="POST">
                @csrf

                {{-- Hidden --}}
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">


                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i>
                        Appointment & Nurse Information
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Appointment --}}
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="fas fa-calendar-check me-1"></i> Appointment
                                </h6>

                                <div class="info-item"><strong>ID:</strong> #{{ $appointment->id }}</div>
                                <div class="info-item"><strong>Patient:</strong> {{ $appointment->patient->user->name }}</div>
                                <div class="info-item"><strong>Date:</strong> {{ $appointment->date }}</div>
                                <div class="info-item"><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</div>
                            </div>

                            {{-- Divider --}}
                            <div class="col-md-1 d-none d-md-flex justify-content-center">
                                <div class="divider"></div>
                            </div>

                            {{-- Nurse --}}
                            <div class="col-md-5">
                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="fas fa-user-nurse me-1"></i> Nurse
                                </h6>

                                <div class="info-item"><strong>Name:</strong> {{ $nurse->user->name }}</div>
                                <div class="info-item"><strong>Clinic:</strong> {{ $nurse->clinic->name ?? '—' }}</div>
                                <div class="info-item"><strong>Department:</strong> {{ $nurse->department->name ?? '—' }}</div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-tasks me-1"></i>
                        Task Details
                    </div>

                    <div class="card-body">
                        <label class="fw-bold mb-2">
                            Task Description <span class="text-danger">*</span>
                        </label>
                        <textarea id="task" name="task" class="form-control" rows="5" placeholder="Enter the task that should be performed by the nurse..."></textarea>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-sticky-note me-1"></i>
                        Additional Notes
                    </div>

                    <div class="card-body">
                        <label class="fw-bold mb-2">Notes (Optional)</label>
                        <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Any additional instructions or notes for the nurse..."></textarea>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="text-center m-t-20" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary submit-btn assignTask" style="text-transform: none !important;">
                        Assign Task
                    </button>
                </div>

            </form>
        </div>
    </div>
    
@endsection



@section('js')
<script>
    $('.assignTask').click(function (e) {
        e.preventDefault();

        let form = $(this).closest('form');
        let task = $('#task').val().trim();

        if (task === '') {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter the task description',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#007BFF',
            });
            return;
        }

        let formData = new FormData(form[0]); 

        $.ajax({
            method: 'POST',
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Task assigned successfully to nurse',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#007BFF',
                    }).then(() => {
                        window.history.back();
                    });
                }
            }
        });
    });

</script>
@endsection
