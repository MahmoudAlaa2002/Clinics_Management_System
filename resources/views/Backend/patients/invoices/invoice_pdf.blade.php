@extends('Backend.patients.master')

@section('title', 'Print Patient Invoice')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <iframe id="pdfViewer" width="100%" height="900px" style="border:none;"></iframe>

    </div>
</div>

<script>
    fetch("{{ route('patient.invoice_pdf_raw', ['id' => request()->route('id')]) }}")
        .then(response => response.json())
        .then(data => {
            document.getElementById("pdfViewer").src =
                "data:application/pdf;base64," + data.pdf;
        });
</script>

@endsection
