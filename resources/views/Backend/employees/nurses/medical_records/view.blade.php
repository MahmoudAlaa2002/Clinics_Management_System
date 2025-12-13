@extends('Backend.employees.nurses.master')

@section('title', 'View Medical Records')

@section('content')
    <style>
        html, body { height: 100%; margin: 0; }
        .page-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
        .content { flex: 1; display: flex; flex-direction: column; }
        .pagination-wrapper { margin-top: auto; padding-top: 80px; padding-bottom: 30px; }
    </style>

    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">View Medical Records</h4>
                </div>
            </div>
            <div class="mb-4 row">
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                        <input type="text" id="search_input" name="keyword" class="form-control" placeholder="Search...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Search by:</span>
                        </div>
                        <select id="search_filter" name="filter" class="form-control">
                            <option value="doctor_name">Doctor Name</option>
                            <option value="patient_name">Patient Name</option>
                            <option value="record_date">Record Date</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 text-center table-bordered table-striped custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Appointment ID</th>
                            <th>Doctor Name</th>
                            <th>Patient Name</th>
                            <th>Diagnosis</th>
                            <th>Treatment</th>
                            <th>Record Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="medical_records_table_body">
                        @include('Backend.employees.nurses.medical_records.search', ['medical_records' => $medical_records])
                    </tbody>
                </table>
                <div id="medical-records-pagination" class="pagination-wrapper d-flex justify-content-center">
                    {{ $medical_records->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        let lastKeyword = '';

        function fetchMedicalRecords(url = "{{ route('nurse.search_medical_records') }}") {
            let keyword = $('#search_input').val().trim();
            let filter  = $('#search_filter').val();

            if (keyword === '' && lastKeyword === '') return;

            if (keyword === '' && lastKeyword !== '') {
                lastKeyword = '';
                window.location.href = "{{ route('nurse.view_medical_records') }}";
                return;
            }

            lastKeyword = keyword;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: { keyword: keyword, filter: filter },
                success: function (response) {
                    $('#medical_records_table_body').html(response.html);
                    if (response.searching) {
                        if (response.count > 12) {
                            $('#medical-records-pagination').html(response.pagination).show();
                        } else {
                            $('#medical-records-pagination').empty().hide();
                        }
                    } else {
                        $('#medical-records-pagination').show();
                    }
                },
                error: function () {
                    console.error("Failed to fetch patients.");
                }
            });
        }

        $(document).on('input', '#search_input', function () { fetchMedicalRecords(); });
        $(document).on('change', '#search_filter', function () { fetchMedicalRecords(); });

        $(document).on('click', '#medical-records-pagination .page-link', function (e) {
            let keyword = $('#search_input').val().trim();
            if (keyword !== '') {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url && url !== '#') fetchMedicalRecords(url);
            }
        });
    </script>
@endsection
