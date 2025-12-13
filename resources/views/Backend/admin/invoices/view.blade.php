@extends('Backend.admin.master')

@section('title', 'View Invoices')

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

    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }

    .filter-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 12px 18px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        min-width: 260px;
        margin-top: -40px;
        margin-left: 245px;
    }

    .filter-title {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 8px;
        color: #374151;
    }

    .radio-box-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .radio-box {
        position: relative;
        cursor: pointer;
        flex: 1;
    }

    .radio-box input[type="radio"] {
        display: none;
    }

    .radio-label {
        display: block;
        text-align: center;
        padding: 9px 0;
        border-radius: 25px;
        border: 2px solid #03A9F4;
        color: #03A9F4;
        font-weight: 600;
        transition: 0.25s ease;
        cursor: pointer;
        font-size: 14px;
    }

    .radio-box input[type="radio"]:checked + .radio-label {
        background-color: #03A9F4;
        color: #fff;
        box-shadow: 0 3px 8px rgba(0, 169, 244, 0.4);
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="mb-3 row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Invoices</h4>
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

                        <!-- Issued -->
                        <option value="invoice_date" class="issued-only">Invoice Date</option>
                        <option value="due_date" class="issued-only">Due Date</option>
                        <option value="payment_status" class="issued-only">Payment Status</option>

                        <!-- Cancelled -->
                        <option value="refund_date" class="cancelled-only">Refund Date</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="filter-card">
                    <div class="filter-title">Filter Invoices:</div>
                    <div class="radio-box-group">
                        <label class="radio-box">
                            <input type="radio" name="invoiceFilter" value="Issued" checked>
                            <span class="radio-label">Issued</span>
                        </label>

                        <label class="radio-box">
                            <input type="radio" name="invoiceFilter" value="Cancelled">
                            <span class="radio-label">Cancelled</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0 text-center table-bordered table-striped custom-table">
                <thead id="invoices_table_head">
                    @if ($statusFilter === 'Issued')
                        <tr>
                            <th>ID</th>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    @else
                        <tr>
                            <th>ID</th>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Refund Amount</th>
                            <th>Refund Date</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    @endif
                </thead>

                <tbody id="invoices_table_body">
                    @include('Backend.admin.invoices.search', ['invoices' => $invoices])
                </tbody>
            </table>

            <div id="invoices-pagination" class="pagination-wrapper d-flex justify-content-center">
                {{ $invoices->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

    function fetchInvoices(url = "{{ route('search_invoices') }}") {

        let keyword = $('#search_input').val().trim();
        let filter  = $('#search_filter').val();
        let invoiceFilter = $('input[name="invoiceFilter"]:checked').val();

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: {
                keyword: keyword,
                filter: filter,
                invoiceFilter: invoiceFilter
            },
            success: function (response) {
                $('#invoices_table_body').html(response.html);

                if(response.header){
                    $('#invoices_table_head').html(response.header);
                }

                if (response.searching) {
                    if (response.count > 50) {
                        $('#invoices-pagination').html(response.pagination).show();
                    } else {
                        $('#invoices-pagination').empty().hide();
                    }
                } else {
                    $('#invoices-pagination').show();
                }
            },
            error: function () {
                console.error("Failed to fetch invoices.");
            }
        });
    }

    $(document).on('input', '#search_input', function () {
        fetchInvoices();
    });

    $(document).on('change', '#search_filter', function () {
        fetchInvoices();
    });


    $(document).on('click', '#invoices-pagination .page-link', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (url && url !== '#') {
            fetchInvoices(url);
        }
    });

    function updateSearchFilterOptions() {

        let invoiceFilter = $('input[name="invoiceFilter"]:checked').val();

        if (invoiceFilter === "Issued") {

            $('.issued-only').show();
            $('.cancelled-only').hide();

            if ($('.cancelled-only:selected').length) {
                $('#search_filter').val('appointment_id');
            }

        } else if (invoiceFilter === "Cancelled") {

            $('.issued-only').hide();
            $('.cancelled-only').show();

            if ($('.issued-only:selected').length) {
                $('#search_filter').val('appointment_id');
            }
        }
    }

    updateSearchFilterOptions();

    $(document).on('change', 'input[name="invoiceFilter"]', function () {
        updateSearchFilterOptions();
        fetchInvoices();
    });

</script>
@endsection

