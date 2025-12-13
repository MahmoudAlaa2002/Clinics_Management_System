@extends('Backend.admin.master')

@section('title' , 'Appointments Report View')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <h4 class="page-title">Appointments Report View</h4>

        <iframe id="pdfViewer" width="100%" height="900px" style="border:none;"></iframe>

    </div>
</div>

<script>
    fetch("{{ route('appointments_reports_raw') }}")
        .then(response => response.json())
        .then(data => {
            const base64 = data.pdf;
            document.getElementById("pdfViewer").src = "data:application/pdf;base64," + base64;
        });
</script>
@endsection
