@if($invoices->count() > 0)
    @foreach ($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->appointment_id }}</td>
            <td>{{ $invoice->patient->user->name ?? 'Unknown' }}</td>
            <td>${{ number_format($invoice->total_amount, 2) }}</td>
            <td>{{ $invoice->invoice_date }}</td>
            <td>{{ $invoice->due_date }}</td>
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
                    <a href="{{ route('details_invoice', ['id' => $invoice->id]) }}" class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('edit_invoice', ['id' => $invoice->id]) }}" class="mr-1 btn btn-outline-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm delete-invoice" data-id="{{ $invoice->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
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
