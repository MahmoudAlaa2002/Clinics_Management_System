<li class="nav-item dropdown d-none d-sm-block">
    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="float-right badge badge-pill bg-danger">
            @php
                $count = auth()->user()->unreadNotifications->count();
            @endphp

            @if ($count < 100)
                {{ $count }}
            @else
                99+
            @endif
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
                                    <img alt="Notification" src="{{ asset($notification->data['image']) }}" class="img-fluid">
                                </span>
                                <div class="media-body">
                                    @php
                                        $data = $notification->data;
                                        $key = $data['message_key'] ?? null;
                                    @endphp

                                    <p class="noti-details" style="color:black;">
                                        @switch($key)

                                            @case('patient_added_by_receptionist')
                                                A new patient
                                                <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                                was added by receptionist
                                                <strong>{{ $data['receptionist_name'] ?? '' }}</strong>
                                                at your clinic.
                                                @break

                                            {{-- لما المريض يحجز موعد --}}
                                            @case('appointment_booked')
                                                A new appointment for
                                                <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                                has been booked at your clinic.
                                                @break

                                            @case('appointment_booked_by_receptionist')
                                                An appointment for
                                                <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                                was booked by the receptionist
                                                <strong>{{ $data['receptionist_name'] ?? '' }}</strong>
                                                at your clinic.
                                                @break


                                            @default
                                                {{-- إشعارات قديمة --}}
                                                {{ $data['message'] ?? 'New notification' }}
                                        @endswitch
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
            <a href="{{ route('clinic.notifications_view') }}">View all Notifications</a>
        </div>
    </div>
</li>
