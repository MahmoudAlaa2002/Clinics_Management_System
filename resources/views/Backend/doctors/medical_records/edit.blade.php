@extends('Backend.doctors.master')

@section('title', 'Edit Medical Record')

@section('content')
<style>
    body { background: #f6f9fc; }
    .page-wrapper { padding: 30px 15px; }
    .card-custom {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    .card-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(3,169,244,0.15);
    }
    .card-header-custom {
        padding: 15px 20px;
        font-weight: 700;
        color: #fff;
        font-size: 18px;
    }
    .card-body { padding: 20px; }
    .form-label { font-weight: 600; color: #03A9F4; }
    .back-btn {
        background-color: #03A9F4;
        color: white;
        border-radius: 30px;
        padding: 10px 35px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(3,169,244,0.2);
    }
    .back-btn:hover {
        background-color: #0288d1;
        box-shadow: 0 6px 18px rgba(2,136,209,0.3);
        transform: translateY(-2px);
    }
</style>

<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title" style="color:#03A9F4;">Edit Medical Record</h2>
    </div>

    <form action="{{ route('doctor.medical_records.update', $medicalRecord) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-custom">
            <div class="card-header-custom" style="background: linear-gradient(135deg, #ff9800, #ffc107);">
                Medical Record Information
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Treatment</label>
                    <textarea name="treatment" class="form-control" rows="2">{{ old('treatment', $medicalRecord->treatment) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prescriptions</label>
                    <textarea name="prescriptions" class="form-control" rows="2">{{ old('prescriptions', $medicalRecord->prescriptions) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Record Date</label>
                    <input type="date" name="record_date" class="form-control" value="{{ old('record_date', \Carbon\Carbon::parse($medicalRecord->record_date)->format('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $medicalRecord->notes) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Attachments</label>
                    <input type="file" name="attachmentss[]" class="form-control" multiple>

                    @if ($medicalRecord->attachmentss)
                        <small class="text-muted d-block mt-2">Existing files:</small>
                        <ul>
                            @foreach (json_decode($medicalRecord->attachmentss, true) as $file)
                                <li class="d-flex align-items-center">
                                    <a href="{{ Storage::url($file) }}" target="_blank" class="me-2">
                                        {{ basename($file) }}
                                    </a>
                                    <label class="text-danger small mb-0">
                                        <input type="checkbox" name="remove_files[]" value="{{ $file }}"> Remove
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ url()->previous() }}" class="btn back-btn"><i class="fa fa-arrow-left me-1"></i> Back</a>
            <button type="submit" class="btn back-btn" style="background-color: #03A9F4; border-color: #03A9F4;">
                <i class="fa fa-save me-1"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
