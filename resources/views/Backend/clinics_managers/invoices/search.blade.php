@if($invoices->count() > 0)
    @foreach ($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->appointment_id }}</td>
            <td>{{ $invoice->patient->user->name ?? 'Unknown' }}</td>
            @if ($statusFilter === 'Issued')
                <td>{{ $invoice->invoice_date }}</td>
                <td>{{ $invoice->due_date ?? '-' }}</td>
            @else
                <td>${{ number_format($invoice->refund_amount, 2) }}</td>
                <td>{{ $invoice->refund_date ?? '-' }}</td>
            @endif
            <td>
                @if ($invoice->payment_status === 'Paid')
                    <span class="status-badge"
                        style="min-width:140px; display:inline-block; text-align:center; padding:4px 12px;
                                font-size:18px; border-radius:50px; background-color:#14ea6d; color:white;">
                        Paid
                    </span>
                @elseif ($invoice->payment_status === 'Partially Paid')
                    <span class="status-badge"
                        style="min-width:140px; display:inline-block; text-align:center; padding:4px 12px;
                                font-size:18px; border-radius:50px; background-color:#ff9800; color:white;">
                        Partially Paid
                    </span>
                @else
                    <span class="status-badge"
                        style="min-width:140px; display:inline-block; text-align:center; padding:4px 12px;
                                font-size:18px; border-radius:50px; background-color:#f90d25; color:white;">
                        Unpaid
                    </span>
                @endif
            </td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    @if ($statusFilter === 'Issued')
                        <a href="{{ route('clinic.details_invoice', ['id' => $invoice->id]) }}" class="mr-1 btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Details Invoice">
                            <i class="fa fa-eye"></i>
                        </a>
                    @else
                        <a href="{{ route('clinic.details_refund_invoice', ['id' => $invoice->id]) }}" class="mr-1 btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Details Refund Invoice">
                            <i class="fa fa-eye"></i>
                        </a>
                    @endif
                    <a href="{{ route('clinic.profile_patient', ['id' => $invoice->patient->id]) }}" class="mr-1 btn btn-outline-warning btn-sm text-white-hover" data-bs-toggle="tooltip" title="Profile Patient">
                        <i class="fas fa-user-injured"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" class="text-center">
            <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                No Invoices Found
            </div>
        </td>
    </tr>
@endif
