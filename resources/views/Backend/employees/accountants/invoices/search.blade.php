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
                        <a href="{{ route('accountant.details_invoice', ['id' => $invoice->id]) }}" class="mr-1 btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Details Invoice">
                            <i class="fa fa-eye"></i>
                        </a>

                        {{-- تعديل الفاتورة (فقط إذا لم تكن مدفوعة) --}}
                        @if($invoice->payment_status !== 'Paid')
                            <a href="{{ route('accountant.edit_invoice', $invoice->id) }}"
                                data-bs-toggle="tooltip" title="Edit Invoice"
                                class="mr-1 btn btn-outline-primary btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endif

                    @else
                        <a href="{{ route('accountant.details_refund_invoice', ['id' => $invoice->id]) }}" class="mr-1 btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Details Refund Invoice">
                            <i class="fa fa-eye"></i>
                        </a>

                        @if($invoice->refund_date === null)
                            <a href="{{ route('accountant.refund_confirm', ['id' => $invoice->id]) }}"
                                data-bs-toggle="tooltip" title="Add Refund Confirmation Date"
                                class="mr-1 btn btn-outline-primary btn-sm">
                                <i class="fa fa-calendar-check"></i>
                            </a>
                        @endif
                    @endif


                    <a href="{{ route('accountant.profile_patient', ['id' => $invoice->patient->id]) }}"
                        data-bs-toggle="tooltip" title="Profile Patient"
                        class="mr-1 btn btn-outline-warning btn-sm text-white-hover">
                        <i class="fas fa-user-injured"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center">
            <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                No Invoices Found
            </div>
        </td>
    </tr>
@endif
