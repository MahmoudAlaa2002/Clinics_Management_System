@extends('Backend.admin.master')

@section('title', 'Medication Details')

@section('content')

<div class="page-wrapper">
    <div class="content">
        <div class="mb-4 row">
            <div class="col-sm-12">
                <h4 class="page-title">Medication Details</h4>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- بيانات الدواء -->
            <div class="col-lg-7 col-md-8 col-sm-12">
                <div class="mb-4 shadow-sm card rounded-3">
                    <!-- ✅ عنوان عام باللون الأزرق -->
                    <div class="px-3 py-2 text-white card-header bg-primary" style="font-size: 15px;">
                        <i class="fas fa-info-circle me-2 text-white"></i>
                        <span class="fw-semibold" style="font-weight: bold;">General Information</span>
                    </div>

                    <!-- ✅ جدول البيانات -->
                    <table class="table mb-0 table-borderless">
                        <tr>
                            <th style="width: 200px;">
                                <i class="fas fa-capsules me-2 text-primary"></i>
                                <span class="fw-semibold">Name:</span>
                            </th>
                            <td class="ps-4">{{ $medication->name }}</td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-vial me-2 text-primary"></i>
                                <span class="fw-semibold">Dosage Form:</span>
                            </th>
                            <td class="ps-4">{{ $medication->dosageForm->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-balance-scale me-2 text-primary"></i>
                                <span class="fw-semibold">Strength:</span>
                            </th>
                            <td class="ps-4">{{ $medication->strength }}</td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-dollar-sign me-2 text-primary"></i>
                                <span class="fw-semibold">Purchase Price:</span>
                            </th>
                            <td class="ps-4">${{ $medication->purchase_price }}</td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-dollar-sign me-2 text-primary"></i>
                                <span class="fw-semibold">Selling Price:</span>
                            </th>
                            <td class="ps-4">${{ $medication->selling_price }}</td>
                        </tr>
                    </table>
                </div>

                <!-- وصف -->
                <div class="shadow-sm card rounded-3">
                    <div class="px-3 py-2 text-white card-header bg-primary" style="font-size: 15px;">
                        <i class="fas fa-align-left me-2"></i>
                        <span class="fw-semibold" style="font-weight: bold;">Description</span>
                    </div>
                    <div class="card-body bg-light">
                        <p class="mb-0" style="font-size: 15px; color: #333;">
                            {{ $medication->description ?: 'No notes at the moment' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- صورة الدواء -->
            <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top: -20px;">
                <div class="text-center rounded-3 ms-4">
                    @if($medication->image)
                        <img src="{{ asset($medication->image) }}"
                            alt="Medication Image"
                            class="mx-auto mt-3 mb-3 rounded img-fluid"
                            style="width: 100%; max-width: 300px; height: 280px; ">
                    @else
                        <img src="{{ asset('assets/img/medication.png') }}"
                            alt="No Image"
                            class="mx-auto mt-3 mb-3 rounded img-fluid"
                            style="width: 100%; max-width: 300px; height: 300px;">
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4 row" style="margin-right: 60px;">
            <div class="col-lg-6 offset-lg-2 d-flex justify-content-end">
                <a href="{{ route('view_medications') }}" class="px-4 btn btn-primary rounded-pill fw-bold" style="font-weight: bold;">
                    Back
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
