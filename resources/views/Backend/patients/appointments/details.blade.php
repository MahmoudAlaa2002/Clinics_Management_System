@extends('Backend.patients.master')

@section('title' , 'Appointment details')

@section('content')
<style>
    .appointment-details{
        padding:60px 0;
    }
    .appointment-card{
        background:#fff;
        border-radius:20px;
        padding:40px;
        box-shadow:0 15px 40px rgba(0,0,0,.08);
        border:1px solid #e6ecf3;
    }
    .appointment-title{
        font-size:28px;
        font-weight:800;
        color:#00A8FF;
        margin-bottom:30px;
        text-align:center;
    }
    .details-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
        gap:25px;
    }
    .detail-box{
        background:#f9fbff;
        border-radius:14px;
        padding:20px;
        border:1px solid #e3e9f3;
    }
    .detail-title{
        font-size:13px;
        color:#777;
        font-weight:700;
        margin-bottom:4px;
    }
    .detail-value{
        font-size:16px;
        font-weight:700;
        color:#222;
    }
    .status-pill{
        padding:6px 18px;
        border-radius:40px;
        font-size:13px;
        font-weight:700;
        color:white;
    }
    .status-pending{background:#ffc107;}
    .status-accepted{background:#189de4;}
    .status-completed{background:#28a745;}
    .status-cancelled{background:#6c757d;}
    .status-rejected{background:#dc3545;}
    
    .invoice-btn{
        margin-top:40px;
        background:#00A8FF;
        color:white;
        padding:14px 40px;
        border-radius:50px;
        font-weight:800;
        font-size:15px;
        text-decoration:none;
        display:inline-block;
        transition:.3s;
    }
    .invoice-btn:hover{
        background:#007bff;
        color:white;
    }
    </style>
    
    <div class="container appointment-details">
    
        <div class="appointment-card">
    
            <div class="appointment-title">
                Appointment #{{ $appointment->id }}
            </div>
    
            <div class="details-grid">
    
                <div class="detail-box">
                    <div class="detail-title">Clinic</div>
                    <div class="detail-value">{{ $appointment->clinic->name }}</div>
                </div>
    
                <div class="detail-box">
                    <div class="detail-title">Department</div>
                    <div class="detail-value">{{ $appointment->department->name }}</div>
                </div>
    
                <div class="detail-box">
                    <div class="detail-title">Doctor</div>
                    <div class="detail-value">{{ $appointment->doctor->employee->user->name }}</div>
                </div>
    
                <div class="detail-box">
                    <div class="detail-title">Date</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</div>
                </div>
    
                <div class="detail-box">
                    <div class="detail-title">Time</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                </div>
    
                <div class="detail-box">
                    <div class="detail-title">Status</div>
                    @if($appointment->status == 'Pending')
                        <span class="status-pill status-pending">Pending</span>
                    @elseif($appointment->status == 'Accepted')
                        <span class="status-pill status-accepted">Accepted</span>
                    @elseif($appointment->status == 'Completed')
                        <span class="status-pill status-completed">Completed</span>
                    @elseif($appointment->status == 'Cancelled')
                        <span class="status-pill status-cancelled">Cancelled</span>
                    @else
                        <span class="status-pill status-rejected">Rejected</span>
                    @endif
                </div>
    
            </div>
    
            <div class="text-center">

                @if($appointment->invoice)
            
                    {{-- الفاتورة الصادرة --}}
                    @if($appointment->invoice->invoice_status === 'Issued')
                        <a href="{{ route('patient.details_invoice', $appointment->invoice->id) }}" class="invoice-btn">
                            View Invoice
                        </a>
            
                    {{-- الفاتورة ملغية --}}
                    @else
                        <a href="{{ route('patient.details_refund_invoice', $appointment->invoice->id) }}"
                           class="invoice-btn" style="background:#f59e0b;">
                            View Refund Confirmation
                        </a>
                    @endif
            
                @else
                    <p class="mt-4 text-muted">Invoice not created yet</p>
                @endif
            
            </div>
            
    
        </div>
    
    </div>
    
@endsection