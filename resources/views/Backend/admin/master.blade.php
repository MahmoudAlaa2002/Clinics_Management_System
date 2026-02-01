<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    <title>Clinics Management - @yield('title')</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="main-wrapper">

        @include('Backend.admin.layout.header')


        @include('Backend.admin.layout.sidebar')


        @yield('content')


    </div>


    <div class="sidebar-overlay" data-reff=""></div>

    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <!-- @vite(['resources/js/app.js']) -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function initTooltips() {
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );

            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                if (!tooltipTriggerEl._tooltip) {
                    tooltipTriggerEl._tooltip = new bootstrap.Tooltip(tooltipTriggerEl);
                }
            });
        }

    </script>

    @include('Backend.chat.echo-core')

    <script>
        function recalcNavbarUnread() {
            let total = 0;

            document.querySelectorAll('.badge[data-conv]').forEach((el) => {
                let val = parseInt(el.innerText);
                if (!isNaN(val)) total += val;
            });

            let navbarBadge = document.getElementById('navbar-unread');
            if (!navbarBadge) return;

            navbarBadge.innerText = (total > 99) ? '+99' : total;
        }


        Echo.private(`user.{{ auth()->id() }}`)
            .listen('NewChatMessage', (e) => {

                if (e.receiver_id !== {{ auth()->id() }}) return;

                updateConversationPreview(e);
                updateUnreadBadges(e);
                recalcNavbarUnread();
            });


        function updateUnreadBadges(e) {

            let convBadge = document.querySelector(
                `.badge[data-conv="${e.conversation_id}"]`
            );

            if (convBadge) {

                if (e.unread_count > 0) {
                    convBadge.style.display = 'inline-block';
                    convBadge.innerText = (e.unread_count > 99)
                        ? '+99'
                        : e.unread_count;
                } else {
                    convBadge.style.display = 'none';
                    convBadge.innerText = '';
                }
            }
        }



        function updateConversationPreview(e) {

            let list = document.getElementById('chat-header-list');
            if (!list) return;

            // موجودة من قبل؟
            let wrapper = list.querySelector(
                `[data-conv-wrapper="${e.conversation_id}"]`
            );

            if (wrapper) {

                let text = wrapper.querySelector('.msg-text');
                if (text) text.innerText = e.message;

                list.prepend(wrapper);
                return;
            }

            // 👇👇 جديد — إنشاء محادثة في الهيدر فوراً 👇👇

            let avatar = e.sender_image
                ? `<img src="${e.sender_image}"
                        style="width:44px;height:44px;border-radius:50%;object-fit:cover;">`
                : e.sender_name.substring(0, 2).toUpperCase();


            let html = `
                    <a href="/clinics-management/chat/open/${e.sender_id}"
                    class="dropdown-item d-flex align-items-center msg-item"
                    style="padding:12px 14px; transition:.25s;"
                    data-conv-wrapper="${e.conversation_id}">

                        <div class="mr-3">
                            <div style="width:44px;height:44px;border-radius:50%;
                                background:#e8f2ff;color:#0b4e7a;font-weight:700;
                                display:flex;align-items:center;justify-content:center;">
                                ${avatar}
                            </div>
                        </div>

                        <div class="flex-fill">

                            <div class="msg-name" style="font-weight:700; color:#0d1f33;">
                                ${e.sender_name}
                            </div>

                            <div class="msg-text" style="font-size:12px; color:#6c7a92; margin-top:2px;">
                                ${e.message}
                            </div>

                        </div>

                        <span class="ml-2 badge badge-danger"
                            data-conv="${e.conversation_id}">
                            1
                        </span>

                    </a>

                    <div style="height:1px;background:#f1f3f7;margin:0 12px;"></div>
                    `;


            list.insertAdjacentHTML('afterbegin', html);
        }

    </script>

    @yield('js')
</body>

</html>