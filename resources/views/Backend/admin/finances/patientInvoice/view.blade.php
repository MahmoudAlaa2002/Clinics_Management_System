@extends('Backend.master')

@section('title' , 'View Patients Invoices')


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
                <h4 class="page-title">View Patients Invoices</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    {{-- <div class="mb-4 row">
                        <div class="col-md-4">
                            <input type="text" id="search_input" class="form-control" placeholder="Search...">
                        </div>
                        <div class="col-md-3">
                            <select id="search_filter" class="form-control">
                                <option value="patient">Patient Name</option>
                                <option value="clinic">Clinic Name</option>
                                <option value="specialty">Specialty Name</option>
                                <option value="doctor">Doctor Name</option>
                                <option value="date">Appointment Date</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div> --}}
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Appointment ID</th>
                                <th>Clinic Name</th>
                                <th>Patient Name</th>
                                <th>Final Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="appointments_table_body">
                            @if($patientInvoices->count() > 0)
                                @foreach ($patientInvoices as $patientInvoice)
                                    <tr>
                                        <td>{{ $patientInvoice->id }}</td>
                                        <td>{{ $patientInvoice->appointment->id }}</td>
                                        <td>{{ $patientInvoice->clinic->name }}</td>
                                        <td>{{ $patientInvoice->patient->name }}</td>
                                        <td>${{ $patientInvoice->final_amount }}</td>
                                        <td>
                                            @php
                                                $amount_paid = $patientInvoice->payments->sum(function($payment) {
                                                    return $payment->paymentDetails->sum('amount_paid');
                                                });
                                            @endphp

                                            @if($amount_paid == 0)
                                                <span class="status-badge" style="min-width: 140px; display: inline-block; text-align: center; padding: 4px 12px; font-size: 18px; border-radius: 50px; background-color: #f90d25; color: white;">
                                                    unpaid
                                                </span>
                                            @elseif($amount_paid < $patientInvoice->final_amount)
                                                <span class="status-badge" style="min-width: 140px; display: inline-block; text-align: center; padding: 4px 12px; font-size: 18px; border-radius: 50px; background-color: #189de4; color: white;">
                                                    partial
                                                </span>
                                            @elseif($amount_paid == $patientInvoice->final_amount)
                                                <span class="status-badge" style="min-width: 140px; display: inline-block; text-align: center; padding: 4px 12px; font-size: 18px; border-radius: 50px; background-color: #15ef70; color: white;">
                                                    paid
                                                </span>
                                            @elseif($amount_paid > $patientInvoice->final_amount)
                                                <span class="status-badge" style="min-width: 140px; display: inline-block; text-align: center; padding: 4px 12px; font-size: 18px; border-radius: 50px; background-color: #9b59b6; color: white;">
                                                    overpaid
                                                </span>
                                            @endif
                                        </td>
                                        <td class="action-btns">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('details_invoice', ['id' => $patientInvoice->id]) }}" class="mr-1 btn btn-outline-success btn-sm"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('edit_invoice', ['id' => $patientInvoice->id]) }}" class="mr-1 btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                <button class="btn btn-outline-danger btn-sm delete-patientInvoice" data-id="{{ $patientInvoice->id }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div  style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            No patients Invoices available at the moment
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mb-3 d-flex justify-content-end" style="margin-top: 25px;">
                        <a href="{{ Route('dashboard') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                            Back
                        </a>
                    </div>
                    <div id="main-pagination" class="pagination-wrapper d-flex justify-content-center">
                        {{ $patientInvoices->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    $(document).on('click', '.delete-patientInvoice', function () {
        let patientInvoiceId = $(this).data('id');
        let url = `/delete/invoice/${patientInvoiceId}`;

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
                                text: 'Patient Invoice Has Been Deleted Successfully',
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

    // $(document).ready(function () {

    //     function fetchAppointments() {
    //         let keyword = $('#search_input').val().trim();
    //         let filter = $('#search_filter').val();

    //         // ✅ إذا البحث فارغ تمامًا، أرجع للعرض الأساسي
    //         if (keyword === '') {
    //             window.location.href = "{{ route('view_appointments') }}";
    //             return;
    //         }

    //         $.ajax({
    //             url: "{{ route('search_appointments') }}",
    //             type: 'GET',
    //             dataType: 'json',
    //             data: {
    //                 keyword: keyword,
    //                 filter: filter
    //             },
    //             success: function (response) {
    //                 $('#appointments_table_body').html(response.html);

    //                 if (response.searching) {
    //                     if (response.count > 12) {
    //                         $('#main-pagination').html(response.pagination).show();
    //                     } else {
    //                         $('#main-pagination').empty().hide();
    //                     }
    //                 } else {
    //                     $('#main-pagination').show();
    //                 }
    //             },
    //             error: function () {
    //                 console.error("فشل في تحميل نتائج البحث.");
    //             }
    //         });
    //     }

    //     $('#search_input, #search_filter').on('input change', function () {
    //         fetchAppointments();
    //     });

    //     function fetchAppointmentsWithUrl(url) {
    //         let keyword = $('#search_input').val().trim();
    //         let filter = $('#search_filter').val();

    //         $.ajax({
    //             url: url,
    //             type: 'GET',
    //             dataType: 'json',
    //             data: {
    //                 keyword: keyword,
    //                 filter: filter
    //             },
    //             success: function (response) {
    //                 $('#appointments_table_body').html(response.html);

    //                 if (response.count > 12) {
    //                     $('#main-pagination').html(response.pagination).show();
    //                 } else {
    //                     $('#main-pagination').empty().hide();
    //                 }
    //             },
    //             error: function () {
    //                 console.error("فشل في تحميل الصفحة المطلوبة.");
    //             }
    //         });
    //     }

    //     $(document).on('click', '#main-pagination .page-link', function (e) {
    //         let keyword = $('#search_input').val().trim();
    //         if (keyword !== '') {
    //             e.preventDefault();
    //             let url = $(this).attr('href');
    //             if (url !== undefined && url !== '#') {
    //                 fetchAppointmentsWithUrl(url);
    //             }
    //         }
    //     });

    // });

</script>
@endsection
