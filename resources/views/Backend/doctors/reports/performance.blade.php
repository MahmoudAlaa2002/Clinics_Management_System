@extends('Backend.doctors.master')

@section('title', 'Performance Charts')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h2 class="mb-4">Performance Charts</h2>

        <div class="row mb-4">
            <div class="col-md-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Appointments Overview (Last 6 Months)</h5>
                        <div style="height:300px;">
                            <canvas id="appointmentsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Completed vs Cancelled</h5>
                        <div style="height:300px;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Appointments chart
    const ctxAppointments = document.getElementById('appointmentsChart').getContext('2d');
    new Chart(ctxAppointments, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Appointments',
                data: @json($appointmentsPerMonth),
                borderColor: 'rgba(3, 169, 244, 1)',
                backgroundColor: 'rgba(3, 169, 244, 0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true },
            }
        }
    });

    // Completed vs Cancelled chart
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Completed',
                    data: @json($completedPerMonth),
                    backgroundColor: 'rgba(40, 167, 69, 0.7)'
                },
                {
                    label: 'Cancelled',
                    data: @json($cancelledPerMonth),
                    backgroundColor: 'rgba(220, 53, 69, 0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true },
            }
        }
    });
</script>
@endsection
