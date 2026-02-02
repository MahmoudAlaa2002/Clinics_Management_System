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

@section('title' , 'Contacts List')

@section('content')

    <style>

        .card{
            border:1px solid #ddd;
            border-radius:10px;
            box-shadow:0 6px 16px rgba(0,0,0,.06);
            overflow:hidden;
            margin-bottom:20px;
        }

        .card-header{
            background:#00A8FF;
            color:#fff;
            font-weight:600;
            padding:12px 15px;
            font-size:16px;
        }

        .contact-row{
            padding:14px 10px;
            border-bottom:1px solid #eef2f6;
            display:flex;
            justify-content:space-between;
            align-items:center;
            transition:.25s;
        }


        .avatar-wrapper{
            position:relative;
            width:42px;
            height:42px;
            margin-right:10px;
        }

        .avatar{
            width:42px;
            height:42px;
            border-radius:50%;
            background:#e8f4ff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            color:#0b4e7a !important;
            font-size:13px;
            overflow:hidden;
        }

        .avatar img{
            width:100%;
            height:100%;
            object-fit:cover;
            border-radius:50%;
        }

        .status-dot{
            position:absolute;
            right:0px;
            bottom:0px;
            width:12px;
            height:12px;
            border-radius:50%;
            border:2px solid #fff;
        }


        .status-dot.online{ background:#2ecc71; }
        .status-dot.offline{ background:#e74c3c; }

        .info strong{ font-size:15px; color:#062f4d; }
        .info small{ color:#6b7d92; display:block; margin-top:2px; font-size:11px; }

        .btn-chat{
            background:#00A8FF;
            border:none;
            padding:6px 14px;
            border-radius:8px;
            color:#fff !important;
            font-size:12px;
            font-weight:600;
        }

    </style>

    @if ($role == 'patient')
        <style>
            .card{
                margin-top:50px;
                margin-bottom:50px;
            }
        </style>
    @endif



<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        Available Contacts
                    </div>

                    <div class="card-body">
                        @forelse($contacts as $user)
                            <div class="contact-row">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar">
                                            @if($user->image)
                                                <img src="{{ asset('storage/'.$user->image) }}">
                                            @else
                                                @php
                                                    $abbr = match ($user->role) {
                                                        'admin'              => 'A',
                                                        'clinic_manager'     => 'CM',
                                                        'department_manager' => 'DM',
                                                        'doctor'             => 'DR',
                                                        'receptionist'       => 'RE',
                                                        'nurse'              => 'NU',
                                                        'accountant'         => 'AC',
                                                        'patient'            => 'PA',
                                                        default              => strtoupper(substr($user->name, 0, 2)),
                                                    };
                                                @endphp

                                                @if($user->image)
                                                    <img src="{{ asset('storage/'.$user->image) }}">
                                                @else
                                                    {{ $abbr }}
                                                @endif
                                            @endif
                                        </div>

                                        <span
                                            id="status-dot-{{ $user->id }}"
                                            class="status-dot {{ $user->is_online ? 'online' : 'offline' }}">
                                        </span>

                                    </div>

                                    <div class="info">

                                        <strong>{{ $user->name }}</strong>

                                        <small id="last-seen-{{ $user->id }}">
                                            @if($user->is_online)
                                                Online now
                                            @else
                                                Last seen:
                                                {{ optional($user->last_seen)->diffForHumans() ?? '—' }}
                                            @endif
                                        </small>

                                    </div>

                                </div>

                                <a href="{{ route('chat_open', $user->id) }}" class="btn-chat">
                                    Open Chat
                                </a>

                            </div>

                        @empty
                            <div class="text-center text-muted p-3">
                                No contacts available.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div id="clinics-pagination" class="pagination-wrapper d-flex justify-content-center">
                    {{ $contacts->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>

    </div>
</div>

@endsection


@section('js')
<script>

    let offlineTimers = {};

    Echo.join('online-users')

        // الموجودون داخل القناة الآن
        .here((users) => {

            users.forEach(u => {
                let dot  = document.getElementById(`status-dot-${u.id}`);
                let text = document.getElementById(`last-seen-${u.id}`);

                if (!dot || !text) return;

                if (offlineTimers[u.id]) {
                    clearTimeout(offlineTimers[u.id]);
                    delete offlineTimers[u.id];
                }

                dot.classList.remove('offline');
                dot.classList.add('online');
                text.innerText = "Online now";
            });
        })

        // دخل
        .joining((user) => {

            let dot  = document.getElementById(`status-dot-${user.id}`);
            let text = document.getElementById(`last-seen-${user.id}`);

            if (!dot || !text) return;

            if (offlineTimers[user.id]) {
                clearTimeout(offlineTimers[user.id]);
                delete offlineTimers[user.id];
            }

            dot.classList.remove('offline');
            dot.classList.add('online');
            text.innerText = "Online now";
        })

        // خرج / أغلق المتصفح
        .leaving((user) => {

            let dot  = document.getElementById(`status-dot-${user.id}`);
            let text = document.getElementById(`last-seen-${user.id}`);

            if (!dot || !text) return;

            offlineTimers[user.id] = setTimeout(() => {

                dot.classList.remove('online');
                dot.classList.add('offline');
                text.innerText = "Offline";

                delete offlineTimers[user.id];

            }, 5000);   // 5 ثواني — تقدر تغيّرها
        });

    </script>

@endsection
