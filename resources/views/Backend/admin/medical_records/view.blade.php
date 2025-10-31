@extends('Backend.admin.master')

@section('title', 'View Medical Records')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .pagination-wrapper {
        margin-top: auto;
        padding-top: 80px; /* مسافة من الجدول */
        padding-bottom: 30px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="mb-3 row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Medical Records</h4>
            </div>
        </div>

        <div class="mb-4 row">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" id="search_input" class="form-control" placeholder="Search...">
                </div>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Search by:</span>
                    </div>
                    <select id="search_filter" class="form-control">
                        <option value="appointment_id">Appointment ID</option>
                        <option value="patient_name">Patient Name</option>
                        <option value="doctor_name">Doctor Name</option>
                        <option value="clinic_name">Clinic Name</option>
                        <option value="record_date">Record Date</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0 text-center table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Clinic Name</th>
                        <th>Diagnosis</th>
                        <th>Record Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="medical_records_table_body">
                    @include('Backend.admin.medical_records.search', ['medical_records' => $medical_records])
                </tbody>
            </table>

            <div id="medical_records-pagination" class="pagination-wrapper d-flex justify-content-center">
                {{ $medical_records->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // حذف الموظف
    $(document).on('click', '.delete-medical-record', function () {
        let medicalRecordsId = $(this).data('id');
        let url = `/admin/delete/medical-record/${medicalRecordsId}`;

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
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted',
                                text: 'Medical Record Has Been Deleted Successfully',
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

    function fetchMedicalRecords(url = "{{ route('search_medical_records') }}") {
        let keyword = $('#search_input').val().trim();
        let filter  = $('#search_filter').val();

        if (keyword === '' && lastKeyword === '') return;

        if (keyword === '' && lastKeyword !== '') {
            lastKeyword = '';
            window.location.href = "{{ route('view_medical_records') }}";
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
                        $('#medical_records-pagination').html(response.pagination).show();
                    } else {
                        $('#medical_records-pagination').empty().hide();
                    }
                } else {
                    $('#medical_records-pagination').show();
                }
            },
            error: function () {
                console.error("Failed To Fetch Medical Records");
            }
        });
    }

    $(document).on('input', '#search_input', function () { fetchMedicalRecords(); });
    $(document).on('change', '#search_filter', function () { fetchMedicalRecords(); });

    $(document).on('click', '#medical_records-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') fetchMedicalRecords(url);
        }
    });
</script>
@endsection
