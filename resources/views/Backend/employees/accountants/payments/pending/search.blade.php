@if($payments->count() > 0)
    @foreach ($payments as $payment)
        <tr data-appointment="{{ $payment->id }}">
            <td data-field="id">{{ $payment->id }}</td>
            <td data-field="patient">{{ $payment->hold->patient->user->name }}</td>
            <td data-field="amount">$ {{ $payment->hold->amount }}</td>
            <td data-field="reference_number">{{ $payment->reference_number }}</td>
            <td data-field="receipt">
                <img src="{{ asset($payment->receipt) }}"
                     data-id="{{ $payment->id }}"
                     data-ref="{{ $payment->reference_number }}"
                     data-amount="{{ $payment->hold->amount }}"
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
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    <form action="{{ route('accountant.bank_payments.approve', $payment->id) }}" method="POST" style="display:inline-block; margin-right:4px;">
                        @csrf
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Approve">
                            <i class="fa fa-check"></i>
                        </button>
                    </form>
              
                    <form action="{{ route('accountant.bank_payments.reject', $payment->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" title="Reject">
                            <i class="fa fa-times"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px; margin-top:15px;">No Payments Found</strong>
        </td>
    </tr>
@endif



