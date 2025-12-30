@php
    $data = $notification->data;
    $user = auth()->user();

    $type = $data['type'] ?? $data['message_key'] ?? null;

    $icon = match ($type) {
        'appointment_accepted'   => 'fa-check-circle',
        'appointment_booked'     => 'fa-calendar-check',
        'appointment_cancelled'  => 'fa-calendar-xmark',
        'appointment_completed'  => 'fa-circle-check',
        'appointment_rejected'   => 'fa-times-circle',
        'invoice_cancelled'      => 'fa-ban',
        'invoice_created'        => 'fa-file-invoice-dollar',
        'nurse_task_assigned'    => 'fa-tasks',
        'nurse_task_completed'   => 'fa-user-nurse',
        'patient_added'          => 'fa-user-plus',
        'patient_registered'     => 'fa-user-plus',
        default                  => 'fa-bell-o',
    };
@endphp

<li class="notification-message {{ $notification->read_at ? 'read' : 'unread' }}">
    <a href="{{ route('notifications_read', $notification->id) }}">
        <div class="media">

            <span class="avatar d-flex align-items-center justify-content-center"
                  style="background:#e7f0ff;color:#00A8FF;border-radius:50%;width:50px;height:50px;">
                <i class="fa {{ $icon }}" style="font-size: 24px;"></i>
            </span>

            <div class="media-body">

                <p class="noti-details" style="color:black;">
                    @includeIf('partials.notifications.' . $type, [
                        'notification' => $notification
                    ])
                </p>

                <p class="noti-time">
                    <span class="notification-time">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </p>

            </div>
        </div>
    </a>
</li>
