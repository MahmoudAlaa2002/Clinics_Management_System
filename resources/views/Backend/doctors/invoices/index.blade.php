@extends('Backend.doctors.master')

@section('title', 'My Invoices')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="mb-3 row">
            <div class="col-sm-6 col-12">
                <h4 class="page-title">My Invoices</h4>
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
