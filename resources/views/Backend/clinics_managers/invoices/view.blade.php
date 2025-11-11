@extends('Backend.clinics_managers.master')

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
        padding-top: 80px; /* مسافة من الجدول */
        padding-bottom: 30px;
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
                        <option value="invoice_date">Invoice Date</option>
                        <option value="due_date">Due Date</option>
                        <option value="payment_status">Payment Status</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0 text-center table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Total Amount</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="invoices_table_body">
                    @include('Backend.clinics_managers.invoices.search', ['invoices' => $invoices])
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
    // حذف الموظف
    $(document).on('click', '.delete-invoice', function () {
        let invoiceId = $(this).data('id');
        let url = `/clinic-manager/delete/invoice/${invoiceId}`;

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
                                text: 'Invoice has been deleted successfully',
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

    function fetchInvoices(url = "{{ route('clinic.search_invoices') }}") {
        let keyword = $('#search_input').val().trim();
        let filter  = $('#search_filter').val();

        if (keyword === '' && lastKeyword === '') return;

        if (keyword === '' && lastKeyword !== '') {
            lastKeyword = '';
            window.location.href = "{{ route('clinic.view_invoices') }}";
            return;
        }

        lastKeyword = keyword;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { keyword: keyword, filter: filter },
            success: function (response) {
                $('#invoices_table_body').html(response.html);
                if (response.searching) {
                    if (response.count > 12) {
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

    $(document).on('input', '#search_input', function () { fetchInvoices(); });
    $(document).on('change', '#search_filter', function () { fetchInvoices(); });

    $(document).on('click', '#invoices-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') fetchInvoices(url);
        }
    });
</script>
@endsection
