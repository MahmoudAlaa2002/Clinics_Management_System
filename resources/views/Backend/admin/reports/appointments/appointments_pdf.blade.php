<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Appointments General Report</title>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 700px;
        margin: 40px auto;
        background: white;
        padding: 35px 45px;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        min-height: 950px;
    }
    h1 {
        text-align: center;
        color: #03A9F4;
        margin-bottom: 15px;
        font-size: 30px;
    }
    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-top: 25px;
        color: #333;
        border-bottom: 2px solid #03A9F4;
        padding-bottom: 6px;
    }
    .item {
        margin: 8px 0;
        font-size: 15px;
        color: #2c3e50;
        line-height: 1.5;
    }
    .highlight {
        font-weight: bold;
        color: #03A9F4;
    }
    .page-break {
        page-break-after: always;
    }
</style>
</head>

<body>

<div class="container">

    <h1>Appointments Detailed Report</h1>

    <!-- 1. Overview -->
    <div class="section-title">1. Overview</div>
    <p class="item">
        This report provides a comprehensive analysis of appointment activity within the clinic,
        covering total bookings, status distribution, timelines, department distribution, clinics workload,
        and overall performance trends.
    </p>

    <!-- 2. Global Statistics -->
    <div class="section-title">2. Global Appointment Statistics</div>
    <p class="item">Total Appointments: <span class="highlight">{{ $total_appointments }}</span></p>
    <p class="item">Completed Appointments: <span class="highlight">{{ $completed_appointments }}</span></p>
    <p class="item">Cancelled Appointments: <span class="highlight">{{ $cancelled_appointments }}</span></p>
    <p class="item">Rejected Appointments: <span class="highlight">{{ $rejected_appointments }}</span></p>
    <p class="item">Accepted Appointments: <span class="highlight">{{ $accepted_appointments }}</span></p>
    <p class="item">Pending Appointments: <span class="highlight">{{ $pending_appointments }}</span></p>

    <!-- 3. Daily / Monthly Summary -->
    <div class="section-title">3. Daily & Monthly Statistics</div>
    <p class="item">Appointments Today: <span class="highlight">{{ $appointments_today }}</span></p>
    <p class="item">Appointments This Month: <span class="highlight">{{ $appointments_month }}</span></p>
    <p class="item">Average Daily Appointments: <span class="highlight">{{ number_format($avg_daily_appointments, 1) }}</span></p>

    <!-- 4. Best & Worst Months -->
    <div class="section-title">4. Monthly Trends</div>
    <p class="item">Most Active Month: <span class="highlight">{{ $most_active_month }}</span></p>
    <p class="item">Least Active Month: <span class="highlight">{{ $least_active_month }}</span></p>

    <!-- 5. Best & Worst Time Slots -->
    <div class="section-title">5. Time Slot Insights</div>
    <p class="item">Peak Time (Most Preferred): <span class="highlight">{{ $best_time_slot }}</span></p>
    <p class="item">Lowest Activity Time: <span class="highlight">{{ $worst_time_slot }}</span></p>

</div>

<div class="page-break"></div>

<div class="container">

    <!-- 6. Clinics Distribution -->
    <div class="section-title">6. Appointments per Clinic</div>
    @foreach($clinicCounts as $clinic => $count)
        <p class="item">{{ $clinic }}: <span class="highlight">{{ $count }}</span> appointments</p>
    @endforeach

    <!-- 7. Departments Distribution -->
    <div class="section-title">7. Appointments per Department</div>
    @foreach($departmentCounts as $department => $count)
        <p class="item">{{ $department }}: <span class="highlight">{{ $count }}</span> appointments</p>
    @endforeach

    <!-- 8. Additional Summary -->
    <div class="section-title">8. Summary</div>
    <p class="item">
        The clinic registered
        <span class="highlight">{{ $total_appointments }}</span> total appointments overall,
        with a peak in
        <span class="highlight">{{ $most_active_month }}</span>
        and significantly lower bookings in
        <span class="highlight">{{ $least_active_month }}</span>.
    </p>

    <p class="item">
        The appointment flow demonstrates stable activity,
        averaging
        <span class="highlight">{{ number_format($avg_daily_appointments, 1) }}</span>
        appointments per day.
    </p>

</div>

</body>
</html>
