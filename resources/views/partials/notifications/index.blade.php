@php
    $role = auth()->user()->role;

    $layout = match ($role) {
        'admin' => 'Backend.admin.master',
        'doctor' => 'Backend.doctors.master',
        'clinic_manager' => 'Backend.clinics_managers.master',
        'department_manager' => 'Backend.departments_managers.master',
        'employee' => 'Backend.employees.' . strtolower(auth()->user()->employee->job_title) . 's.master',
        default => 'Backend.patients.master',
    };
@endphp

@extends($layout)

@section('title', 'Notifications')

@section('content')

<style>
    .notifications-wrapper {
        max-width: 1100px;
        margin: auto;
        padding-top: 30px;
    }

    .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .notifications-header h4 {
        font-weight: 900;
        font-size: 28px;
        color: #0f172a;
    }

    .unread-count {
        background: #00A8FF;
        color: white;
        padding: 10px 22px;
        border-radius: 999px;
        font-weight: 800;
    }

    .notify-card {
        position: relative;
        display: flex;
        gap: 22px;
        padding: 24px 26px;
        border-radius: 22px;
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0,0,0,.08);
        transition: .35s;
    }

    .notify-card.unread::after {
        content: "";
        position: absolute;
        left: 0;
        top: 18px;
        bottom: 18px;
        width: 6px;
        border-radius: 99px;
        background: #00A8FF;
    }

    .notify-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 60px rgba(0,0,0,.18);
    }

    /* الدائرة الزرقاء + الأيقونة البيضاء */
    .notify-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        background: #00A8FF;   /* أزرق الموقع */
        color: #ffffff !important;       /* الأيقونة أبيض */
    }

    .notify-content {
        flex: 1;
    }

    .notify-message {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
    }

    .notify-time {
        margin-top: 6px;
        font-size: 13px;
        color: #64748b;
    }

    .notify-new {
        background: #00A8FF;
        color: white;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
    }

    .notify-read-icon {
        font-size: 22px;
        color: #22c55e;
    }

    .notification-empty {
        padding: 120px 0;
        text-align: center;
        font-size: 22px;
        font-weight: 800;
        color: #94a3b8;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="notifications-wrapper">

            {{-- Header --}}
            <div class="notifications-header">
                <h4>Notifications</h4>
                <div class="unread-count">
                    {{ auth()->user()->unreadNotifications->count() }} Unread
                </div>
            </div>

            {{-- Notifications --}}
            @if ($notifications->count() > 0)
                <div class="row">
                    @foreach ($notifications as $notification)

                        @php
                            $type = $notification->data['type'] ?? 'default';

                            $icon = match ($type) {
                                'appointment_booked'     => 'fa-calendar-plus-o',
                                'appointment_accepted'   => 'fa-calendar-check-o',
                                'appointment_cancelled'  => 'fa-calendar-times-o',
                                'appointment_rejected'   => 'fa-calendar-times-o',
                                'appointment_completed'  => 'fa-check-circle-o',

                                'invoice_created'        => 'fa-file-text-o',
                                'invoice_cancelled'      => 'fa-ban',

                                'nurse_task_assigned'    => 'fa-tasks',
                                'nurse_task_completed'   => 'fa-tasks',

                                'patient_registered'     => 'fa-user-plus',
                                'patient_added'          => 'fa-user-plus',

                                default                  => 'fa-bell-o',
                            };
                        @endphp

                        <div class="col-md-12 mb-4">
                            <a href="{{ route('notifications_read', $notification->id) }}"
                               class="text-decoration-none">

                                <div class="notify-card {{ is_null($notification->read_at) ? 'unread' : 'read' }}">

                                    {{-- ICON --}}
                                    <div class="notify-icon">
                                        <i class="fa {{ $icon }}"></i>
                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="notify-content">
                                        <div class="notify-message">
                                            @includeIf(
                                                'partials.notifications.' . ($notification->data['type'] ?? 'default'),
                                                ['notification' => $notification]
                                            )
                                        </div>

                                        <div class="notify-time">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    {{-- STATUS --}}
                                    <div>
                                        @if (is_null($notification->read_at))
                                            <span class="notify-new">NEW</span>
                                        @else
                                            <i class="fa fa-check-circle notify-read-icon"></i>
                                        @endif
                                    </div>

                                </div>
                            </a>
                        </div>

                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-5">
                    {{ $notifications->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="notification-empty">
                    🎉 You are all caught up!
                </div>
            @endif

        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
@endsection
