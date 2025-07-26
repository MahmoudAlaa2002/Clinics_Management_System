@extends('Backend.master')

@section('title' , 'Edit Patient Invoice')

@section('content')

    <style>
        .col-sm-6 {
            margin-bottom: 20px;
        }

        input[type="date"] {
            direction: ltr;
            text-align: left;
        }
    </style>


    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Patient Invoice</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_invoice' , ['id' => $patientInvoice->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Appointment ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="appointment_id" name="appointment_id" value="{{ $patientInvoice->appointment_id }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select class="form-control" id="patient_id" name="patient_id" required>
                                            <option value="" disabled hidden>Select Patient</option>
                                            @php
                                                $selectedPatientId = old('patient_id', $patientInvoice->patient_id ?? null);
                                            @endphp
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ $patient->id == $selectedPatientId ? 'selected' : '' }}>
                                                    {{ $patient->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Discount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input class="form-control" type="number" id="discount" name="discount" value="{{ $patientInvoice->discount }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="display-block">Payment Status <span class="text-danger">*</span></label>

                                    @php
                                        $status = old('status', $patientInvoice->status ?? 'unpaid');
                                    @endphp

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_paid" value="paid" {{ $status === 'paid' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_paid">paid</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_unpaid" value="unpaid" {{ $status === 'unpaid' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_unpaid">unpaid</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_partial" value="partial" {{ $status === 'partial' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_partial">partial</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Notes </label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" cols="30">{{ $patientInvoice->notes }}</textarea>
                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Patient Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        function isValidSelectValue(selectId) {
            let val = $(`#${selectId}`).val();
            return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
        }

        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let appointment_id = $('#appointment_id').val().trim();
                let patient_id = $('#patient_id').val();
                let discount = $('#discount').val().trim();
                let status = $('input[name="status"]:checked').val();
                let notes = $('#notes').val().trim();

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('appointment_id', appointment_id);
                formData.append('patient_id', patient_id);
                formData.append('discount', discount);
                formData.append('status', status);
                formData.append('notes', notes);

                if (appointment_id === '' || !isValidSelectValue('patient_id') || discount === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: "{{ route('update_invoice', ['id' => $patientInvoice->id]) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data == 0) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'The Patient Invoice has already been booked',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Patient Invoice has been updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/view/invoices';
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
