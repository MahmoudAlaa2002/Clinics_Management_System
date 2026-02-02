@if($payments->count() > 0)
    @foreach ($payments as $payment)

        @php
            $source = $payment->status === 'approved'
                ? $payment->appointment
                : $payment->hold;
        @endphp

        <tr data-payment="{{ $payment->id }}">
            <td>{{ $payment->id }}</td>

            <td>
                {{ $source->patient->user->name }}
            </td>

            <td>
                $ {{ $source->amount ?? $source->consultation_fee }}
            </td>

            <td>
                {{ $payment->reference_number }}
            </td>

            <td data-field="receipt">
                <img src="{{ asset('storage/'.$payment->receipt) }}"
                    data-id="{{ $payment->id }}"
                    data-ref="{{ $payment->reference_number }}"
                    data-amount="{{ $source->amount ?? $source->consultation_fee }}"
                    width="80" height="80"
                    style="object-fit:cover;border-radius:6px;cursor:pointer;">
            </td>

            <td class="status-cell">
                @if($payment->status === 'pending')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#ffc107; color:white;">
                        Pending
                    </span>
                @elseif($payment->status === 'approved')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#14ea6d; color:white;">
                        Approved
                    </span>
                @elseif($payment->status === 'rejected')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#f90d25; color:white;">
                        Rejected
                    </span>
                @endif
            </td>

            <td>
                <a href="{{ route('accountant.bank_payments.pending.details', ['payment' => $payment->id]) }}" class="mr-1 btn btn-outline-success btn-sm"
                    data-bs-toggle="tooltip" title="Payment Details"><i class="fa fa-eye"></i></a>
            </td>
        </tr>

    @endforeach
@else
    <tr>
        <td colspan="7" class="p-4 text-center">
            <strong style="font-size:18px;">No Payments Found</strong>
        </td>
    </tr>
@endif
