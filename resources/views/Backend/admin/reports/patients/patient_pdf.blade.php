<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Patients General Report</title>

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

    <h1>Patients General Report</h1>

    <div class="section-title">1. Overview</div>
    <p class="item">This report presents a detailed overview of all patients registered within the clinic system,
        helping in monitoring performance and understanding patient demographics and service utilization.</p>

    <div class="section-title">2. Total Patient Statistics</div>
    <p class="item">Total Registered Patients: <span class="highlight">{{ $total_patients }}</span></p>
    <p class="item">New This Month: <span class="highlight">{{ $total_patients_monthly }}</span></p>
    <p class="item">Average Monthly Registrations: <span class="highlight">{{ $average_monthly_registrations }}</span></p>

    <div class="section-title">3. Gender Distribution</div>
    <p class="item">Male: <span class="highlight">{{ $total_patients_male }}</span></p>
    <p class="item">Female: <span class="highlight">{{ $total_patients_female }}</span></p>

    <div class="section-title">4. Age Groups</div>
    <p class="item">Children (0–12): <span class="highlight">{{ $total_patients_children }}</span></p>
    <p class="item">Teens (13–19): <span class="highlight">{{ $total_patients_teens }}</span></p>
    <p class="item">Adults (20–59): <span class="highlight">{{ $total_patients_adults }}</span></p>
    <p class="item">Seniors (60+): <span class="highlight">{{ $total_patients_seniors }}</span></p>


    <div class="section-title">5. Visit Frequency</div>
    <p class="item">1–2 visits/year: <span class="highlight">{{ $visitFrequency['one_to_two'] }}</span></p>
    <p class="item">3–5 visits/year: <span class="highlight">{{ $visitFrequency['three_to_five'] }}</span></p>
    <p class="item">More than 5 visits/year: <span class="highlight">{{ $visitFrequency['more_than_five'] }}</span></p>
    <p class="item">No visits after registration: <span class="highlight">{{ $visitFrequency['no_visits'] }}</span></p>

    <div class="section-title">6. Common Visit Reasons</div>
    <p class="item">General Checkups: <span class="highlight">{{ $commonReasons['General Checkups'] }}</span></p>
    <p class="item">Chronic Disease Follow-Up: <span class="highlight">{{ $commonReasons['Chronic Disease Follow-Up'] }}</span></p>
    <p class="item">Injuries & Trauma: <span class="highlight">{{ $commonReasons['Injuries & Trauma'] }}</span></p>
    <p class="item">Pediatric Visits: <span class="highlight">{{ $commonReasons['Pediatric Visits'] }}</span></p>
    <p class="item">Gynecology Visits: <span class="highlight">{{ $commonReasons['Gynecology Visits'] }}</span></p>
    <p class="item">Ophthalmology Visits: <span class="highlight">{{ $commonReasons['Ophthalmology Visits'] }}</span></p>
    <p class="item">ENT Visits: <span class="highlight">{{ $commonReasons['ENT Visits'] }}</span></p>
    <p class="item">Dental Treatments: <span class="highlight">{{ $commonReasons['Dental Treatments'] }}</span></p>
    <p class="item">Dermatology Visits: <span class="highlight">{{ $commonReasons['Dermatology Visits'] }}</span></p>
    <p class="item">Cardiology Visits: <span class="highlight">{{ $commonReasons['Cardiology Visits'] }}</span></p>
    <p class="item">Orthopedic Visits: <span class="highlight">{{ $commonReasons['Orthopedic Visits'] }}</span></p>
    <p class="item">Neurology Visits: <span class="highlight">{{ $commonReasons['Neurology Visits'] }}</span></p>
    <p class="item">Psychiatry Visits: <span class="highlight">{{ $commonReasons['Psychiatry Visits'] }}</span></p>
    <p class="item">Urology/Nephrology Visits: <span class="highlight">{{ $commonReasons['Urology/Nephrology Visits'] }}</span></p>
    <p class="item">Oncology Visits: <span class="highlight">{{ $commonReasons['Oncology Visits'] }}</span></p>
    <p class="item">Emergency Visits: <span class="highlight">{{ $commonReasons['Emergency Visits'] }}</span></p>
    <p class="item">Family Medicine Visits: <span class="highlight">{{ $commonReasons['Family Medicine Visits'] }}</span></p>
    <p class="item">Surgical Evaluations: <span class="highlight">{{ $commonReasons['Surgical Evaluations'] }}</span></p>
    <p class="item">Other Visits: <span class="highlight">{{ $commonReasons['Other Visits'] }}</span></p>


    <div class="section-title">7. Payment Insights</div>
    <p class="item">Cash Payments:<span class="highlight">{{ $paymentInsights['cash_percent'] }}%</span></p>
    <p class="item">Bank Payments:<span class="highlight">{{ $paymentInsights['bank_percent'] }}%</span></p>
    <p class="item">PayPal Payments:<span class="highlight">{{ $paymentInsights['paypal_percent'] }}%</span></p>

    <br>

    <div class="section-title">8. Summary</div>
    <p class="item">The clinic maintains a healthy patient flow with strong retention rates and consistent growth across all age groups.</p>

</div>

</body>
</html>
