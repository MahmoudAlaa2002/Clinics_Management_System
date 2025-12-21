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

                                <span class="avatar">
                                    <img
                                        src="{{ asset($notification->data['image'] ?? 'assets/img/user.jpg') }}"
                                        class="img-fluid"
                                        alt="Notification"
                                    >
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
            <a href="{{ route('notifications_view') }}">View all Notifications</a>
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
