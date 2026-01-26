@extends('Backend.patients.master')

@section('title' , 'Payment Method')

@section('content')

    <style>
        .payment-wrapper{
            max-width:900px;
            margin:auto;
            padding:60px 20px;
        }

        .payment-title{
            text-align:center;
            margin-bottom:40px;
        }

        .payment-title h2{
            font-weight:900;
            color:#00A8FF;
        }

        .payment-title p{
            color:#6b7280;
            margin-top:10px;
        }

        .payment-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:30px;
        }

        .payment-card{
            background:#fff;
            border-radius:20px;
            border:2px solid #e5e7eb;
            padding:40px 30px;
            text-align:center;
            cursor:pointer;
            transition:all .25s ease;
            box-shadow:0 20px 50px rgba(0,0,0,.06);
        }

        .payment-card:hover{
            border-color:#00A8FF;
            transform:translateY(-6px);
            box-shadow:0 25px 70px rgba(0,168,255,.25);
        }

        .payment-icon{
            font-size:60px;
            margin-bottom:20px;
        }

        .paypal{ color:#003087; }
        .bank{ color:#0f766e; }

        .payment-name{
            font-size:22px;
            font-weight:900;
            margin-bottom:10px;
        }

        .payment-desc{
            color:#6b7280;
            font-size:14px;
        }

        .secure-note{
            margin-top:50px;
            text-align:center;
            font-size:14px;
            color:#6b7280;
        }
    </style>

    <div class="payment-wrapper">

        <div class="payment-title">
            <h2>Select Payment Method</h2>
            <p>Choose how you would like to pay for your appointment</p>
        </div>

        <div class="payment-grid">

            <!-- PayPal -->
            @if($hasPaypal)
                <div class="payment-card" onclick="payWith('paypal')">
                    <div class="payment-icon paypal">
                        <i class="fab fa-paypal"></i>
                    </div>
                    <div class="payment-name">PayPal</div>
                    <div class="payment-desc">
                        Pay securely using your PayPal account or credit card
                    </div>
                </div>
            @else
                <div class="payment-card paypal disabled"
                    onclick="showPaypalUnavailable()">
                    <div class="payment-icon paypal">
                        <i class="fab fa-paypal"></i>
                    </div>
                    <div class="payment-name" style="color:#434242;">PayPal</div>
                    <p class="text-danger">Unavailable</p>
                </div>
            @endif

            <!-- Bank of Palestine -->
            <div class="payment-card" onclick="payWith('bank')">
                <div class="payment-icon bank">
                    <img src="{{ asset('assets/img/payments/bank.png') }}">
                </div>
                <div class="payment-name">Bank Palestine</div>
                <div class="payment-desc">
                    Pay directly using Bank of Palestine online services
                </div>
            </div>

        </div>

        <div class="secure-note">
            🔒 All payments are encrypted and 100% secure
        </div>

    </div>

    <script>
        function payWith(method) {
            let holdId = "{{ $hold->id ?? '' }}";

            if(!holdId){
                alert('Invalid payment session');
                return;
            }

            if(method === 'paypal'){
                window.location.href = "/patient/paypal/pay/" + holdId;
            }

            if(method === 'bank'){
                window.location.href = "/patient/bank-qr/pay/" + holdId;
            }
        }


        function showPaypalUnavailable() {
            alert(
                "PayPal payment is currently unavailable for this clinic.\n\n" +
                "Please choose another payment method or try again later."
            );
        }


    </script>


@endsection
