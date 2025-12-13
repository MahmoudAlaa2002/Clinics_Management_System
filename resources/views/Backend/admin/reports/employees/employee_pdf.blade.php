<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employees General Report</title>

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
</style>
</head>

<body>

<div class="container">

    <h1>Employees General Report</h1>

    <!-- 1. Overview -->
    <div class="section-title">1. Overview</div>
    <p class="item">
        This report provides a comprehensive overview of all employees working within the clinic,
        including job roles, demographics, department distribution, and employment status.
    </p>

    <!-- 2. Employee Statistics -->
    <div class="section-title">2. Employee Statistics</div>
    <p class="item">Total Employees: <span class="highlight">{{ $total_employees }}</span></p>
    <p class="item">Active Employees: <span class="highlight">{{ $active_employees }}</span></p>
    <p class="item">Inactive Employees: <span class="highlight">{{ $inactive_employees }}</span></p>
    <p class="item">New Hires This Month: <span class="highlight">{{ $new_hires_month }}</span></p>
    <p class="item">Average Monthly Hires: <span class="highlight">{{ $avg_monthly_hires }}</span></p>


    <div class="section-title">3. Employee Roles Breakdown</div>
    <p class="item">Clinic Manager: <span class="highlight">{{ $clinic_manager_employees }}</span></p>
    <p class="item">Department Manager: <span class="highlight">{{ $department_employees }}</span></p>
    <p class="item">Doctor: <span class="highlight">{{ $doctor_employees }}</span></p>
    <p class="item">Nurse: <span class="highlight">{{ $nurse_employees }}</span></p>
    <p class="item">Receptionist: <span class="highlight">{{ $receptionist_employees }}</span></p>


    <div class="section-title">4. Gender Distribution</div>
    <p class="item">Male: <span class="highlight">{{ $male_employees }}</span></p>
    <p class="item">Female: <span class="highlight">{{ $female_employees }}</span></p>


    <div class="section-title">5. Age Distribution</div>
    <p class="item">18–25 years: <span class="highlight">{{ $age_18_25 }}</span></p>
    <p class="item">26–35 years: <span class="highlight">{{ $age_26_35 }}</span></p>
    <p class="item">36–45 years: <span class="highlight">{{ $age_36_45 }}</span></p>
    <p class="item">46–60 years: <span class="highlight">{{ $age_46_60 }}</span></p>
    <p class="item">60+ years: <span class="highlight">{{ $age_60_plus }}</span></p>



    <div class="section-title">6. Clinic Employee Distribution</div>
    @foreach($clinicEmployeeCounts as $clinic => $count)
        <p class="item">{{ $clinic }}: <span class="highlight">{{ $count }}</span></p>
    @endforeach



    <div class="section-title">7. Summary</div>
    <p class="item">
        The clinic maintains a diverse and balanced workforce across all departments.
        This data supports strategic decisions related to staffing, capacity planning, and resource allocation.
    </p>

</div>

</body>
</html>
