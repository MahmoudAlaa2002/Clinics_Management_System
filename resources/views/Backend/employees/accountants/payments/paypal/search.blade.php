@if($payments->count())

    @foreach ($payments as $payment)


        <tr>
            <td>{{ $payment->id }}</td>
            <td style="max-width:220px; word-break:break-all;">{{ $payment->paypal_order_id }}</td>
            <td>{{ $payment->patient->user->name ?? '—' }}</td>
            <td>$ {{ number_format($payment->amount, 2) }}</td>

            <td>
                @if($payment->status === 'COMPLETED')
                    <span class="status-badge"
                        style="background:#14ea6d;color:white;
                        padding:8px 14px;border-radius:50px;">
                        Completed
                    </span>

                @elseif($payment->status === 'FAILED')
                    <span class="status-badge"
                        style="background:#f90d25;color:white;
                        padding:8px 14px;border-radius:50px;">
                        Failed
                    </span>

                @elseif($payment->status === 'CREATED')
                    <span class="status-badge"
                        style="background:#ffc107;color:white;
                        padding:8px 14px;border-radius:50px;">
                        Created
                    </span>

                @elseif($payment->status === 'REFUNDED')
                    <span class="status-badge"
                        style="background:#6c757d;color:white;
                        padding:8px 14px;border-radius:50px;">
                        Refunded
                    </span>
                @endif
            </td>

            <td>{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d') : '—' }}</td>

            <td><a href="{{ route('accountant.paypal_payments.details' , ['payment' => $payment->id]) }}" class="btn btn-outline-success btn-sm"
                data-bs-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></a></td>
        </tr>

    @endforeach

@else
    <tr>
        <td colspan="7" class="p-4 text-center">
            <strong style="font-size:18px;">No PayPal Payments Found</strong>
        </td>
    </tr>
@endif
