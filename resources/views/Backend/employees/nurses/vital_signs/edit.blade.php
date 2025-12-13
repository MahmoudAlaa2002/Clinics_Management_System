@extends('Backend.employees.nurses.master')

@section('title' , 'Edit Vital Signs')

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
                <h4 class="page-title" style="margin-bottom:30px;">Edit Vital Signs</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <form id="editVitalSignsForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="vital_id" value="{{ $vitalSigns->id }}">

                    <div class="card">
                        <div class="card-header">Vital Signs Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Blood Pressure (mmHg)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        <input type="text" class="form-control" id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure', $vitalSigns->blood_pressure) }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Heart Rate (bpm)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                        <input type="number" class="form-control" id="heart_rate" name="heart_rate" value="{{ old('heart_rate', $vitalSigns->heart_rate) }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Temperature (°C)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-thermometer-half"></i></span>
                                        <input type="number" step="0.1" class="form-control" id="temperature" name="temperature" value="{{ old('temperature', $vitalSigns->temperature) }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Oxygen Saturation (%)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lungs"></i></span>
                                        <input type="number" class="form-control" id="oxygen_saturation" name="oxygen_saturation" value="{{ old('oxygen_saturation', $vitalSigns->oxygen_saturation) }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Blood Sugar (mg/dL)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tint"></i></span>
                                        <input type="number" step="0.1" class="form-control" id="blood_sugar" name="blood_sugar" value="{{ old('blood_sugar', $vitalSigns->blood_sugar) }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <textarea id="notes" name="notes" class="form-control" rows="4">{{ old('notes', $vitalSigns->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 editBtn" style="text-transform:none;">
                            Edit Vital Signs
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
$(document).ready(function () {
    $('.editBtn').click(function (e) {
        e.preventDefault();

        let id = $('#vital_id').val();

        let data = {
            _method: 'PUT',
            blood_pressure: $('#blood_pressure').val(),
            heart_rate: $('#heart_rate').val(),
            temperature: $('#temperature').val(),
            oxygen_saturation: $('#oxygen_saturation').val(),
            blood_sugar: $('#blood_sugar').val(),
            notes: $('#notes').val().trim(),
        };

        $.ajax({
            method: 'POST',
            url: "/employee/nurse/update/vital-signs/" + id,
            data: data,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                if (response.data === 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated Successfully',
                        text: 'Vital signs have been updated.',
                        confirmButtonColor: '#007BFF',
                    }).then(() => {
                        window.location.href = "{{ route('nurse.view_appointments') }}";
                    });
                }
            }
        });

    });
});
</script>
@endsection
