<style>
    .notification-icon{
        width: 50px;
        height: 50px;
        background: #00A8FF !important;
        border-radius: 50%;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0;
        position: relative;
    }

    .notification-icon i{
        color: #ffffff;
        font-size: 24px !important;
        margin-right: 5px;
        margin-bottom: 3px;
        display: block !important;
        line-height: 1 !important;
        position: relative;
        top: 1px; 
    }

</style>

@php
    $data = $notification->data;
    $user = auth()->user();

    $type = $data['type'] ?? $data['message_key'] ?? null;

    $icon = match ($type) {
        'appointment_booked'     => 'fa-calendar-plus',
        'appointment_accepted'   => 'fa-calendar-check',
        'appointment_cancelled'  => 'fa-calendar-xmark',
        'appointment_completed'  => 'fa-check-circle',
        'appointment_rejected'   => 'fa-calendar-xmark',
        'invoice_created'        => 'fa-file-invoice',
        'invoice_cancelled'      => 'fa-ban',
        'patient_registered'     => 'fa-user-plus',
        'patient_added'          => 'fa-user-plus',
        'nurse_task_assigned'    => 'fa-tasks',
        'nurse_task_completed'   => 'fa-user-nurse',
        default                  => 'fa-bell',
    };
@endphp

<a href="{{ route('notifications_read',$notification->id) }}"
    class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
 
     <div class="notification-icon">
         <i class="fa {{ $icon }}"></i>
     </div>
 
     <div class="notification-content">
         <div class="notification-text">
             @include('partials.notifications.' . $type, ['notification'=>$notification])
         </div>
 
         <div class="notification-time">
             {{ $notification->created_at->diffForHumans() }}
         </div>
     </div>
</a>
 