@extends('Backend.employees.nurses.master')

@section('title', 'Vital Signs Details')

@section('content')

<style>
    .vs-header-card {
        background: linear-gradient(135deg, #00A8FF, #0087cc);
        color: #fff;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .vs-header-card h4 {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }
    .vs-header-details {
        font-size: 14px;
        margin-top: 5px;
        line-height: 1.6rem;
    }

    .vs-card {
        background: #fff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        border-left: 6px solid #00A8FF;
        margin-bottom: 30px;
    }
    .vs-title {
        font-weight: 700;
        font-size: 20px;
        color: #00A8FF;
        border-bottom: 2px solid #e5e5e5;
        padding-bottom: 8px;
        margin-bottom: 25px;
    }
    .vs-box {
        background: #fafafa;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 18px;
        text-align: center;
        border: 1px solid #e6e6e6;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        transition: 0.3s ease-in-out;
    }
    .vs-box:hover {
        transform: translateY(-5px);
    }
    .vs-box h6 {
        font-size: 15px;
        font-weight: 700;
        margin-top: 8px;
        margin-bottom: 8px;
        color: #333;
    }
    .vs-box p {
        font-size: 21px;
        font-weight: 700;
        color: #00A8FF;
        margin: 0;
    }
    .icon {
        font-size: 30px;
        color: #00A8FF;
    }

    .notes-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #00A8FF;
        display: flex;
        align-items: center;
    }
    .notes-title i {
        margin-right: 8px;
        font-size: 22px;
        color: #00A8FF;
    }
</style>


<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Patient Vital Signs</h4>
            </div>
            <div class="col-lg-10 offset-lg-1">
                <div class="vs-header-card">
                    <div class="vs-header-details">
                        Patient: <strong>{{ $vitalSigns->appointment->patient->user->name ?? 'N/A' }}</strong><br>
                        Appointment Date: <strong>{{ \Carbon\Carbon::parse($vitalSigns->appointment->date)->format('d M Y') }}</strong><br>
                        Appointment Time: <strong>{{ \Carbon\Carbon::parse($vitalSigns->appointment->time)->format('h:i A') }}</strong><br>
                        Nurse: <strong>{{ $vitalSigns->nurse->user->name ?? 'N/A' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="vs-card">
                    <div class="d-flex justify-content-between align-items-center vs-title">
                        <span>Vital Signs Overview</span>

                        <a href="{{ route('nurse.edit_vital_signs', $vitalSigns->id) }}"
                           class="btn btn-sm btn-primary rounded-pill px-3" style="font-weight:600;">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>

                    <div class="row text-center">

                        @php
                            $fields = [
                                ['icon'=>'fa-heartbeat','label'=>'Blood Pressure','value'=>$vitalSigns->blood_pressure ?? '-'],
                                ['icon'=>'fa-heart','label'=>'Heart Rate','value'=>($vitalSigns->heart_rate ?? '-') . ' bpm'],
                                ['icon'=>'fa-thermometer-half','label'=>'Temperature','value'=>($vitalSigns->temperature ?? '-') . ' °C'],
                                ['icon'=>'fa-lungs','label'=>'Oxygen Saturation','value'=>($vitalSigns->oxygen_saturation ?? '-') . ' %'],
                                ['icon'=>'fa-tint','label'=>'Blood Sugar','value'=>($vitalSigns->blood_sugar ?? '-') . ' mg/dL'],
                            ];
                        @endphp

                        @foreach ($fields as $item)
                            <div class="col-md-4">
                                <div class="vs-box">
                                    <i class="fas {{ $item['icon'] }} icon"></i>
                                    <h6>{{ $item['label'] }}</h6>
                                    <p>{{ $item['value'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($vitalSigns->notes)
                        <div class="mt-4">
                            <div class="notes-box p-3">
                                <h6 class="notes-title"><i class="fas fa-sticky-note"></i> Notes</h6>
                                <p class="notes-text">{{ $vitalSigns->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1 text-right">
                <a href="{{ route('nurse.view_appointments') }}" class="btn btn-primary rounded-pill px-4 py-2" style="font-weight: bold;">
                    <i class="fas fa-arrow-left mr-1"></i>Back
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
