@extends('Backend.employees.accountants.master')

@section('title' , 'View Patients')

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
                <h4 class="page-title">View Patients</h4>
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
                        <option value="name">Patient Name</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 text-center table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="patients_table_body">
                    @include('Backend.employees.accountants.patients.search', ['patients' => $patients])
                </tbody>
            </table>
            <div id="patients-pagination" class="pagination-wrapper d-flex justify-content-center">
                {{ $patients->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>

    initTooltips();
    let lastKeyword = '';

    function fetchPatients(url = "{{ route('accountant.search_patients') }}") {
        let keyword = $('#search_input').val().trim();
        let filter  = $('#search_filter').val();

        if (keyword === '' && lastKeyword === '') return;

        if (keyword === '' && lastKeyword !== '') {
            lastKeyword = '';
            window.location.href = "{{ route('accountant.view_patients') }}";
            return;
        }

        lastKeyword = keyword;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { keyword: keyword, filter: filter },
            success: function (response) {
                $('#patients_table_body').html(response.html);
                initTooltips();

                if (response.searching) {
                    if (response.count > 50) {
                        $('#patients-pagination').html(response.pagination).show();
                    } else {
                        $('#patients-pagination').empty().hide();
                    }
                } else {
                    $('#patients-pagination').show();
                }
            },
            error: function () {
                console.error("Failed to fetch patients.");
            }
        });
    }

    $(document).on('input', '#search_input', function () { fetchPatients(); });
    $(document).on('change', '#search_filter', function () { fetchPatients(); });

    $(document).on('click', '#patients-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') fetchPatients(url);
        }
    });
    </script>
@endsection
