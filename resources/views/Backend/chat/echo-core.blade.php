<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

<script>
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ config('broadcasting.connections.pusher.key') }}",
        wsHost: "{{ config('broadcasting.connections.pusher.options.host') }}",
        wsPort: "{{ config('broadcasting.connections.pusher.options.port') }}",
        forceTLS: false,
        disableStats: true,
        enabledTransports: ['ws'],
        withCredentials: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
        }
    });





    Echo.join('online-users')



    // لو خرج اليورز من المتصفح يعتبر أوفلاين
    document.addEventListener("visibilitychange", function () {
        if (document.visibilityState === "hidden") {
            navigator.sendBeacon(
                "{{ url('/clinics-management/set-offline') }}"
            );
        }
    });





    // لجعل الإشعارات فورية
    Echo.private(`App.Models.User.{{ auth()->id() }}`)
        .notification((notification) => {

            // نجيب HTML من السيرفر
            fetch(`/clinics-management/notifications/render/${notification.id}`)
                .then(res => res.text())
                .then(html => {

                    let list = document.querySelector('.notification-list');
                    if (!list) return;

                    // إضافة الإشعار بالأعلى
                    list.insertAdjacentHTML('afterbegin', html);

                    // تحديث عداد الجرس
                    let badge = document.querySelector('.fa-bell-o')
                        ?.parentElement.querySelector('.badge');

                    if (badge) {
                        let val = parseInt(badge.innerText) || 0;
                        badge.innerText = val + 1;
                    }
                });
        });

        


        // لجعل حالات المواعيد فورية
        const userId = {{ auth()->id() }};
        const userRole = "{{ auth()->user()->role }}";
        const jobTitle = "{{ optional(auth()->user()->employee)->job_title }}";
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        Echo.private(`App.Models.User.${userId}`)
            .listen('.AppointmentStatusUpdated', (e) => {

                let row = document.querySelector(
                    `[data-appointment="${e.appointment.id}"]`
                );

                if (!row) return;

                let status = e.appointment.status;

                // ================== تحديث الحالة ==================
                let statusCell = row.querySelector('.status-cell');

                const colors = {
                    Pending:  '#ffc107',
                    Accepted: '#189de4',
                    Rejected: '#f90d25',
                    Cancelled:'#6c757d',
                    Completed:'#14ea6d'
                };

                statusCell.innerHTML =
                `<span class="status-badge"
                    style="min-width: 140px; display:inline-block; text-align:center; 
                        padding:4px 12px; font-size:18px; border-radius:50px;color:white; 
                        background:${colors[status]}">${status}</span>`;


                // ================== تحديث الأزرار ==================
                let actionCell = row.querySelector('.action-btns .d-flex, .action-btns, td:nth-child(8) .d-flex');

                if (!actionCell) return;


                // ====== توليد الأزرار حسب دور المستخدم ======
                let html = '';

                // ================= ADMIN =================
                if (userRole === 'admin') {

                    let details =
                    `<a href="/admin/details/appointment/${e.appointment.id}"
                        class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>`;

                    let edit =
                    `<a href="/admin/edit/appointment/${e.appointment.id}"
                        class="mr-1 btn btn-outline-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>`;

                    let del =
                    `<button class="btn btn-outline-danger btn-sm delete-appointment"
                            data-id="${e.appointment.id}">
                        <i class="fa fa-trash"></i>
                    </button>`;

                    if (['Completed', 'Rejected', 'Cancelled'].includes(status)) {
                        html = details + del;
                    } else {
                        html = details + edit + del;
                    }
                }


                // ================= DOCTOR =================
                else if (userRole === 'doctor') {

                    let details =
                    `<a href="/doctor/appointments/${e.appointment.id}"
                        class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i> Details
                    </a>`;

                    let records =
                    `<a href="/doctor/patient/${e.appointment.patient_id}/records"
                        class="mr-1 btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-medical"></i> Records
                    </a>`;

                    let accept =
                    `<form method="POST" action="/doctor/appointment/${e.appointment.id}/confirm" class="d-inline">
                        <input type="hidden" name="_token" value="${csrf}">
                        <button class="mr-1 btn btn-outline-success btn-sm">
                            <i class="fa fa-check"></i> Accept
                        </button>
                    </form>`;

                    let reject =
                    `<form method="POST" action="/doctor/appointment/${e.appointment.id}/reject" class="d-inline">
                        <input type="hidden" name="_token" value="${csrf}">
                        <button class="mr-1 btn btn-outline-danger btn-sm">
                            <i class="fa fa-times"></i> Reject
                        </button>
                    </form>`;

                    let cancel =
                    `<form method="POST" action="/doctor/appointment/${e.appointment.id}/cancel" class="d-inline">
                        <input type="hidden" name="_token" value="${csrf}">
                        <button class="mr-1 btn btn-outline-warning btn-sm">
                            <i class="fa fa-ban"></i> Cancel
                        </button>
                    </form>`;

                    if (status === 'Pending') {
                        html = details + records + accept + reject;
                    } else if (status === 'Accepted') {
                        html = details + records + cancel;
                    } else {
                        html = details + records;
                    }
                }


                // ================= RECEPTIONIST =================
                else if (userRole === 'employee' && jobTitle === 'Receptionist') {

                    // لاحقًا ممكن نفرق بين Nurse / Accountant — لكن الآن Receptionist فقط

                    let details =
                    `<a href="/receptionist/details/appointment/${e.appointment.id}"
                        class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>`;

                    let edit =
                    `<a href="/receptionist/edit/appointment/${e.appointment.id}"
                        class="mr-1 btn btn-outline-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>`;

                    let accept =
                    `<button class="mr-1 btn btn-outline-success btn-sm complete-btn"
                            data-id="${e.appointment.id}">
                        <i class="fas fa-check-circle"></i>
                    </button>`;

                    let reject =
                    `<button class="btn btn-outline-danger btn-sm reject-btn"
                            data-id="${e.appointment.id}">
                        <i class="fa fa-times"></i>
                    </button>`;

                    if (status === 'Pending') {
                        html = accept + reject;
                    } else if (status === 'Accepted') {
                        html = details + edit;
                    } else {
                        html = details;
                    }
                }

                actionCell.innerHTML = html;

            });






        // تحديث بيانات المواعيد
        


</script>


