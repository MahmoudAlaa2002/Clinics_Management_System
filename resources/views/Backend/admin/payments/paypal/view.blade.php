@extends('Backend.admin.master')

@section('title', 'PayPal Payments')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <div class="mb-4 row">
            <div class="col-sm-6">
                <h4 class="page-title">PayPal Payments</h4>
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
                        <option value="patient_name">Patient Name</option>
                        <option value="order_id">Order ID</option>
                        <option value="paid_at">Paid At</option>
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
                                <th>Order ID</th>
                                <th>Patient Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Paid At</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody id="payments_table_body">
                            @include('Backend.admin.payments.paypal.search', ['payments' => $payments])
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pagination-wrapper d-flex justify-content-center">
                    {{ $payments->links('pagination::bootstrap-4') }}
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
        let lastAppointmentKeyword = '';

        function fetchAppointments(url = "{{ route('search_paypal_payments') }}") {
            let $searchInput = $('#search_input');
            let $filter      = $('#search_filter');
            let $tableBody   = $('#payments_table_body');
            let $pagination  = $('#main-pagination');

            if ($searchInput.length === 0 || $tableBody.length === 0) {
                return;
            }

            let keyword = $searchInput.val().trim();
            let filter  = $filter.length ? $filter.val() : '';

            if (keyword === '' && lastAppointmentKeyword === '') return;

            if (keyword === '' && lastAppointmentKeyword !== '') {
                lastAppointmentKeyword = '';
                window.location.href = "{{ route('view_paypal_payments') }}";
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