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

                                            {{-- لما الدكتور يطلب مهمة من الممرض --}}
                                            @case('new_nurse_task')
                                                A new task has been assigned to you by
                                                <strong>{{ $data['doctor_name'] ?? 'Doctor' }}</strong>.
                                                @break

                                            {{-- عند اكتمال الموعد وإنشاء سجل طبي --}}
                                            @case('appointment_completed')
                                                The appointment with
                                                <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                                has been completed, and a medical record has been successfully created for the patient.
                                                @break

                                            @default
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
            <a href="{{ route('nurse.notifications_view') }}">View all Notifications</a>
        </div>
    </div>
</li>
