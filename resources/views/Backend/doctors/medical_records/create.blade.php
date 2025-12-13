@extends('Backend.doctors.master')

@section('title', 'Add Medical Record')

@section('content')
    <style>
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .card-box {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            background: #fff;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-rounded {
            border-radius: 25px;
            padding: 8px 25px;
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
            <div class="row mb-3">
                <div class="col-sm-12">
                    <h4 class="page-title">
                        <i class="fa fa-notes-medical text-primary me-2"></i> Add Medical Record
                    </h4>
                </div>
            </div>

            <div class="card-box">
                <form action="{{ route('doctor.medical_records.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Select Appointment --}}
                    <div class="form-group mb-3">
                        <label class="form-label"><i class="fa fa-calendar-check text-primary me-2"></i> Select
                            Appointment</label>
                        <select name="appointment_id" id="appointment_id" class="form-control" required>
                            <option value="">-- Choose Appointment --</option>
                            @foreach ($appointments as $appointment)
                                <option value="{{ $appointment->id }}" data-patient="{{ $appointment->patient->id }}">
                                    {{ $appointment->patient->user->name }} —
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i A') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="patient_id" id="patient_id" value="">

                    {{-- Diagnosis --}}
                    <div class="form-group mb-3">
                        <label><i class="fas fa-stethoscope text-primary me-2"></i> Diagnosis</label>
                        <select name="diagnosis" id="diagnosis" class="form-control" required>
                            <option value="" disabled selected hidden>-- Select Diagnosis --</option>

                            <option value="General Checkup">General Checkup</option>
                            <option value="Follow-up Visit">Follow-up Visit</option>
                            <option value="Chronic Disease Follow-up">Chronic Disease Follow-up</option>
                            <option value="Acute Illness Evaluation">Acute Illness Evaluation</option>

                            <option value="Injury / Trauma">Injury / Trauma</option>

                            <option value="Pediatric Consultation">Pediatric Consultation</option>

                            <option value="Gynecology Consultation">Gynecology Consultation</option>
                            <option value="Pregnancy Follow-up">Pregnancy Follow-up</option>

                            <option value="Ophthalmology Consultation">Ophthalmology Consultation</option>

                            <option value="ENT Consultation">ENT Consultation</option>

                            <option value="Dental Treatment">Dental Treatment</option>

                            <option value="Dermatology Consultation">Dermatology Consultation</option>

                            <option value="Cardiology Consultation">Cardiology Consultation</option>

                            <option value="Orthopedic Consultation">Orthopedic Consultation</option>

                            <option value="Neurology Consultation">Neurology Consultation</option>

                            <option value="Psychiatry Consultation">Psychiatry Consultation</option>

                            <option value="Nephrology/Urology Consultation">Nephrology/Urology Consultation</option>

                            <option value="Oncology Consultation">Oncology Consultation</option>

                            <option value="Emergency Visit">Emergency Visit</option>

                            <option value="Family Medicine Consultation">Family Medicine Consultation</option>

                            <option value="Surgical Evaluation">Surgical Evaluation</option>

                            <option value="Other">Other</option>
                        </select>
                    </div>


                    <!-- حقل إضافي يظهر فقط إذا اختار Other -->
                    <div class="form-group mb-3" id="other_diagnosis_group" style="display:none;">
                        <label><i class="fas fa-stethoscope text-primary me-2"></i> Specify Other Diagnosis</label>
                        <input type="text" name="other_diagnosis" class="form-control" placeholder="Enter diagnosis...">
                    </div>

                    {{-- Treatment --}}
                    <div class="form-group mb-3">
                        <label class="form-label"><i class="fa fa-pills text-primary me-2"></i> Treatment</label>
                        <input type="text" name="treatment" class="form-control" value="{{ old('treatment') }}" required>
                    </div>

                    {{-- Prescriptions --}}
                    <div class="form-group mb-3">
                        <label class="form-label"><i class="fa fa-prescription-bottle-alt text-primary me-2"></i>
                            Prescriptions</label>
                        <textarea name="prescriptions" class="form-control" rows="3" placeholder="Enter prescription details..." required>{{ old('prescriptions') }}</textarea>
                    </div>

                    {{-- Attachments --}}
                    <div class="form-group mb-3">
                        <label class="form-label"><i class="fa fa-paperclip text-primary me-2"></i> Attachments
                            (optional)</label>
                        <input type="file" name="attachmentss[]" class="form-control" multiple>
                    </div>

                    {{-- Notes --}}
                    <div class="form-group mb-4">
                        <label class="form-label"><i class="fa fa-file-alt text-primary me-2"></i> Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ url()->previous() }}" class="btn back-btn">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <button type="submit" class="btn back-btn"
                            style="background-color: #03A9F4; border-color: #03A9F4;">
                            <i class="fa fa-save me-1"></i> Save Record
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.getElementById('appointment_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var patientId = selectedOption.getAttribute('data-patient');
            document.getElementById('patient_id').value = patientId || '';
        });


        // إذا اختار الدكتور التشخيص شئ آخر يظهر لي حقل كتابة لأكتب التشخيص المناسب
        document.getElementById('diagnosis').addEventListener('change', function () {
            let otherField = document.getElementById('other_diagnosis_group');

            if (this.value === 'Other') {
                otherField.style.display = 'block';
            } else {
                otherField.style.display = 'none';
                document.querySelector('input[name="other_diagnosis"]').value = "";
            }
        });
    </script>

@endsection
