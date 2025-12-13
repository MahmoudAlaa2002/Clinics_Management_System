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
                    <select name="diagnosis" id="diagnosis" class="form-control" required>
                        <option value="" disabled hidden>-- Select Diagnosis --</option>

                        <option value="General Checkup" {{ $medicalRecord->diagnosis == "General Checkup" ? 'selected' : '' }}>General Checkup</option>
                        <option value="Follow-up Visit" {{ $medicalRecord->diagnosis == "Follow-up Visit" ? 'selected' : '' }}>Follow-up Visit</option>
                        <option value="Chronic Disease Follow-up" {{ $medicalRecord->diagnosis == "Chronic Disease Follow-up" ? 'selected' : '' }}>Chronic Disease Follow-up</option>
                        <option value="Acute Illness Evaluation" {{ $medicalRecord->diagnosis == "Acute Illness Evaluation" ? 'selected' : '' }}>Acute Illness Evaluation</option>

                        <option value="Injury / Trauma" {{ $medicalRecord->diagnosis == "Injury / Trauma" ? 'selected' : '' }}>Injury / Trauma</option>

                        <option value="Pediatric Consultation" {{ $medicalRecord->diagnosis == "Pediatric Consultation" ? 'selected' : '' }}>Pediatric Consultation</option>

                        <option value="Gynecology Consultation" {{ $medicalRecord->diagnosis == "Gynecology Consultation" ? 'selected' : '' }}>Gynecology Consultation</option>
                        <option value="Pregnancy Follow-up" {{ $medicalRecord->diagnosis == "Pregnancy Follow-up" ? 'selected' : '' }}>Pregnancy Follow-up</option>

                        <option value="Ophthalmology Consultation" {{ $medicalRecord->diagnosis == "Ophthalmology Consultation" ? 'selected' : '' }}>Ophthalmology Consultation</option>

                        <option value="ENT Consultation" {{ $medicalRecord->diagnosis == "ENT Consultation" ? 'selected' : '' }}>ENT Consultation</option>

                        <option value="Dental Treatment" {{ $medicalRecord->diagnosis == "Dental Treatment" ? 'selected' : '' }}>Dental Treatment</option>

                        <option value="Dermatology Consultation" {{ $medicalRecord->diagnosis == "Dermatology Consultation" ? 'selected' : '' }}>Dermatology Consultation</option>

                        <option value="Cardiology Consultation" {{ $medicalRecord->diagnosis == "Cardiology Consultation" ? 'selected' : '' }}>Cardiology Consultation</option>

                        <option value="Orthopedic Consultation" {{ $medicalRecord->diagnosis == "Orthopedic Consultation" ? 'selected' : '' }}>Orthopedic Consultation</option>

                        <option value="Neurology Consultation" {{ $medicalRecord->diagnosis == "Neurology Consultation" ? 'selected' : '' }}>Neurology Consultation</option>

                        <option value="Psychiatry Consultation" {{ $medicalRecord->diagnosis == "Psychiatry Consultation" ? 'selected' : '' }}>Psychiatry Consultation</option>

                        <option value="Nephrology/Urology Consultation" {{ $medicalRecord->diagnosis == "Nephrology/Urology Consultation" ? 'selected' : '' }}>Nephrology/Urology Consultation</option>

                        <option value="Oncology Consultation" {{ $medicalRecord->diagnosis == "Oncology Consultation" ? 'selected' : '' }}>Oncology Consultation</option>

                        <option value="Emergency Visit" {{ $medicalRecord->diagnosis == "Emergency Visit" ? 'selected' : '' }}>Emergency Visit</option>

                        <option value="Family Medicine Consultation" {{ $medicalRecord->diagnosis == "FamilyMedicine Consultation" ? 'selected' : '' }}>Family Medicine Consultation</option>

                        <option value="Surgical Evaluation" {{ $medicalRecord->diagnosis == "Surgical Evaluation" ? 'selected' : '' }}>Surgical Evaluation</option>

                        <option value="Other" {{ !in_array($medicalRecord->diagnosis, [
                            "General Checkup","Follow-up Visit","Chronic Disease Follow-up","Acute Illness Evaluation",
                            "Injury / Trauma","Pediatric Consultation","Gynecology Consultation","Pregnancy Follow-up",
                            "Ophthalmology Consultation","ENT Consultation","Dental Treatment","Dermatology Consultation",
                            "Cardiology Consultation","Orthopedic Consultation","Neurology Consultation","Psychiatry Consultation",
                            "Nephrology/Urology Consultation","Oncology Consultation","Emergency Visit",
                            "Family Medicine Consultation","Surgical Evaluation"
                        ]) ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="mb-3" id="other_diagnosis_group" style="display: none;">
                    <label class="form-label">Specify Other Diagnosis</label>
                    <input type="text" name="other_diagnosis" class="form-control"
                           value="{{ !in_array($medicalRecord->diagnosis, [
                                "General Checkup","Follow-up Visit","Chronic Disease Follow-up","Acute Illness Evaluation",
                                "Injury / Trauma","Pediatric Consultation","Gynecology Consultation","Pregnancy Follow-up",
                                "Ophthalmology Consultation","ENT Consultation","Dental Treatment","Dermatology Consultation",
                                "Cardiology Consultation","Orthopedic Consultation","Neurology Consultation","Psychiatry Consultation",
                                "Nephrology/Urology Consultation","Oncology Consultation","Emergency Visit",
                                "Family Medicine Consultation","Surgical Evaluation"
                           ]) ? $medicalRecord->diagnosis : '' }}">
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const select = document.getElementById('diagnosis');
                        const group = document.getElementById('other_diagnosis_group');

                        function toggleOther() {
                            if (select.value === 'Other') {
                                group.style.display = 'block';
                            } else {
                                group.style.display = 'none';
                            }
                        }

                        toggleOther();
                        select.addEventListener('change', toggleOther);
                    });
                </script>

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
