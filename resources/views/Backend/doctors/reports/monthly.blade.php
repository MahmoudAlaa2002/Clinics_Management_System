@extends('Backend.doctors.master')

@section('title', 'Monthly Reports')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="row mb-4 align-items-center">
            <div class="col-md-6 col-12">
                <h4 class="page-title fw-bold">Monthly Reports</h4>
                <p class="text-muted mb-0">Summary of appointments, patients, and income per month.</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="card-box p-3 mb-4 shadow-sm">
            <form action="{{ route('doctor.reports.monthly') }}" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <label class="fw-bold">Select Month</label>
                    <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary fw-bold rounded-pill px-4 mt-3 mt-md-0">
                        <i class="fa fa-search"></i> View Report
                    </button>
                </div>
            </form>
        </div>

        {{-- Stats --}}
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card shadow-sm p-3 border-start border-primary border-4">
                    <h5 class="text-muted mb-1">Appointments</h5>
                    <h3 class="text-primary">{{ $report['appointments'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 border-start border-success border-4">
                    <h5 class="text-muted mb-1">Completed</h5>
                    <h3 class="text-success">{{ $report['completed'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 border-start border-warning border-4">
                    <h5 class="text-muted mb-1">Cancelled</h5>
                    <h3 class="text-warning">{{ $report['cancelled'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 border-start border-info border-4">
                    <h5 class="text-muted mb-1">Earnings</h5>
                    <h3 class="text-info">${{ number_format($report['earnings'] ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h4 class="mb-3">Appointments per Day</h4>
                <canvas id="reportChart"></canvas>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('reportChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chart['labels'] ?? []),
        datasets: [{
            label: 'Appointments',
            data: @json($chart['data'] ?? []),
            backgroundColor: '#03A9F4'
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush
@endsection
