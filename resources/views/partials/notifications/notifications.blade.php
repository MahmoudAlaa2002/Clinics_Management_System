<li class="nav-item dropdown d-none d-sm-block">
    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="float-right badge badge-pill bg-danger">
            @php
                $count = auth()->user()->unreadNotifications->count();
            @endphp
            {{ $count < 100 ? $count : '99+' }}
        </span>
    </a>

    <div class="dropdown-menu notifications">
        <div class="topnav-dropdown-header">
            <span>Notifications</span>
        </div>

        <div class="drop-scroll">
            <ul class="notification-list">

                @forelse(auth()->user()->notifications as $notification)
                    <li class="notification-message {{ $notification->read_at ? 'read' : 'unread' }}">

                        <a href="{{ route('notifications_read', $notification->id) }}">
                            <div class="media">

                                @php
                                    $type = $notification->data['type'] ?? 'default';

                                    $icon = match ($type) {

                                        // 📅 Appointments
                                        'appointment_booked'     => 'fa-calendar-plus-o',
                                        'appointment_accepted'   => 'fa-calendar-check-o',
                                        'appointment_cancelled'  => 'fa-calendar-times-o',
                                        'appointment_rejected'  => 'fa-calendar-times-o',
                                        'appointment_completed'  => 'fa-check-circle-o',

                                        // 💳 Invoices
                                        'invoice_created'        => 'fa-file-text-o',
                                        'invoice_cancelled'      => 'fa-ban',

                                        // 👩‍⚕️ Nurse Tasks
                                        'nurse_task_assigned'    => 'fa-tasks',
                                        'nurse_task_completed'   => 'fa-tasks',

                                        // 🧑 Patients
                                        'patient_registered'     => 'fa-user-plus',
                                        'patient_added'          => 'fa-user-plus',

                                        // 🔔 Default
                                        default                  => 'fa-bell-o',
                                    };

                                @endphp

                                <span class="avatar d-flex align-items-center justify-content-center"
                                    style="
                                        background:#e7f0ff;
                                        color:#00A8FF;
                                        border-radius:50%;
                                        width:50px;
                                        height:50px;">
                                    <i class="fa {{ $icon }}" style="font-size: 24px;"></i>
                                </span>


                                <div class="media-body">

                                    {{-- 🔔 Notification text --}}
                                    <p class="noti-details" style="color:black;">
                                        @php
                                            $type = $notification->data['type']
                                                ?? $notification->data['message_key']
                                                ?? null;
                                        @endphp

                                        @if ($type)
                                            @includeIf('partials.notifications.' . $type, [
                                                'notification' => $notification
                                            ])

                                        @else
                                            {{ $notification->data['message'] ?? 'New notification' }}
                                        @endif
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
                @empty
                    <li class="text-center notification-message" style="margin-top:130px;">
                        <span class="text-muted">No notifications available</span>
                    </li>
                @endforelse

            </ul>
        </div>

        <div class="topnav-dropdown-footer">
            <a href="{{ route('notifications_index') }}">View all Notifications</a>
        </div>
    </div>
</li>


<script>
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
