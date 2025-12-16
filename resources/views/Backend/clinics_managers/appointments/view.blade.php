@extends('Backend.clinics_managers.master')

@section('title' , 'View Appointments')

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
        padding-top: 80px;
        padding-bottom: 30px;
    }

    .table-responsive {
        overflow-x: auto;
        scrollbar-width: none;
    }

    .table-responsive::-webkit-scrollbar {
        display: none;
    }

    .custom-table tbody tr {
        transition: filter 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-table tbody tr:hover {
        filter: brightness(90%);
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        cursor: pointer;
    }
</style>

<div class="page-wrapper">
    <div class="content">

        <div class="row align-items-center mb-3">
            <div class="col-sm-6">
                <h4 class="page-title mb-0">
                    View Appointments
                </h4>
            </div>

            <div class="col-sm-6 text-right">
                <a href="{{ route('clinic.appointments_trash') }}"
                   class="btn btn-danger btn-rounded"
                   style="font-weight: bold;">
                    <i class="fa fa-trash"></i> Appointments Trash
                </a>
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
                        <option value="patient">Patient Name</option>
                        <option value="department">Department Name</option>
                        <option value="doctor">Doctor Name</option>
                        <option value="date">Appointment Date</option>
                        <option value="status">Status</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Department Name</th>
                                <th>Doctor Name</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="appointments_table_body">
                            @include('Backend.clinics_managers.appointments.search', ['appointments' => $appointments])
                        </tbody>
                    </table>
                    <div id="main-pagination" class="pagination-wrapper d-flex justify-content-center">
                        {{ $appointments->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    $(document).on('click', '.delete-appointment', function () {
        let appointmentId = $(this).data('id');
        let url = `/clinic-manager/delete/appointment/${appointmentId}`;

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
                        if (response.data == 0) {
                            Swal.fire({
                                title: 'Cannot Delete',
                                text: 'This appointment has an issued invoice, so it cannot be deleted',
                                icon: 'error',
                                confirmButtonColor: '#007BFF',
                            });
                        } else if (response.success == true) {
                            Swal.fire({
                                title: 'Deleted',
                                text: 'The appointment has been moved to the trash',
                                icon: 'success',
                                confirmButtonColor: '#007BFF',
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

    $(document).ready(function () {
        initTooltips();
        let lastAppointmentKeyword = '';

        function fetchAppointments(url = "{{ route('clinic.search_appointments') }}") {
            let $searchInput = $('#search_input');
            let $filter      = $('#search_filter');
            let $tableBody   = $('#appointments_table_body');
            let $pagination  = $('#main-pagination');

            if ($searchInput.length === 0 || $tableBody.length === 0) {
                return;
            }

            let keyword = $searchInput.val().trim();
            let filter  = $filter.length ? $filter.val() : '';

            if (keyword === '' && lastAppointmentKeyword === '') return;

            if (keyword === '' && lastAppointmentKeyword !== '') {
                lastAppointmentKeyword = '';
                window.location.href = "{{ route('clinic.view_appointments') }}";
                return;
            }

            lastAppointmentKeyword = keyword;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: { keyword: keyword, filter: filter },
                success: function (response) {
                    $tableBody.html(response.html);
                    initTooltips();

                    if (response.searching) {
                        if (response.count > 50) {
                            $pagination.html(response.pagination).show();
                        } else {
                            $pagination.empty().hide();
                        }
                    } else {
                        $pagination.show();
                    }
                },
                error: function () {
                    console.error("⚠️ فشل في تحميل نتائج البحث.");
                }
            });
        }

        // 🔍 البحث أثناء الكتابة
        $(document).on('input', '#search_input', function () {
            fetchAppointments();
        });

        // 🔄 البحث عند تغيير نوع الفلتر
        $(document).on('change', '#search_filter', function () {
            fetchAppointments();
        });

        // 📄 دعم الباجينيشن في حالة البحث
        $(document).on('click', '#main-pagination .page-link', function (e) {
            let keyword = $('#search_input').val().trim();
            if (keyword !== '') {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url && url !== '#') {
                    fetchAppointments(url);
                }
            }
        });
    });

</script>
@endsection
