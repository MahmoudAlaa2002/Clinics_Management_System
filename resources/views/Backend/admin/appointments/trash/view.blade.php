@extends('Backend.admin.master')

@section('title' , 'Appointments Trash')

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
                    Appointments Trash
                </h4>
            </div>

            <div class="col-sm-6 text-right">
                <a href="{{ route('view_appointments') }}"
                   class="btn btn-primary btn-rounded"
                   style="font-weight: bold;">
                        View Appointments
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
                        <option value="clinic">Clinic Name</option>
                        <option value="department">Department Name</option>
                        <option value="doctor">Doctor Name</option>
                        <option value="date">Deleted Date</option>
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
                                <th>Clinic Name</th>
                                <th>Department Name</th>
                                <th>Doctor Name</th>
                                <th>Deleted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="appointments_table_body">
                            @include('Backend.admin.appointments.trash.search', ['appointments' => $appointments])
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="pagination-wrapper d-flex justify-content-center">
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

    $(document).ready(function () {
        initTooltips();
        let lastKeyword = '';

        function fetchTrashAppointments(url = "{{ route('appointments_trash_search') }}") {

            let keyword = $('#search_input').val().trim();
            let filter  = $('#search_filter').val();

            // أول مرة يكون فارغ لا يعمل شيء
            if (keyword === '' && lastKeyword === '') return;

            // إذا المستخدم مسح البحث بعد بحث سابق → رجوع للوضع الطبيعي
            if (keyword === '' && lastKeyword !== '') {
                lastKeyword = '';
                window.location.href = "{{ route('appointments_trash') }}";
                return;
            }

            lastKeyword = keyword;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: {
                    keyword: keyword,
                    filter: filter
                },
                success: function (response) {
                    $('tbody').html(response.html);
                    initTooltips();

                    if (response.searching) {
                        if (response.count > 50) {
                            $('.pagination-wrapper').html(response.pagination).show();
                        } else {
                            $('.pagination-wrapper').empty().hide();
                        }
                    } else {
                        $('.pagination-wrapper').show();
                    }
                },
                error: function () {
                    console.error("⚠️ Failed to load trash search results.");
                }
            });
        }

        // البحث أثناء الكتابة
        $(document).on('input', '#search_input', function () {
            fetchTrashAppointments();
        });

        // البحث عند تغيير الفلتر
        $(document).on('change', '#search_filter', function () {
            fetchTrashAppointments();
        });

        // دعم الباجينيشن مع البحث
        $(document).on('click', '.pagination-wrapper .page-link', function (e) {
            let keyword = $('#search_input').val().trim();

            if (keyword !== '') {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url && url !== '#') {
                    fetchTrashAppointments(url);
                }
            }
        });
    });




    $(document).on('click', '.restore-appointment', function () {

        let appointmentId = $(this).data('id');
        let url = `/admin/appointments/restore/${appointmentId}`;

        Swal.fire({
            title: 'Restore Appointment?',
            text: "The appointment will be restored to the main appointments list",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Restore'
        }).then((result) => {

            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {

                        if (response.success) {
                            Swal.fire({
                                title: 'Restored Successfully',
                                text: 'The appointment has been restored successfully.',
                                icon: 'success',
                                confirmButtonColor: '#00A8FF',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to restore the appointment.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Server Error',
                            text: 'Something went wrong.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });




    $(document).on('click', '.force-delete-appointment', function () {

        let appointmentId = $(this).data('id');
        let url = `/admin/appointments/force-delete/${appointmentId}`;

        Swal.fire({
            title: 'Permanent Delete?',
            text: "This will permanently delete the appointment and its invoice!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete Permanently'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {

                        // ممنوع الحذف بسبب فاتورة مدفوعة
                        if (response.data == 0) {
                            Swal.fire({
                                title: 'Cannot Delete',
                                text: 'This appointment has a paid or partially paid invoice and cannot be deleted permanently',
                                icon: 'error',
                                confirmButtonColor: '#00A8FF',
                            });
                        }

                        // تم الحذف النهائي
                        else if (response.success) {
                            Swal.fire({
                                title: 'Deleted Permanently',
                                text: 'The appointment and its invoice have been permanently deleted',
                                icon: 'success',
                                confirmButtonColor: '#00A8FF',
                            }).then(() => {
                                location.reload();
                            });
                        }

                        // أي حالة أخرى
                        else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Server Error',
                            text: 'Failed to delete the appointment.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
