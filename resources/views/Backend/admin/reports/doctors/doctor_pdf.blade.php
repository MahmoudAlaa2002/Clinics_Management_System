<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctors General Report</title>

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
    }

    h1 {
        text-align: center;
        color: #03A9F4;
        margin-bottom: 10px;
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

<!-- ========================= PAGE 1 ========================= -->
<div class="container">

    <h1>Doctors General Report</h1>

    <!-- 1. Overview -->
    <div class="section-title">1. Overview</div>
    <p class="item">
        This report provides a detailed summary of all doctors in the clinic,
        including demographics, specialties, workload insights, and general workforce distribution.
    </p>

    <!-- 2. General Statistics -->
    <div class="section-title">2. General Statistics</div>
    <p class="item">Total Doctors: <span class="highlight">{{ $total_doctors }}</span></p>
    <p class="item">Active Doctors: <span class="highlight">{{ $active_doctors }}</span></p>
    <p class="item">Inactive Doctors: <span class="highlight">{{ $inactive_doctors }}</span></p>
    <p class="item">New Hires This Month: <span class="highlight">{{ $new_doctors_month }}</span></p>
    <p class="item">Average Monthly Hires: <span class="highlight">{{ $avg_doctors_monthly }}</span></p>

    <!-- 3. Gender Distribution -->
    <div class="section-title">3. Gender Distribution</div>
    <p class="item">Male Doctors: <span class="highlight">{{ $male_doctors }}</span></p>
    <p class="item">Female Doctors: <span class="highlight">{{ $female_doctors }}</span></p>


</div>

<div class="page-break"></div>

<div class="container">

    <!-- 4. Clinic Distribution -->
    <div class="section-title">4. Clinic Distribution</div>
    @foreach($clinicDistribution as $clinic => $count)
        <p class="item">{{ $clinic }}: <span class="highlight">{{ $count }}</span></p>
    @endforeach


    <!-- 5. Department Distribution -->
    <div class="section-title">5. Department Distribution</div>
    @foreach($departmentDistribution as $department => $count)
        <p class="item">{{ $department }}: <span class="highlight">{{ $count }}</span></p>
    @endforeach



    <!-- 8. Summary -->
    <div class="section-title">6. Summary</div>
    <p class="item">
        The clinic’s medical team demonstrates strong coverage across essential specialties,
        ensuring balanced patient service and professional diversity.
    </p>

</div>

</body>
</html>
