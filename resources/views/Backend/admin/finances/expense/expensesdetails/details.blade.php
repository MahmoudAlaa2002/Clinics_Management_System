@extends('Backend.admin.master')

@section('title' , 'Details Expense')


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
                <h4 class="page-title">Details Expense</h4>
                <h4 style="margin-top: 30px; color:black;">Expense ID: {{ $expense->id ?? '-' }}</h4>
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
                                <option value="department">Department Name</option>
                                <option value="doctor">Doctor Name</option>
                                <option value="date">Appointment Date</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div> --}}
                    @php
                        $remaining = $finalAmount - $totalPaid;
                        $statusMessage = '';
                        $color = '';

                        if ($totalPaid <= 0) {
                            $statusMessage = "No Payment Has Been Made Yet. The Total Amount Due Is: $".$finalAmount;
                            $color = '#ff4646'; // Red
                        } elseif ($remaining > 0) {
                            $statusMessage = "Partial Payment Of $".$totalPaid." Has Been Made. Remaining Amount: $".$remaining;
                            $color = '#007bff'; // Blue
                        } elseif ($remaining == 0) {
                            $statusMessage = "The Full Amount ($".$finalAmount.") Has Been Paid";
                            $color = '#28a745'; // Green
                        } else { // الحالة الرابعة: مدفوع أكثر من اللازم
                            $overpaid = abs($remaining); // قيمة الزيادة
                            $statusMessage = "Overpaid By $".$overpaid;
                            $color = '#9b59b6'; // Purple
                        }
                    @endphp

                    <div class="mt-4 text-center text-white alert font-weight-bold" style="background-color: {{ $color }}; font-size: 18px; padding: 15px; border-radius: 10px;">
                        {{ $statusMessage }}
                    </div>
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Expense Date</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="appointments_table_body">
                            @if($expenseItems->count() > 0)
                                @foreach ($expenseItems as $index => $expenseItem)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $expenseItem->item_name }}</td>
                                        <td>{{ $expenseItem->quantity }}</td>
                                        <td>${{ $expenseItem->unit_price }}</td>
                                        <td>${{ $expenseItem->total_amount }}</td>
                                        <td>{{ $expenseItem->payment_method }}</td>
                                        <td>{{ $expenseItem->expense_date }}</td>
                                        <td>{{ $expenseItem->notes ?? '-' }}</td>
                                        <td class="action-btns">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('edit_expense_Details', ['id' => $expenseItem->id]) }}" class="mr-1 btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                <button class="btn btn-outline-danger btn-sm delete-expenseItem" data-id="{{ $expenseItem->id }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div  style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            No Expenses Details Available At The Moment
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mb-3 d-flex justify-content-end" style="margin-top: 25px;">
                        <a href="{{ Route('view_expenses') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    $(document).on('click', '.delete-expenseItem', function () {
        let expenseItemId = $(this).data('id');
        let url = `/delete/expense/Details/${expenseItemId}`;

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
                                text: 'Expense Has Been Deleted Successfully',
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
