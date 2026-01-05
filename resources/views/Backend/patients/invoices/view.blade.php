@extends('Backend.patients.master')

@section('title' , 'Invoices')

@section('content')

    <style>

        .header a, .header h1, .header span, .header i{
            color:white!important;
        }

        .header a.active{
            border-bottom:2px solid white;
        }

        /* ===== INVOICES SECTION ===== */

        .section-title{
            font-weight:700;
        }

        .invoice-wrapper{
            display:flex;
            flex-direction:column;
            gap:20px;
        }

        .invoice-card{
            border:1px solid #e9eef5;
            border-radius:18px;
            box-shadow:0 20px 38px rgba(0,0,0,.06);
            overflow:hidden;
            transition:.25s ease-in-out;
            background:#fff;
        }

        .invoice-card:hover{
            transform:translateY(-6px);
            box-shadow:0 26px 44px rgba(0,0,0,.1);
        }

        .invoice-top{
            padding:14px 18px;
            background:linear-gradient(120deg,#00A8FF,#00A8FF);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:space-between;
            font-weight:600;
        }

        .invoice-body{
            padding:20px;
        }

        .invoice-body p{
            margin-bottom:8px;
            font-size:14px;
        }

        .invoice-footer{
            border-top:1px solid #eef2f6;
            padding:14px 18px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:#fafbfe;
        }

        .badge-status{
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:700;
        }

        .btn-view{
            border-radius:30px;
            padding:6px 14px;
            font-size:13px;
        }

        .icon-circle{
            width:40px;
            height:40px;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
            background:#00A8FF;
        }

        .btn.btn-primary.btn-view{
            background-color: #00A8FF !important;
            border-color: #00A8FF !important;
            color: #fff !important;
        }

        .status-paid{
            color: #08de61;
            font-weight: 700;
        }

        .status-partial{
            color: #ff9800;
            font-weight: 700;
        }

        .status-unpaid{
            color: #f90d25;
            font-weight: 700;
        }

    </style>

    <main class="main">

        <section class="ourClinics">
            <div class="container mt-5 mb-6">
        
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h2 class="section-title" style="color:#00A8FF;">My Invoices</h2>
                        <p class="text-muted">Here you can view all invoices related to your appointments</p>
                    </div>
                </div>
        
                <div class="invoice-wrapper">
        
                    <!-- ============ INVOICE 1 ============ -->
                    @foreach ($invoices as $invoice)
                        <div class="invoice-card" data-aos="fade-up">
            
                            <div class="invoice-top">
                                <span>Invoice #{{ $invoice->id }}</span>
                                <span>{{ $invoice->invoice_date }}</span>
                            </div>
            
                            <div class="invoice-body">
                                <p><strong>Clinic:</strong> {{ $invoice->appointment->clinic->name }}</p>
                                <p><strong>Department:</strong> {{ $invoice->appointment->department->name }}</p>
                                <p><strong>Doctor:</strong> {{ $invoice->appointment->doctor->employee->user->name }}</p>
                                <p><strong>Total:</strong> ${{ $invoice->total_amount }}</p>
                                <p><strong>Paid:</strong> ${{ $invoice->paid_amount }}</p>
                                <p><strong>Payment Method:</strong> {{ $invoice->payment_method }}</p>
                                <p>
                                    <strong>Payment Status:</strong>
                                    @if ($invoice->payment_status === 'Paid')
                                        <span class="status-paid">Paid</span>
                                    @elseif ($invoice->payment_status === 'Partially Paid')
                                        <span class="status-partial">Partially Paid</span> 
                                    @else
                                        <span class="status-unpaid">Unpaid</span> 
                                    @endif
                                </p>
                            </div>
            
                            <div class="invoice-footer">
                                <span><i class="fa-solid fas fa-calendar-alt"></i> Appointment {{ $invoice->appointment->status }}</span>
                                <a href="{{ route('patient.details_invoice' , ['id' => $invoice->id]) }}" class="btn btn-primary btn-view">View Details</a>
                            </div>
            
                        </div>
                    @endforeach
        
                </div>
            </div>
        </section>
    </main>
@endsection
