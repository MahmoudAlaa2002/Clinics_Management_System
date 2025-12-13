@extends('Backend.employees.receptionists.master')

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


</style>

@php
    $clinicName = Auth::user()->employee->clinic->name;
    $departmentName = Auth::user()->employee->department->name;
@endphp

<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Appointments</h4>
            </div>
            <div class="text-right col-sm-8 col-9 m-b-20">
                <a href="{{ Route('receptionist.add_appointment') }}" class="float-right btn btn-primary btn-rounded" style="font-weight: bold;">
                    <i class="fa fa-plus"></i> Add Appointment
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-4 row">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
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
                        <option value="doctor">Doctor Name</option>
                        <option value="date">Appointment Date</option>
                        <option value="status">Status</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-4" style="margin-top: 10px;">
            <h5 style="font-weight: 500; color: #444;">
                Clinic:
                <span style="font-weight: 700; color: #000;">
                    {{ $clinicName }}
                </span>
            </h5>

            <h5 style="font-weight: 500; color: #444;" class="mt-2">
                Department:
                <span style="font-weight: 700; color: #000;">
                    {{ $departmentName }}
                </span>
            </h5>
        </div>


        <!-- Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="appointments_table_body">
                            @include('Backend.employees.receptionists.appointments.search', ['appointments' => $appointments])
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

    // ================================
    // البحث عن المواعيد
    // ================================
    $(document).ready(function () {

        let lastAppointmentKeyword = '';

        function fetchAppointments(url = "{{ route('receptionist.search_appointments') }}") {

            let keyword = $('#search_input').val().trim();
            let filter = $('#search_filter').val();
            let $tableBody = $('#appointments_table_body');
            let $pagination = $('#main-pagination');

            if (keyword === '' && lastAppointmentKeyword === '') return;

            if (keyword === '' && lastAppointmentKeyword !== '') {
                lastAppointmentKeyword = '';
                window.location.href = "{{ route('receptionist.view_appointments') }}";
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
                    console.error("Search failed.");
                }
            });
        }

        $(document).on('input', '#search_input', function () {
            fetchAppointments();
        });

        $(document).on('change', '#search_filter', function () {
            fetchAppointments();
        });

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


    // ================================
    // قبول الموعد — مع تأكيد
    // ================================
    $(document).on('click', '.complete-btn', function (e) {
        e.preventDefault();

        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to accept this appointment?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007BFF',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Accept',
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "/employee/receptionist/appointments/update-status/" + id,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: 'Accepted'
                    },

                    success: function () {

                        Swal.fire({
                            icon: 'success',
                            title: 'Appointment Accepted',
                            text: 'The appointment status has been updated.',
                            confirmButtonColor: '#007BFF',
                        }).then(() => window.location.reload());
                    }
                });
            }
        });
    });


    // ======================================================
    // رفض الموعد — مع سبب الرفض
    // ======================================================

    let selectedRejectId = null;

    // فتح المودال
    $(document).on('click', '.reject-btn', function () {

        selectedRejectId = $(this).data('id');
        $('#reject-reason').val("");

        let modal = new bootstrap.Modal(document.getElementById('rejectReasonModal'));
        modal.show();

    });

    // تأكيد الرفض
    $(document).on('click', '#confirm-reject-btn', function () {

        let reason = $('#reject-reason').val().trim();

        if (reason.length < 3) {
            Swal.fire({
                icon: 'warning',
                text: 'Please write a valid rejection reason',
                confirmButtonColor: '#007BFF',
            });
            return;
        }

        $.ajax({
            url: "/employee/receptionist/appointments/update-status/" + selectedRejectId,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: 'Rejected',
                notes: reason
            },

            success: function () {

                $('#rejectReasonModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Appointment Rejected',
                    text: 'Rejection reason has been saved',
                    confirmButtonColor: '#007BFF',
                }).then(() => window.location.reload());
            }
        });

    });

</script>

@endsection
