@extends('Backend.master')

@section('title', 'Medication Stock Details')

@section('content')
<style>
    .info-box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .info-box h5 {
        border-bottom: 2px solid #0288d1;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .info-box p {
        font-size: 16px;
        margin-bottom: 12px;
    }

    .info-label {
        font-weight: 600;
        color: #333;
        margin-right: 5px;
    }

    .description-box {
        background-color: #eef6fa;
        border-left: 4px solid #0288d1;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
    }

    .description-box h6 {
        margin-bottom: 10px;
        color: #0288d1;
    }

    .description-box p {
        margin: 0;
        color: #333;
        line-height: 1.6;
    }
</style>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Stock Details</h4>
            </div>
        </div>

        <div class="p-4 shadow card rounded-3">
            <div class="info-box">
                <h5 class="fw-bold text-primary" style="font-size: 18px;">
                    <i class="fas fa-info-circle me-2 text-primary"></i> General Information
                </h5>

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-3">
                                <p><span class="info-label">Clinic Name :</span>{{ $stock->clinic->name ?? '-' }}</p>
                                <p><span class="info-label">Medication Name :</span>{{ $stock->medication->name ?? '-' }}</p>
                                <p><span class="info-label">Batch Number :</span>{{ $stock->batch_number }}</p>

                            </div>

                            <!-- Right Column -->
                            @php
                                use Carbon\Carbon;
                                $expiryDate = Carbon::parse($stock->expiry_date);
                                $today = Carbon::today();
                                $daysRemaining = $today->diffInDays($expiryDate, false);
                            @endphp
                            <div class="col-md-3">
                                <p><span class="info-label">Manufacture Date :</span>{{ $stock->manufacture_date }}</p>
                                <p><span class="info-label">Expiry Date :</span>{{ $stock->expiry_date }}</p>
                                <p>
                                    <span class="info-label">Days Remaining:</span>
                                    @if ($daysRemaining > 0)
                                        <span class="text-success">{{ $daysRemaining }} days left</span>
                                    @else
                                        <span class="text-danger">Expired {{ abs($daysRemaining) }} days ago</span>
                                    @endif
                                </p>
                            </div>


                            @php
                                $purchase_total = floatval($stock->quantity) * floatval($stock->medication->purchase_price);
                                $selling_total = floatval($stock->quantity) * floatval($stock->medication->selling_price);
                            @endphp
                            <div class="col-md-3">
                                <p><span class="info-label">Quantity :</span>{{ $stock->quantity }}</p>
                                <p><span class="info-label">Purchase Price:</span>${{ number_format($stock->medication->purchase_price, 2) }}</p>
                                <p><span class="info-label">Total Purchase Price :</span>${{ number_format($purchase_total , 2) }}</p>
                            </div>

                            <div class="col-md-3">
                                <p><span class="info-label">Selling Price:</span>${{ number_format($stock->medication->selling_price, 2) }}</p>
                                <p><span class="info-label">Total Selling Price :</span>${{ number_format($selling_total , 2) }}</p>
                                <p><span class="info-label">Remaining Quantity :</span></p>
                            </div>

                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="description-box">
                        <h6 style="font-size: 18px;"><i class="fas fa-align-left me-2"></i> Description</h6>
                        <p style="font-size: 16px;">{{ $stock->description ?: 'No description provided.' }}</p>
                    </div>

                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <a href="{{ Route('view_stocks') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
