@extends('Backend.doctors.master')

@section('title', 'Medical Records')

@section('content')

    <style>
        .record-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 18px;
            border-left: 5px solid #03A9F4;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .record-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.10);
        }

        .record-title {
            font-size: 18px;
            font-weight: 600;
            color: #03A9F4;
        }

        .info-line {
            font-size: 15px;
            margin-bottom: 6px;
        }

        .back-btn {
            background-color: #03A9F4;
            color: white;
            border-radius: 30px;
            padding: 10px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(3, 169, 244, 0.2);
        }

        .back-btn:hover {
            background-color: #0288d1;
            box-shadow: 0 6px 18px rgba(2, 136, 209, 0.3);
            transform: translateY(-2px);
        }
    </style>

    <div class="page-wrapper">
        <div class="content">

            {{-- Page Header --}}
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 class="page-title">Medical Records</h4>
                    <p class="text-muted">
                        Full medical history for
                        <strong>{{ $patient->user->name }}</strong>
                    </p>
                </div>
            </div>

            {{-- Loop Records --}}
            @forelse($records as $record)
                <div class="record-card">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="record-title">
                            Record Date: {{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}
                        </div>
                    </div>

                    <hr>

                    {{-- Visit Info --}}
                    <p class="info-line"><strong>Doctor:</strong>
                        Dr. {{ $record->doctor->employee->user->name }}
                    </p>

                    <p class="info-line"><strong>Clinic Name:</strong>
                        <a href="{{ route('doctor.clinic.show', $record->appointment->clinic) }}">
                            {{ $record->appointment->clinic->name }}
                        </a>
                    </p>

                    <p class="info-line"><strong>Diagnosis:</strong>
                        {{ $record->diagnosis ?? 'Not recorded' }}
                    </p>

                    <p class="info-line"><strong>Treatment:</strong>
                        {{ $record->treatment ?? 'No treatment added' }}
                    </p>

                    <p class="info-line"><strong>Notes:</strong>
                        {{ $record->notes ?? 'No notes added' }}
                    </p>

                    {{-- Prescriptions --}}
                    @if (!empty($record->prescriptions))
                        <h6 class="mt-3 text-primary"><i class="fas fa-pills me-1"></i> Prescriptions</h6>
                        <div class="alert alert-info p-2">
                            {!! nl2br(e($record->prescriptions)) !!}
                        </div>
                    @endif

                    {{-- Attachments --}}
                    @if ($record->attachmentss)
                        <h6 class="mt-3 text-primary">
                            <i class="fas fa-paperclip me-1"></i> Attachments
                        </h6>

                        @foreach (json_decode($record->attachmentss, true) as $file)
                            <a href="{{ Storage::url($file) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2"
                                download>
                                <i class="fa fa-download me-1"></i> {{ basename($file) }}
                            </a>
                            <br>
                        @endforeach
                    @endif
                </div>
            @empty
                <p class="text-muted">No medical records found for this patient.</p>
            @endforelse

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ url()->previous() }}" class="btn back-btn">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

@endsection
