@extends('Backend.employees.accountants.master')

@section('title' , 'Bank Payments')

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
                <h4 class="page-title">Bank Payments</h4>
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
                        <option value="amount">Amount</option>
                        <option value="reference_number">Reference Number</option>
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
                                <th>Amount</th>
                                <th>Reference Number</th>
                                <th>Receipt</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="payments_table_body">
                            @include('Backend.employees.accountants.payments.bank.search', ['payments' => $payments])
                        </tbody>
                    </table>

                    <div id="verifyModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7);
                        z-index:9999; align-items:center; justify-content:center;">

                        <div style="background:white; width:95%;max-width:1200px; height:85vh; border-radius:14px;
                                padding:24px; display:flex; gap:24px; box-shadow:0 20px 60px rgba(0,0,0,.3);">

                            <!-- LEFT: Receipt Image -->
                            <div style="flex:1; height:100%; display:flex; align-items:center; justify-content:center;
                                    border-radius:12px; overflow:hidden;">

                                <img id="verifyReceiptImg" style="width:150%; height:100%; object-fit:contain;">
                            </div>



                            <!-- RIGHT: Verification -->
                            <div style="flex:1.5; display:flex; flex-direction:column; height:100%;">
                                <h4 style="color:#00A8FF;font-weight:700;">Payment Verification</h4>

                                <div style="margin-top:20px">
                                    <label style="font-weight:600">Amount</label>
                                    <input id="verifyAmount" class="form-control" readonly>
                                </div>

                                <div style="margin-top:20px">
                                    <label style="font-weight:600">Reference Number</label>
                                    <input id="verifyReference" class="form-control" readonly>
                                </div>

                                <div style="margin-top:280px; padding-top:16px; border-top:1px solid #eee;
                                    display:flex; justify-content:flex-end;">
                                    <button id="closeVerifyModal"
                                            class="btn btn-secondary"
                                            style="padding:10px 22px;font-size:15px;">
                                        Close
                                    </button>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>


                    <div id="main-pagination" class="pagination-wrapper d-flex justify-content-center">
                        {{ $payments->links('pagination::bootstrap-4') }}
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
        let lastAppointmentKeyword = '';

        function fetchAppointments(url = "{{ route('accountant.search_bank_payments') }}") {
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
                window.location.href = "{{ route('accountant.view_bank_payments') }}";
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


    $(document).on('click','td[data-field="receipt"] img',function(){
        let img = $(this);

        $('#verifyReceiptImg').attr('src', img.attr('src'));
        $('#verifyReference').val(img.data('ref'));
        $('#verifyAmount').val('$ ' + img.data('amount'));

        $('#verifyModal').css('display','flex');
    });


    // زر للإغلاق
    $(document).on('click','#closeVerifyModal',function(){
        $('#verifyModal').fadeOut(200);
    });

    $(document).on('click','#verifyModal',function(e){
        if(e.target.id === 'verifyModal'){
            $('#verifyModal').fadeOut(200);
        }
    });


</script>
@endsection
