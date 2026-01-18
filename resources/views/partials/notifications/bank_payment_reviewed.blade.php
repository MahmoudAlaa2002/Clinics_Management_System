@php
    $data   = $notification->data;
    $status = $data['status'] ?? null;
@endphp

@if($status === 'approved')
    Your bank payment has been
    <strong>approved</strong>.
    Your appointment at
    <strong>{{ $data['clinic_name'] }}</strong>
    has been confirmed successfully.

    
@elseif($status === 'rejected')
    Your bank payment has been
    <strong>rejected</strong>.
    Please review the payment details and try again.
@endif
