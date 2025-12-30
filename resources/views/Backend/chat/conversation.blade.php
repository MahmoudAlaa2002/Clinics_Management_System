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

@section('title', 'Chat')

@section('content')

<style>

    #chat-box{
        visibility: hidden;
    }


    /* ================= CHAT WRAPPER ================= */

    .chat-card{
        border:1px solid #e6ecf3;
        border-radius:14px;
        box-shadow:0 12px 25px rgba(0,0,0,.06);
        background:#fff;
        overflow:hidden;
        max-width:920px;
        margin:28px auto;
    }

    /* ================= HEADER ================= */

    .chat-header{
        background: linear-gradient(135deg,#00A8FF,#00A8FF);
        color:#fff;
        padding:14px 18px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        border-bottom:1px solid rgba(255,255,255,.12);
    }

    .chat-user{
        color:#fff;
        display:flex;
        align-items:center;
        gap:12px;
    }

    .avatar-wrapper{
        position: relative;
        width: 42px;
        height: 42px;
    }

    .avatar-wrapper .avatar{
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background:#e8f4ff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
        color:#0b4e7a;
        font-size:13px;
        overflow:hidden;
    }

    .avatar-wrapper .avatar img{
        width:100%;
        height:100%;
        object-fit:cover;
        border-radius:50%;
    }

    .status-dot{
        position:absolute;
        right: 0px;
        bottom: 0px;
        width: 12px;
        height: 12px;
        border-radius:50%;
        border: 2px solid #fff;
    }

    .status-dot.online{
        background:#2ecc71;   /* Green */
    }

    .status-dot.offline{
        background:#e74c3c;   /* Red */
    }


    .user-info strong{
        font-size:15px;
        display:block;
    }

    .user-info small{
        font-size:11px;
        opacity:.9;
    }

    /* ================= CHAT BOX ================= */

    .chat-box{
        height:470px;
        overflow-y:auto;
        padding:18px;
        background:#f7fbff;
        border-top:1px solid #e6eef5;
    }

    .msg-me{
        text-align:right;
        margin-bottom:14px;
    }

    .msg-me span{
        background:#00A8FF;
        color:#fff;
        display:inline-block;
        padding:9px 13px;
        max-width:70%;
        border-radius:16px 16px 4px 16px;
        box-shadow:0 6px 20px rgba(0,168,255,.20);
        font-size:13px;
        line-height:1.4;
    }

    .msg-other{
        text-align:left;
        margin-bottom:14px;
    }

    .msg-other span{
        background:#fff;
        color:#063253;
        display:inline-block;
        padding:9px 13px;
        max-width:70%;
        border:1px solid #dbe8fa;
        border-radius:16px 16px 16px 4px;
        box-shadow:0 6px 20px rgba(0,0,0,.06);
        font-size:13px;
        line-height:1.4;
    }

    .time{
        display:block;
        font-size:10px;
        opacity:.6;
        margin-top:4px;
    }

    /* ================= FOOTER ================= */

    .chat-footer{
        padding:14px 16px;
        background:#fff;
        border-top:1px solid #e8edf2;
    }

    .chat-input{
        border:1px solid #dde8f2;
        border-radius:10px;
        padding:8px 10px;
        background:#fff;
        display:flex;
        align-items:center;
        gap:8px;
        box-shadow:0 4px 16px rgba(0,0,0,.05);
    }

    .chat-input input{
        width:100%;
        border:none;
        outline:none;
        font-size:13px;
        color:#063253;
    }

    .send-btn{
        border:none;
        background:#00A8FF;
        color:#fff;
        padding:7px 14px;
        border-radius:8px;
        font-weight:700;
        font-size:13px;
        cursor:pointer;
        transition:.25s;
    }

    .send-btn:hover{
        background:#0193e1;
    }

    .send-btn:focus,
    .send-btn:active,
    .send-btn:focus-visible{
        outline:none!important;
        box-shadow:none!important;
    }

</style>


<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="chat-card">
                    {{-- HEADER --}}
                    <div class="chat-header">

                        <div class="chat-user">

                            <div class="avatar-wrapper">

                                <div class="avatar">
                                    @if($target->image)
                                        <img src="{{ asset($target->image) }}">
                                    @else
                                        {{ strtoupper(substr($target->name,0,2)) }}
                                    @endif
                                </div>

                                <span id="status-dot" class="status-dot" style="visibility:hidden"></span>

                            </div>

                            <div class="user-info">
                                <strong>{{ $target->name }}</strong>

                                <small id="last-seen-text" style="visibility:hidden">—</small>
                            </div>

                        </div>

                    </div>

                    {{-- MESSAGES --}}
                    <div id="chat-box" class="chat-box">

                        @foreach($conversation->messages as $msg)

                            @if($msg->sender_id == auth()->id())
                                <div class="msg-me">
                                    <span>
                                        {{ $msg->message }}
                                        <small class="time">{{ $msg->created_at->format('H:i') }}</small>
                                    </span>
                                </div>
                            @else
                                <div class="msg-other">
                                    <span>
                                        {{ $msg->message }}
                                        <small class="time">{{ $msg->created_at->format('H:i') }}</small>
                                    </span>
                                </div>
                            @endif

                        @endforeach

                    </div>

                    {{-- FOOTER --}}
                    <div class="chat-footer">

                        <form id="chat-form">
                            @csrf

                            <input type="hidden" id="conversation_id" value="{{ $conversation->id }}">

                            <div class="chat-input">

                                <input type="text" id="message" placeholder="Type your message…">

                                <button type="submit" class="send-btn">
                                    <i class="fa fa-paper-plane"></i>
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection


@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    const conversationId = {{ $conversation->id }};
    const userId         = {{ auth()->id() }};
    const targetId       = {{ $target->id }};

    function scrollBottom() {
        const box = document.getElementById('chat-box');
        box.scrollTop = box.scrollHeight;
        box.style.visibility = 'visible';
    }

    document.addEventListener('DOMContentLoaded', () => setTimeout(scrollBottom, 10));

    // ===============================
    // استقبال الرسائل
    // ===============================

    Echo.private(`chat.${conversationId}`)
        .listen('NewChatMessage', (e) => {

            if (e.sender_id !== userId) {

                $('#chat-box').append(`
                    <div class="msg-other">
                        <span>
                            ${e.message}
                            <small class="time">${e.created_at}</small>
                        </span>
                    </div>
                `);

                scrollBottom();
                // 🔥 علّمها كمقروءة مباشرة
                $.post(`{{ route('chat_mark_read', $conversation->id) }}`, {
                    _token: '{{ csrf_token() }}'
                });
            }
        });


    // ===============================
    // إرسال الرسائل
    // ===============================

    $('#chat-form').on('submit', function (e) {

        e.preventDefault();

        let msg  = $('#message').val();
        let conv = $('#conversation_id').val();

        if (msg.trim() === '') return;

        $.post(`/clinics-management/chat/${conv}/send`, {
            _token: '{{ csrf_token() }}',
            message: msg
        }, function (res) {

            $('#message').val('');

            $('#chat-box').append(`
                <div class="msg-me">
                    <span>
                        ${res.message.message}
                        <small class="time">now</small>
                    </span>
                </div>
            `);

            scrollBottom();
        });
    });


    // ===============================
    // Presence — حالة الأونلاين
    // ===============================

    function setOnline() {
        let dot  = document.getElementById('status-dot');
        let text = document.getElementById('last-seen-text');

        dot.classList.remove('offline');
        dot.classList.add('online');

        dot.style.visibility  = "visible";
        text.style.visibility = "visible";

        text.innerText = "Online now";
    }

    function setOffline() {
        let dot  = document.getElementById('status-dot');
        let text = document.getElementById('last-seen-text');

        dot.classList.remove('online');
        dot.classList.add('offline');

        dot.style.visibility  = "visible";
        text.style.visibility = "visible";

        text.innerText = "Offline";
    }

    let navbarOfflineTimer = null;

    Echo.join('online-users')
        .here((users) => {
            users.forEach(u => {
                if (u.id === targetId) {
                    if (navbarOfflineTimer) clearTimeout(navbarOfflineTimer);
                    setOnline();
                }
            });
        })

        .joining((user) => {
            if (user.id === targetId) {
                if (navbarOfflineTimer) clearTimeout(navbarOfflineTimer);
                setOnline();
            }
        })

        .leaving((user) => {
            if (user.id === targetId) {
                navbarOfflineTimer = setTimeout(() => setOffline(), 5000);
            }
    });

</script>

@include('Backend.chat.echo-chat')

@endsection
