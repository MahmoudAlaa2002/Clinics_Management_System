@extends('Backend.doctors.master')

@section('title', 'View Appointments')

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
        padding-top: 60px;
        padding-bottom: 30px;
    }

    .table-responsive {
        overflow-x: auto;
        scrollbar-width: none;
    }

    .table-responsive::-webkit-scrollbar {
        display: none;
    }

    .search-bar {
        margin-bottom: 20px;
    }

    #keyword {
        border-radius: 30px;
        padding: 10px 18px;
        font-size: 16px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }

    #keyword:focus {
        border-color: #009efb;
        box-shadow: 0 0 5px rgba(0, 158, 251, 0.5);
    }

    .input-group-text {
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
        background: #009efb;
        color: white;
        border: none;
    }

    .status-badge {
        min-width: 140px;
        display: inline-block;
        text-align: center;
        padding: 4px 12px;
        font-size: 16px;
        border-radius: 50px;
        color: white;
        font-weight: 500;
    }

    .status-pending { background-color: #ffc107; }
    .status-accepted { background-color: #189de4; }
    .status-rejected { background-color: #f90d25; }
    .status-cancelled { background-color: #6c757d; }
    .status-completed { background-color: #14ea6d; }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row mb-3 align-items-center">
            <div class="col-md-6 col-12">
                <h4 class="page-title mb-0">View Appointments</h4>
            </div>
        </div>

        {{-- 🔍 Filter Form --}}
        <form method="GET" action="{{ route('doctor.appointments') }}" class="row search-bar align-items-end">
            <div class="col-md-4 mb-2">
                <label for="keyword" class="form-label mb-1 fw-semibold">Filter</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Search appointments..." value="{{ request('keyword') }}">
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <label for="from_date" class="form-label mb-1 fw-semibold">From</label>
                <input type="date" id="from_date" name="from_date" class="form-control" style="border-radius: 30px;" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3 mb-2">
                <label for="to_date" class="form-label mb-1 fw-semibold">To</label>
                <input type="date" id="to_date" name="to_date" class="form-control" style="border-radius: 30px;" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2 mb-2 d-grid">
                <button type="submit" class="btn btn-primary" style="border-radius: 30px;">Search</button>
            </div>
        </form>

        {{-- 📋 Table --}}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Clinic</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($appointments->count() > 0)
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id }}</td>
                                        <td>{{ $appointment->patient->user->name }}</td>
                                        <td>{{ $appointment->clinic->name }}</td>
                                        <td>{{ $appointment->department->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                                        <td>
                                            <span class="status-badge
                                                @if($appointment->status === 'Pending') status-pending
                                                @elseif($appointment->status === 'Accepted') status-accepted
                                                @elseif($appointment->status === 'Rejected') status-rejected
                                                @elseif($appointment->status === 'Cancelled') status-cancelled
                                                @elseif($appointment->status === 'Completed') status-completed
                                                @endif">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="#" class="mr-1 btn btn-outline-success btn-sm"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="mr-1 btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            No appointments found
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="pagination-wrapper d-flex justify-content-center">
                        {{ $appointments->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
