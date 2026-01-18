@extends('Backend.patients.master')

@section('title' , 'My Appointments')

@section('content')

    <style>
        .my-appointments{
            padding:60px 0;
        }
        .appointment-card{
            background:#fff;
            border-radius:18px;
            padding:25px;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
            border:1px solid #e6ecf3;
            transition:.3s;
            height:100%;
        }
        .appointment-card:hover{
            transform:translateY(-5px);
            box-shadow:0 15px 35px rgba(0,0,0,.12);
        }
        .appointment-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:15px;
        }
        .appointment-header h5{
            font-weight:800;
            color:#1f2b3e;
        }
        .status-badge{
            padding:6px 14px;
            border-radius:30px;
            font-size:13px;
            font-weight:700;
            color:#fff;
        }
        .status-pending{background:#ffc107;}
        .status-accepted{background:#189de4;}
        .status-completed{background:#28a745;}
        .status-cancelled{background:#6c757d;}
        .status-rejected{background:#dc3545;}
        
        .appointment-info{
            margin-top:10px;
        }
        .appointment-info p{
            margin-bottom:8px;
            color:#555;
            font-size:14px;
        }
        .appointment-info i{
            width:20px;
            color:#00A8FF;
        }
        .appointment-footer{
            margin-top:20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .btn-view{
            background:#00A8FF;
            color:#fff;
            border-radius:30px;
            padding:8px 20px;
            font-weight:700;
            font-size:14px;
            transition:.3s;
        }

        .btn-view:hover{
            background:#00A8FF;
            color:#fff;
        }

        .pagination-wrapper {
                margin-top: auto;
                padding-top: 80px;
                padding-bottom: 30px;
            }

            .pagination .page-link {
                background-color: #fff;
                color: #00A8FF;
            }

            /* الصفحة الحالية فقط */
            .pagination .page-item.active .page-link {
                background-color: #00A8FF;
                color: #fff;
                border-color: #00A8FF;
            }

            /* Hover عادي */
            .pagination .page-link:hover {
                background-color: #f1f5ff;
                color: #00A8FF;
            }
    </style>
    
    <div class="container my-appointments">
    
        <div class="mb-5 text-center">
            <h2 style="color:#00A8FF;font-weight:800;">My Appointments</h2>
            <p class="text-muted">Track and manage all your clinic visits</p>
        </div>
    
        <div class="row">
    
            @forelse($appointments as $appointment)
    
                <div class="mb-4 col-lg-4 col-md-6">
                    <div class="appointment-card">
    
                        <div class="appointment-header">
                            <h5>Appointment #{{ $appointment->id }}</h5>
    
                            @if($appointment->status == 'Pending')
                                <span class="status-badge status-pending">Pending</span>
                            @elseif($appointment->status == 'Accepted')
                                <span class="status-badge status-accepted">Accepted</span>
                            @elseif($appointment->status == 'Completed')
                                <span class="status-badge status-completed">Completed</span>
                            @elseif($appointment->status == 'Cancelled')
                                <span class="status-badge status-cancelled">Cancelled</span>
                            @else
                                <span class="status-badge status-rejected">Rejected</span>
                            @endif
                        </div>
    
                        <div class="appointment-info">
                            <p><i class="fas fa-hospital"></i> {{ $appointment->clinic->name }}</p>
                            <p><i class="fas fa-building"></i> {{ $appointment->department->name }}</p>
                            <p><i class="fas fa-user-md"></i> {{ $appointment->doctor->employee->user->name }}</p>
                            <p><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</p>
                            <p><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                        </div>
    
                        <div class="appointment-footer">
                            <span class="text-muted" style="font-size:13px;">
                                Booked {{ $appointment->created_at->diffForHumans() }}
                            </span>

                            <a href="{{ route('patient.details_appointment', $appointment->id) }}" class="btn btn-view">
                                View
                            </a>
                        </div>
    
                    </div>
                </div>
    
            @empty
    
                <div class="col-12">
                    <div class="text-center alert alert-info">
                        You don’t have any appointments yet.
                    </div>
                </div>
    
            @endforelse
    
        </div>

        <div id="clinics-pagination" class="pagination-wrapper d-flex justify-content-center">
            {{ $appointments->links('pagination::bootstrap-4') }}
        </div>
    
    </div>
    
@endsection