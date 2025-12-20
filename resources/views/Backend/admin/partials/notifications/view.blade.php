@extends('Backend.admin.master')

@section('title', 'All Notifications')

@section('content')

<style>
    body {
        background-color: #f4f7fe;
    }

    .notifications-container {
        max-width: 900px;
        margin: auto;
    }

    .notification-card {
        position: relative;
        display: flex;
        gap: 18px;
        align-items: flex-start;
        padding: 22px 24px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 18px;
        transition: all .35s ease;
        overflow: hidden;
    }

    .notification-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: transparent;
        transition: all .35s ease;
    }

    .notification-card.unread::before {
        background: linear-gradient(180deg, #007BFF, #00C6FF);
    }

    .notification-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.12);
    }

    .notification-icon {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #007BFF, #00C6FF);
        color: #fff;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #1f2937;
    }

    .notification-body {
        font-size: 15px;
        color: #4b5563;
        line-height: 1.6;
    }

    .notification-time {
        font-size: 13px;
        color: #9ca3af;
        margin-top: 10px;
    }

    .page-title {
        font-weight: 800;
        font-size: 26px;
        color: #1e293b;
    }

    .pagination-wrapper {
        margin-top: 30px;
    }

    .empty-notifications {
        text-align: center;
        padding: 80px 0;
        color: #9ca3af;
        font-size: 18px;
    }
</style>


<div class="page-wrapper">
    <div class="content">

        <div class="row mb-4">
            <div class="col">
                <h4 class="page-title">🔔 Notifications</h4>
            </div>
        </div>

        <div class="notifications-container">

            @forelse($notifications as $notification)

                @php
                    $data = $notification->data;
                    $key  = $data['message_key'] ?? null;

                    $icon = match ($key) {

                    // جميع حالات إضافة مريض
                    'patient_registered',
                    'patient_added_by_clinic_manager',
                    'patient_added_by_receptionist'
                        => 'fa-user-plus',

                    // جميع حالات حجز موعد
                    'appointment_booked',
                    'appointment_booked_by_receptionist'
                        => 'fas fa-calendar-day',

                    // أي إشعار آخر
                    default => 'fa-bell',
                    };
                @endphp

                <a href="{{ route('notifications_read', $notification->id) }}"
                   style="text-decoration:none;color:inherit">

                    <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}">

                        <div class="notification-icon">
                            <i class="fas {{ $icon }}"></i>
                        </div>

                        <div class="notification-content">

                            <div class="notification-title">
                                {{ $data['title'] ?? 'Notification' }}
                            </div>

                            <div class="notification-body">
                                @switch($key)

                                    {{-- تسجيل مريض جديد بنفسه --}}
                                    @case('patient_registered')
                                        A new patient
                                        <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                        has registered in the system.
                                        @break

                                    {{-- إضافة مريض بواسطة مدير العيادة --}}
                                    @case('patient_added_by_clinic_manager')
                                        A new patient
                                        <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                        was added by clinic manager
                                        <strong>{{ $data['clinic_manager_name'] ?? '' }}</strong>
                                        at
                                        <strong>{{ $data['clinic_name'] ?? '' }}</strong>.
                                        @break

                                    {{-- إضافة مريض بواسطة موظف الاستقبال --}}
                                    @case('patient_added_by_receptionist')
                                        A new patient
                                        <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                        was added by receptionist
                                        <strong>{{ $data['receptionist_name'] ?? '' }}</strong>
                                        at
                                        <strong>{{ $data['clinic_name'] ?? '' }}</strong>.
                                        @break

                                    {{-- حجز موعد بواسطة المريض --}}
                                    @case('appointment_booked')
                                        A new appointment has been booked for
                                        <strong>{{ $data['patient_name'] ?? '' }}</strong>.
                                        @break

                                    {{-- حجز موعد بواسطة موظف الاستقبال --}}
                                    @case('appointment_booked_by_receptionist')
                                        An appointment has been booked for
                                        <strong>{{ $data['patient_name'] ?? '' }}</strong>
                                        by receptionist
                                        <strong>{{ $data['receptionist_name'] ?? '' }}</strong>.
                                        @break

                                    {{-- إشعارات قديمة فقط (احتياطي) --}}
                                    @default
                                        @if(!empty($data['message']))
                                            {{ $data['message'] }}
                                        @endif

                                @endswitch

                            </div>

                            <div class="notification-time">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>

                        </div>

                    </div>
                </a>

            @empty
                <div class="empty-notifications">
                    <i class="fas fa-bell-slash fa-2x mb-3"></i><br>
                    No notifications available
                </div>
            @endforelse

        </div>

        <div class="pagination-wrapper d-flex justify-content-center">
            {{ $notifications->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>

@endsection
