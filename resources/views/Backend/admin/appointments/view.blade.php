@extends('Backend.admin.master')

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
        padding-top: 80px; /* مسافة من الجدول */
        padding-bottom: 30px;
    }

    .table-responsive {
        overflow-x: auto;
        scrollbar-width: none; /* لإخفاء الشريط في فايرفوكس */
    }

    .table-responsive::-webkit-scrollbar {
        display: none; /* لإخفاء الشريط في كروم */
    }

</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Appointments</h4>
            </div>
            <div class="text-right col-sm-8 col-9 m-b-20 d-flex justify-content-end gap-2">

                {{-- زر سلة المحذوفات --}}
                <a href="{{ route('appointments_trash') }}"
                   class="btn btn-danger btn-rounded"
                   style="font-weight: bold; margin-right: 10px;">
                    <i class="fa fa-trash"></i> Appointments Trash
                </a>

                {{-- زر إضافة موعد --}}
                <a href="{{ Route('add_appointment') }}"
                   class="btn btn-primary btn-rounded"
                   style="font-weight: bold;">
                    <i class="fa fa-plus"></i> Add Appointment
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
                                <th>Clinic Name</th>
                                <th>Department Name</th>
                                <th>Doctor Name</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="appointments_table_body">
                            @if($appointments->count() > 0)
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id }}</td>
                                        <td>{{ optional(optional($appointment->patient)->user)->name ?? '-' }}</td>
                                        <td>{{ $appointment->clinicDepartment->clinic->name }}</td>
                                        <td>{{ $appointment->clinicDepartment->department->name }}</td>
                                        <td>{{ optional(optional(optional($appointment->doctor)->employee)->user)->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                                        <td>
                                            @if($appointment->status === 'Pending')
                                                <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#ffc107; color:white;">
                                                    Pending
                                                </span>
                                            @elseif($appointment->status === 'Accepted')
                                                <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#189de4; color:white;">
                                                    Accepted
                                                </span>
                                            @elseif($appointment->status === 'Rejected')
                                                <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#f90d25; color:white;">
                                                    Rejected
                                                </span>
                                            @elseif($appointment->status === 'Cancelled')
                                                <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#6c757d; color:white;">
                                                    Cancelled
                                                </span>
                                            @elseif($appointment->status === 'Completed')
                                                <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#14ea6d; color:white;">
                                                    Completed
                                                </span>
                                            @endif
                                        </td>
                                        <td class="action-btns">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('details_appointment', ['id' => $appointment->id]) }}" class="mr-1 btn btn-outline-success btn-sm"><i class="fa fa-eye"></i></a>

                                                {{-- السماح بالتعديل فقط إذا كانت الحالة Pending أو Accepted --}}
                                                @if(in_array($appointment->status, ['Pending', 'Accepted']))
                                                    <a href="{{ route('edit_appointment', ['id' => $appointment->id]) }}"
                                                    class="mr-1 btn btn-outline-primary btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif

                                                {{-- السماح بالحذف فقط إذا لم يكن Completed --}}
                                                @if($appointment->status !== 'Completed')
                                                    <button class="btn btn-outline-danger btn-sm delete-appointment"
                                                            data-id="{{ $appointment->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div  style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            There Are Currently No Scheduled Appointments
                                        </div>
                                    </td>
                                </tr>
                            @endif
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
        let url = `/admin/delete/appointment/${appointmentId}`;

        Swal.fire({
            title: 'Are you sure?',
            text: "This appointment will be moved to the trash",
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
                        } else if (response.success) {
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
        let lastAppointmentKeyword = '';

        function fetchAppointments(url = "{{ route('search_appointments') }}") {
            let $searchInput = $('#search_input');
            let $filter      = $('#search_filter');
            let $tableBody   = $('#appointments_table_body');
            let $pagination  = $('#main-pagination');

            if ($searchInput.length === 0 || $tableBody.length === 0) {
                return;
            }

            let keyword = $searchInput.val().trim();
            let filter  = $filter.length ? $filter.val() : '';

            // ⛔ أول مرة يكون البحث فارغ، لا تعمل شيء
            if (keyword === '' && lastAppointmentKeyword === '') return;

            // 🔁 إذا المستخدم مسح النص بعد بحث سابق → ارجع للوضع العادي (إعادة تحميل الصفحة)
            if (keyword === '' && lastAppointmentKeyword !== '') {
                lastAppointmentKeyword = '';
                window.location.href = "{{ route('view_appointments') }}";
                return;
            }

            // تحديث آخر كلمة بحث
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
