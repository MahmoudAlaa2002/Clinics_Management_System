@extends('Backend.doctors.master')

@section('title', 'My Invoices')

@section('content')
<style>
    .summary-card {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 20px;
        background-color: #fff;
        text-align: center;
        margin-bottom: 20px;
    }
    .summary-card h3 {
        margin: 0;
        font-weight: bold;
        font-size: 24px;
    }
    .summary-card p {
        margin: 5px 0 0;
        color: #555;
    }
    .table-wrapper {
        background-color: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="mb-3 row">
            <div class="col-sm-6 col-12">
                <h4 class="page-title">My Invoices</h4>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="summary-card">
                    <p>Total Earnings</p>
                    <h3>${{ number_format($totalEarnings, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <p>Pending Payments</p>
                    <h3>${{ number_format($pendingPayments, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <p>Total Invoices</p>
                    <h3>{{ $invoices->count() }}</h3>
                </div>
            </div>
        </div>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('doctor.invoices') }}" class="mb-4 row">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by patient name or status..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        {{-- Table --}}
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
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->appointment->id ?? '-' }}</td>
                            <td>{{ $invoice->patient->user->name ?? '-' }}</td>
                            <td>{{ $invoice->total_amount ?? '-' }}</td>
                            <td>{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : '-' }}</td>
                            <td>{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : '-' }}</td>
                            <td>{{ ucfirst($invoice->payment_status ?? '-') }}</td>
                            <td>
                                <a href="#" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No invoices found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper d-flex justify-content-center mt-3">
                {{ $invoices->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
