<style>
    .cms-notifications .dropdown-toggle {
        position: relative;
    }

    .cms-notification-dropdown {
        width: 450px !important;
        padding: 0;
        border-radius: 14px;
        border: 1px solid #e6ecf3;
        box-shadow: 0 15px 40px rgba(0,0,0,.12);
        overflow: hidden;
    }

    .cms-notification-header {
        padding: 16px 18px;
        font-weight: 800;
        background: #f7f9fc;
        border-bottom: 1px solid #eaeef6;
        text-align: center;
        font-size: 16px;
        letter-spacing: 0.5px;
    }

    .cms-notification-list {
        max-height: 420px;
        overflow-y: auto;
    }

    .cms-notification-item {
        display: flex;
        gap: 14px;
        padding: 14px 18px;
        text-decoration: none;
        color: inherit;
        transition: .25s ease;
    }

    .cms-notification-item:hover {
        background: #f1f6ff;
    }

    .cms-notification-item.unread {
        background: #f4f8ff;
    }

    .cms-notification-icon {
        width: 44px;
        height: 44px;
        background: #e7f0ff;
        color: #007bff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .cms-notification-content {
        flex: 1;
    }

    .cms-notification-text {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }

    .cms-notification-time {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    .cms-notification-empty {
        padding: 50px;
        text-align: center;
        color: #9ca3af;
    }

    .cms-notification-footer {
        display: block;
        padding: 14px;
        text-align: center;
        background: #f7f9fc;
        border-top: 1px solid #eaeef6;
        font-weight: 700;
        text-decoration: none;
        color: #007bff;
    }

</style>
<li class="nav-item dropdown cms-notifications">

    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell"></i>
        <span id="notification-count" class="badge badge-danger badge-pill">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
    </a>

    <div class="dropdown-menu cms-notification-dropdown">

        <div class="cms-notification-header">
            Notifications
        </div>

        <div class="cms-notification-list">

            @forelse(auth()->user()->notifications->take(10) as $notification)

                @php
                    $type = $notification->data['type'] ?? 'default';

                    $icon = match ($type) {
                        'appointment_booked'     => 'fa-calendar-plus',
                        'appointment_accepted'   => 'fa-calendar-check',
                        'appointment_cancelled'  => 'fa-calendar-xmark',
                        'appointment_completed' => 'fa-check-circle',
                        'invoice_created'        => 'fa-file-invoice',
                        'invoice_cancelled'      => 'fa-ban',
                        'patient_registered',
                        'patient_added'          => 'fa-user-plus',
                        default                  => 'fa-bell',
                    };
                @endphp

                <a href="{{ route('notifications_read', $notification->id) }}"
                   class="cms-notification-item {{ $notification->read_at ? 'read' : 'unread' }}">

                    <div class="cms-notification-icon">
                        <i class="fa {{ $icon }}"></i>
                    </div>

                    <div class="cms-notification-content">
                        <div class="cms-notification-text">
                            @includeIf('partials.notifications.' . $type, ['notification' => $notification])
                        </div>
                        <div class="cms-notification-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>

                </a>

            @empty
                <div class="cms-notification-empty">
                    No notifications
                </div>
            @endforelse

        </div>

        <a href="{{ route('notifications_index') }}" class="cms-notification-footer">
            View all notifications
        </a>

    </div>
</li>



<script>
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
