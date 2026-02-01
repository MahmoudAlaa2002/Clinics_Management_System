<style>
    .notification-message.unread {
        background-color: #f4f7fe;
    }

    .notification-message.read {
        opacity: 0.7;
    }

    .header .dropdown-menu {
        width: 240px;
        border-radius: 14px;
        border: 1px solid #e6ecf3;
        box-shadow: 0 14px 28px rgba(0, 0, 0, .08);
        padding: 10px 0;
        overflow: hidden;
    }

    .dropdown-user-header {
        padding: 14px 16px;
        background: #f7f9fc;
        border-bottom: 1px solid #eef2f8;
    }

    .dropdown-user-header .user-name {
        font-weight: 700;
        font-size: 15px;
    }

    .dropdown-user-header .user-role {
        color: #6c757d;
        font-size: 13px;
    }

    /* each item */
    .header .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: .25s ease;
    }

    /* icons */
    .header .dropdown-item i {
        width: 18px;
        text-align: center;
        color: #6c757d;
    }

    /* hover */
    .header .dropdown-item:hover {
        background: #00A8FF;
        color: #fff;
    }

    .header .dropdown-item:hover i {
        color: #fff;
    }

    /* divider line */
    .dropdown-divider {
        margin: 6px 0;
    }
</style>

<div class="header">
    <div class="header-left">
        <a href="{{ Route('doctor_dashboard') }}" class="logo">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.png') }}" width="35" height="35" alt="">
                <span><strong>CMS</strong></span>
            </div>
        </a>
    </div>
    <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
    <a id="mobile_btn" class="float-left mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
    <ul class="float-right nav user-menu">
        {{-- Notifications --}}
        @include('partials.notifications.notifications')
        @include('Backend.chat.index')
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" style="width: 40px; height:40px; margin-right:5px;"
                        src="{{ asset($doctor->image ?? 'assets/img/user.jpg') }}" alt="">
                </span>
                <span>
                    Doctor
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="dropdown-user-header">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">Department Manager</div>
                </div>
                <a class="dropdown-item" href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                <a class="dropdown-item" href="{{ route('doctor_profile') }}"><i class="fa fa-user"></i> My Profile</a>
                <a class="dropdown-item" href="{{ route('doctor.profile.edit') }}"><i class="fa fa-edit"></i> Edit
                    Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</div>

<!-- Pusher & Echo Scripts -->
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

<script>
    // Initialize global variables
    window.CMS = window.CMS || {};
    window.CMS.userId = {{ auth()->id() }};

    // Initialize Pusher & Echo
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '1fac67dc0f09b838e81c',
        cluster: 'eu',
        forceTLS: true,
        encrypted: true,
        enableLogging: true,

        authorizer: (channel, options) => {
            return {
                authorize: (socketId, callback) => {
                    fetch('/broadcasting/auth', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            socket_id: socketId,
                            channel_name: channel.name,
                        })
                    })
                        .then(response => response.json())
                        .then(data => callback(null, data))
                        .catch(error => {
                            console.error('Auth error:', error);
                            callback(error);
                        });
                }
            };
        },
    });

    console.log('✅ Doctor Echo initialized with cluster:', window.Echo.connector.pusher.config.cluster);

    // Listen for real-time notifications (Doctor version)
    Echo.private('App.Models.User.' + window.CMS.userId)
        .notification((notification) => {
            console.log('🔔 Doctor notification received:', notification);

            // Update notification badge if exists
            const badge = document.querySelector('.notification-badge, .badge');
            if (badge) {
                const currentCount = parseInt(badge.innerText || 0);
                badge.innerText = currentCount + 1;
                badge.style.display = 'inline-block';
            }

            // Fetch and render the notification HTML
            fetch(`/doctor/notifications/render/${notification.id}`)
                .then(res => res.text())
                .then(html => {
                    const notificationList = document.querySelector('.notification-list, .notifications-list');
                    if (!notificationList) return;

                    // Remove empty state if exists
                    const empty = notificationList.querySelector('.notification-empty, .no-notifications');
                    if (empty) empty.remove();

                    // Add new notification at the top
                    notificationList.insertAdjacentHTML('afterbegin', html);

                    // Optional: Show browser notification
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification('New Notification', {
                            body: notification.data?.message || 'You have a new notification',
                            icon: '/assets/img/logo.png'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching notification:', error);
                });
        });

    // Page reload on back/forward navigation
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>