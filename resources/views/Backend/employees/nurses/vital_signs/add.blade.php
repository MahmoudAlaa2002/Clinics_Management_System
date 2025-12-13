@extends('Backend.employees.nurses.master')

@section('title' , 'Add Vital Signs')

@section('content')
<style>
    .col-sm-6 { margin-bottom: 30px; }
    input[type="number"], input[type="text"] { direction: ltr; text-align: left; }
    .card { border: 1px solid #ddd !important; border-radius: 8px !important; box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important; overflow: hidden !important; }
    .card-header { background-color: #00A8FF !important; color: #fff !important; font-weight: 600 !important; padding: 12px 15px !important; font-size: 16px !important; border-bottom: 1px solid #ddd !important; }
    .card-body { background-color: #fff; padding: 20px; }
</style>

<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom:30px;">Add Vital Signs</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <form method="POST" action="{{ route('nurse.store_vital_signs') }}">
                    @csrf
                    <input type="hidden" id="appointment_id" name="appointment_id" value="{{ $appointment->id }}">

                    <div class="card">
                        <div class="card-header">Vital Signs Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Blood Pressure (mmHg) </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="blood_pressure" name="blood_pressure" placeholder="e.g. 120/80">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Heart Rate (bpm) </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="heart_rate" name="heart_rate" placeholder="e.g. 75">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Temperature (°C) </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-thermometer-half"></i></span>
                                        </div>
                                        <input type="number" step="0.1" class="form-control" id="temperature" name="temperature" placeholder="e.g. 36.7">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Oxygen Saturation (%) </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lungs"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="oxygen_saturation" name="oxygen_saturation" placeholder="e.g. 98">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Blood Sugar (mg/dL) </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tint"></i></span>
                                        </div>
                                        <input type="number" step="0.1" class="form-control" id="blood_sugar" name="blood_sugar" placeholder="e.g. 110">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Write a short notes ...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>


                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform:none !important;">
                            Add Vital Signs
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection



@section('js')
    <script>
        function isValidSelectValue(selectId) {      // هذا الميثود حتى أتجنب خداع الفيكفيار
            let val = $(`#${selectId}`).val();
            return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
        }

        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let appointment_id = $('#appointment_id').val();
                let nurse_id = $('#nurse_id').val();
                let blood_pressure = $('#blood_pressure').val();
                let heart_rate = $('#heart_rate').val();
                let temperature = $('#temperature').val();
                let oxygen_saturation = $('#oxygen_saturation').val();
                let blood_sugar = $('#blood_sugar').val();
                let notes = $('#notes').val().trim();



                let formData = new FormData();
                formData.append('appointment_id', appointment_id);
                formData.append('nurse_id', nurse_id);
                formData.append('blood_pressure', blood_pressure);
                formData.append('heart_rate', heart_rate);
                formData.append('temperature', temperature);
                formData.append('oxygen_saturation', oxygen_saturation);
                formData.append('blood_sugar', blood_sugar);
                formData.append('notes', notes);


                if (blood_pressure === '' && heart_rate === '' && temperature === '' && oxygen_saturation === '' &&blood_sugar === '') {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please enter at least one vital sign',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007BFF',
                        });
                        return;
                }else{
                    $.ajax({
                    method: 'POST',
                    url: "{{ route('nurse.store_vital_signs') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Vital signs have been successfully recorded',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#007BFF',
                            }).then(() => {
                                window.location.href = '/employee/nurse/view/appointments';
                            });
                        }
                    }
                });
            }
            });
        });

    </script>
@endsection
