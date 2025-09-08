@extends('Backend.admin.master')

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
            <div class="text-right col-sm-8 col-9 m-b-20">
                <a href="{{ Route('add_patient') }}" class="float-right btn btn-primary btn-rounded" style="font-weight: bold;">
                    <i class="fa fa-plus"></i> Add Patient
                </a>
            </div>
        </div>
        <div class="mb-4 row">
            <div class="col-md-4">
                <input type="text" id="search_input" name="keyword" class="form-control" placeholder="Search...">
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
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="patients_table_body">
                    @include('Backend.admin.patients.searchPatient', ['patients' => $patients])
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
        $(document).on('click', '.delete-patient', function () {
            let patientId = $(this).data('id');
            let url = `/admin/delete/patient/${patientId}`;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                imageUrl: 'https://img.icons8.com/ios-filled/50/fa314a/delete-trash.png',
                imageWidth: 60,
                imageHeight: 60,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Patient Has Been Deleted Successfully',
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        },
                    });
                }
            });
        });


        let lastKeyword = '';

    function fetchPatients(url = "{{ route('search_patients') }}") {
        let keyword = $('#search_input').val().trim();
        let filter  = $('#search_filter').val();

        if (keyword === '' && lastKeyword === '') return;

        if (keyword === '' && lastKeyword !== '') {
            lastKeyword = '';
            window.location.href = "{{ route('view_patients') }}";
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
                if (response.searching) {
                    if (response.count > 12) {
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
