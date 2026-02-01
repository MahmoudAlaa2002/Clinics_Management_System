<style>
    .nav-notification {
        margin-left: 18px;
        position: relative;
    }

    .notification-bell {
        position: relative;
        font-size: 22px;
        color: white;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .notification-bell:hover {
        color: #e6f3ff;
        text-decoration: none !important;
    }

    .notification-bell::after {
        display: none !important;
    }

    /* Facebook style badge */
    .notification-badge {
        position: absolute;
        top: -16px;
        right: -8px;
        background: #e41e3f;
        color: white;
        border-radius: 999px;
        font-weight: 900;

        font-size: 11px;
        /* 🔢 حجم الرقم */
        width: 18px;
        /* 🔴 عرض الدائرة */
        height: 15px;
        /* 🔴 ارتفاع الدائرة */

        display: flex;
        align-items: center;
        justify-content: center;
    }



    /* ==== DROPDOWN ==== */
    .notification-dropdown {
        position: absolute;
        top: 48px;
        right: 0;
        width: 360px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .15);
        display: none;
        overflow: hidden;
        z-index: 9999;
    }

    .notification-dropdown {
        display: none;
    }

    .notification-header {
        padding: 14px;
        background: #f4f7fb;
        font-weight: 800;
        text-align: center;
        border-bottom: 1px solid #e5e9f0;
    }

    .notification-item {
        display: flex;
        gap: 12px;
        padding: 14px;
        transition: .2s;
        cursor: pointer;
    }

    .notification-item:hover {
        background: #f1f6ff;
    }

    .notification-icon {
        width: 42px;
        height: 42px;
        background: #e9f1ff;
        color: #007bff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .notification-text {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }

    .notification-time {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    /* ==== USER ==== */
    .auth-links {
        margin-left: 35px;
        position: relative;
        font-size: 24px;
        color: white;
        cursor: pointer;
    }

    .auth-links {
        margin-right: 25px;
    }


    .notification-bell i {
        font-size: 20px !important;
    }

    .notification-bell i {
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
    }

    .notification-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-empty {
        padding: 40px;
        text-align: center;
        color: #9ca3af;
    }

    .notification-text {
        white-space: normal;
        word-break: break-word;
    }

    .notification-dropdown.open {
        display: block;
    }

    /* ===== Premium Notification UI ===== */

    .notification-dropdown {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(14px);
        border-radius: 18px;
        box-shadow:
            0 30px 80px rgba(0, 0, 0, .18),
            0 0 0 1px rgba(255, 255, 255, .6) inset;
        border: 1px solid rgba(0, 0, 0, .04);
    }

    .notification-header {
        font-size: 15px;
        font-weight: 900;
        letter-spacing: .3px;
        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        color: #0f172a;
        border-bottom: 1px solid rgba(0, 0, 0, .05);
    }


    .notification-item {
        border-radius: 14px;
        margin: 6px 10px;
        padding: 14px 14px;
        background: transparent;
        position: relative;
        overflow: hidden;
    }

    .notification-item:hover {
        background: linear-gradient(135deg, #eef6ff, #f6faff);
        box-shadow: 0 10px 30px rgba(0, 123, 255, .08);
    }

    /* Unread highlight */
    .notification-item.unread {
        background: linear-gradient(135deg, #e9f2ff, #f4f8ff);
        border-left: 4px solid #3b82f6;
    }

    /* Icon bubble */
    .notification-icon {
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
        box-shadow: 0 6px 14px rgba(59, 130, 246, .25);
    }

    /* Text */
    .notification-text {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.4;
    }

    .notification-time {
        font-size: 11px;
        color: #64748b;
    }


    /* @keyframes pulse{
        0%{ box-shadow:0 0 0 0 rgba(228,30,63,.6); }
        70%{ box-shadow:0 0 0 10px rgba(228,30,63,0); }
        100%{ box-shadow:0 0 0 0 rgba(228,30,63,0); }
    } */

    /* ================= CMS STYLE FOR EXISTING NOTIFICATIONS ================= */

    .notification-dropdown {
        width: 450px !important;
        border-radius: 14px !important;
        border: 1px solid #e6ecf3 !important;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .12) !important;
        overflow: hidden;
        background: #fff;
    }

    /* Header */
    .notification-header {
        padding: 16px 18px !important;
        font-weight: 800;
        background: #f7f9fc !important;
        border-bottom: 1px solid #eaeef6 !important;
        text-align: center;
        font-size: 16px;
        letter-spacing: .5px;
    }

    /* List */
    .notification-list {
        max-height: 420px !important;
        overflow-y: auto;
    }

    /* Item */
    .notification-item {
        display: flex;
        gap: 14px;
        padding: 14px 18px !important;
        text-decoration: none;
        transition: .25s ease;
        border-radius: 0;
    }

    /* Hover */
    .notification-item:hover {
        background: #f1f6ff !important;
    }

    /* Unread */
    .notification-item.unread {
        background: #f4f8ff !important;
    }

    /* Icon */
    .notification-icon {
        width: 44px !important;
        height: 44px !important;
        background: #e7f0ff !important;
        color: #007bff !important;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px !important;
        flex-shrink: 0;
    }

    /* Text */
    .notification-text {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #1f2937 !important;
    }

    /* Time */
    .notification-time {
        font-size: 12px !important;
        color: #6b7280 !important;
        margin-top: 4px;
    }

    /* Empty */
    .notification-empty {
        padding: 50px !important;
        text-align: center;
        color: #9ca3af !important;
    }

    /* Footer */
    .notification-footer {
        display: block;
        padding: 14px !important;
        text-align: center;
        background: #f7f9fc !important;
        border-top: 1px solid #eaeef6 !important;
        font-weight: 700;
        text-decoration: none;
        color: #007bff !important;
    }

    .notification-dropdown a.notification-footer {
        color: #000 !important;
        text-align: center !important;
        display: block;
    }

    .notification-dropdown a.notification-footer:hover {
        color: #000 !important;
        text-decoration: none !important;
    }

    .notification-icon {
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

    .notification-icon i {
        color: #ffffff;
        font-size: 24px !important;
        margin-right: 5px;
        margin-bottom: 3px;
        display: block !important;
        line-height: 1 !important;
        position: relative;
        top: 1px;
        /* تعويض انحراف FontAwesome */
    }
</style>

<header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center justify-content-between">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('patient.home') }}" class="logo d-flex align-items-center me-auto"
                style="margin-left: 30px;">
                <img src="{{ asset('patients/img/logo.png') }}" width="40" height="40" alt="">
                <span style="font-size: 24px;"><strong>Clinics Management</strong></span>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li>
                        <a class="{{ request()->routeIs('patient.home') ? 'active' : '' }}"
                            href="{{ route('patient.home') }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.clinics_view') ? 'active' : '' }}"
                            href="{{ route('patient.clinics_view') }}">
                            Clinics
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.doctors_view') ? 'active' : '' }}"
                            href="{{ route('patient.doctors_view') }}">
                            Doctors
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.myAppointments') ? 'active' : '' }}"
                            href="{{ route('patient.myAppointments') }}">
                            My Appointments
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.invoices_view') ? 'active' : '' }}"
                            href="{{ route('patient.invoices_view') }}">
                            Invoices
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('chat_contacts') ? 'active' : '' }}"
                            href="{{ route('chat_contacts') }}">
                            Chats
                        </a>
                    </li>

                    <li class="nav-notification">
                        <a class="notification-bell">
                            <i class="fa-solid fa-bell"></i>
                            <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                        </a>

                        <div class="notification-dropdown">

                            <div class="notification-header">Notifications</div>

                            <div class="notification-list">

                                @forelse(auth()->user()->notifications->take(10) as $notification)

                                    @php
                                        $type = $notification->data['type'] ?? 'default';

                                        $icon = match ($type) {
                                            'appointment_booked' => 'fa-calendar-plus',
                                            'appointment_accepted' => 'fa-calendar-check',
                                            'appointment_cancelled' => 'fa-calendar-xmark',
                                            'appointment_completed' => 'fa-check-circle',
                                            'appointment_rejected' => 'fa-calendar-xmark',
                                            'invoice_created' => 'fa-file-invoice',
                                            'invoice_cancelled' => 'fa-ban',
                                            'patient_registered' => 'fa-user-plus',
                                            'patient_added' => 'fa-user-plus',
                                            'nurse_task_assigned' => 'fa-tasks',
                                            'nurse_task_completed' => 'fa-user-nurse',
                                            default => 'fa-bell',
                                        };
                                    @endphp

                                    @php
                                        $isBankPayment = in_array($type, ['bank_payment_reviewed']);
                                    @endphp

                                    @if($isBankPayment)

                                        {{-- إشعار عرض فقط (بدون رابط) --}}
                                        <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                                            <div class="notification-icon">
                                                <i class="fa {{ $icon }}"></i>
                                            </div>

                                            <div class="notification-content">
                                                <div class="notification-text">
                                                    @includeIf('partials.notifications.' . $type, ['notification' => $notification])
                                                </div>

                                                <div class="notification-time">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>

                                    @else

                                        {{-- إشعار عادي مع رابط --}}
                                        <a href="{{ route('notifications_read', $notification->id) }}"
                                            class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">

                                            <div class="notification-icon">
                                                <i class="fa {{ $icon }}"></i>
                                            </div>

                                            <div class="notification-content">
                                                <div class="notification-text">
                                                    @includeIf('partials.notifications.' . $type, ['notification' => $notification])
                                                </div>

                                                <div class="notification-time">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </a>

                                    @endif


                                @empty
                                    {{-- لا يوجد إشعارات --}}
                                    <div class="notification-empty">
                                        No notifications yet
                                    </div>
                                @endforelse

                            </div>



                            <a href="{{ route('notifications_index') }}" class="notification-footer">
                                View all notifications
                            </a>


                        </div>
                    </li>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>

        <div class="auth-links">

            <i class="fa-solid fa-circle-user"></i>
            <div class="informationAboutuser">
                <div class="name">
                    <a href="{{ route('patient.view_profile') }}"><span
                            style="color: #00A8FF;">{{ Auth::user()->name }}</span></a>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="myAppointment">
                    <span style="color: #00A8FF;"><a href="{{ route('patient.myAppointments') }}">My
                            Appointments</a></span>
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="settings">
                    <a href="{{ route('patient.settings') }}">
                        <span style="color: #00A8FF;">
                            Settings
                        </span>
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </div>

                <div>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span style="color: #00A8FF;">Logout</span> <i class="fa fa-sign-out"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
</header>


<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

{{-- @include('Backend.chat.echo-core') --}}

<script>
    window.CMS = window.CMS || {};
    window.CMS.userId = {{ auth()->id() }};
</script>


<script>

    document.addEventListener('DOMContentLoaded', function () {
        const bell = document.querySelector('.notification-bell');
        const dropdown = document.querySelector('.notification-dropdown');

        // toggle when clicking bell
        bell.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        // close when clicking outside
        document.addEventListener('click', function () {
            dropdown.classList.remove('open');
        });

        // prevent closing when clicking inside dropdown
        dropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });


    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ config('broadcasting.connections.pusher.key') }}",
        wsHost: "{{ config('broadcasting.connections.pusher.options.host') }}",
        wsPort: "{{ config('broadcasting.connections.pusher.options.port') }}",
        wssPort: "{{ config('broadcasting.connections.pusher.options.port') }}",
        forceTLS: "{{ config('broadcasting.connections.pusher.options.scheme') }}" === 'https',
        encrypted: true,
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
        cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
        }
    });


    Echo.private('App.Models.User.' + window.CMS.userId)
        .notification((notification) => {

            fetch(`/patient/notifications/render/${notification.id}`)
                .then(res => res.text())
                .then(html => {

                    const list = document.querySelector('.notification-list');
                    if (!list) return;

                    // احذف رسالة "No notifications yet" إن وجدت
                    const empty = list.querySelector('.notification-empty');
                    if (empty) {
                        empty.remove();
                    }

                    // أضف الإشعار الجديد
                    list.insertAdjacentHTML('afterbegin', html);

                    // تحديث العداد
                    const badge = document.querySelector('.notification-badge');
                    badge.innerText = parseInt(badge.innerText || 0) + 1;
                    badge.style.display = 'flex';

                    // refresh بصري خفيف
                    list.style.display = 'none';
                    list.offsetHeight;
                    list.style.display = 'block';
                });
        });


</script>