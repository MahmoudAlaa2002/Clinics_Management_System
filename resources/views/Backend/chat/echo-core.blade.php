<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

<script>
/* =========================
   🔌 إعداد Echo + Pusher
   ========================= */
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

/* =========================
   🟢 متغيّرات عامة (بدون تكرار)
   ========================= */
const currentUserId   = {{ auth()->id() }};
const userRole        = "{{ auth()->user()->role }}";
const jobTitle        = "{{ optional(auth()->user()->employee)->job_title }}";
const csrf            = document.querySelector('meta[name="csrf-token"]').content;

/* =========================
   👥 حالة الأونلاين
   ========================= */
Echo.join('online-users');

document.addEventListener("visibilitychange", function () {
    if (document.visibilityState === "hidden") {
        navigator.sendBeacon("{{ url('/clinics-management/set-offline') }}");
    }
});

/* =========================
   🔔 الإشعارات الفورية
   ========================= */
Echo.private(`App.Models.User.${currentUserId}`)
    .notification((notification) => {

        fetch(`/clinics-management/notifications/render/${notification.id}`)
            .then(res => res.text())
            .then(html => {

                let list = document.querySelector('.notification-list');
                if (!list) return;

                list.insertAdjacentHTML('afterbegin', html);

                let badge = document.querySelector('.fa-bell-o')
                    ?.parentElement.querySelector('.badge');

                if (badge) {
                    let val = parseInt(badge.innerText) || 0;
                    badge.innerText = val + 1;
                }
            });
    });

/* =========================
   🔁 تحديث حالة المواعيد
   ========================= */
Echo.private(`App.Models.User.${currentUserId}`)
    .listen('.AppointmentStatusUpdated', (e) => {

        let row = document.querySelector(
            `[data-appointment="${e.appointment.id}"]`
        );

        if (!row) return;

        let status = e.appointment.status;

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

        let actionCell = row.querySelector('.action-btns .d-flex, .action-btns, td:nth-child(8) .d-flex');

        if (!actionCell) return;

        let html = '';

        /* ===== ADMIN ===== */
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

            if (['Completed','Rejected','Cancelled'].includes(status)) {
                html = details + del;
            } else {
                html = details + edit + del;
            }
        }

        /* ===== DOCTOR ===== */
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

            if (status === 'Pending') html = details + records + accept + reject;
            else if (status === 'Accepted') html = details + records + cancel;
            else html = details + records;
        }

        /* ===== RECEPTIONIST ===== */
        else if (userRole === 'employee' && jobTitle === 'Receptionist') {

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

            if (status === 'Pending') html = accept + reject;
            else if (status === 'Accepted') html = details + edit;
            else html = details;
        }

        actionCell.innerHTML = html;
    });

/* ======================================
   📅 تحديث قائمة المواعيد (نقل/إخفاء)
   ====================================== */

function safeSet(row, selector, value, isLink = false, url = null) {
    const cell = row.querySelector(selector);
    if (!cell) return;

    if (isLink) {
        cell.innerHTML = `<a href="${url}">${value ?? '—'}</a>`;
    } else {
        cell.innerText = value ?? '—';
    }
}

function hideNoAppointments() {
    const row = document.getElementById('no-appointments-row');
    if (row) row.remove();
}

function showNoAppointmentsIfEmpty() {
    const tbody = document.querySelector('tbody');
    if (!tbody) return;

    if (tbody.querySelectorAll('tr[data-appointment]').length === 0) {
        tbody.insertAdjacentHTML('beforeend', `
            <tr id="no-appointments-row">
                <td colspan="8" class="text-center">
                    <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                        No appointments found
                    </div>
                </td>
            </tr>
        `);
    }
}

function renumberRows() {
    const rows = document.querySelectorAll('tbody tr[data-appointment]');
    let i = 1;
    rows.forEach(row => {
        const firstCell = row.querySelector('td');
        if (firstCell) firstCell.innerText = i++;
    });
}

function appendAppointmentRow(e) {

    hideNoAppointments();

    const tbody = document.querySelector('tbody');
    if (!tbody) return;

    const a = e.appointment;

    let statusClasses = {
        Pending: 'status-pending',
        Accepted: 'status-accepted',
        Rejected: 'status-rejected',
        Cancelled: 'status-cancelled',
        Completed: 'status-completed'
    };

    let html = `
        <tr data-appointment="${a.id}">
            <td>#</td>

            <td data-field="patient">
                <a href="/doctor/patients/${a.patient?.id}">
                    ${a.patient?.user?.name ?? '—'}
                </a>
            </td>

            <td data-field="clinic">${a.clinic?.name ?? '—'}</td>

            <td data-field="department">${a.department?.name ?? '—'}</td>

            <td data-field="date">${a.date}</td>

            <td data-field="time">${a.time?.slice(0,5) ?? '—'}</td>

            <td class="status-cell">
                <span class="status-badge ${statusClasses[a.status] ?? ''}">
                    ${a.status}
                </span>
            </td>

            <td>
                <div class="d-flex justify-content-center">
                    <a href="/doctor/appointment/${a.id}"
                        class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i> Details
                    </a>

                    <a href="/doctor/patient/${a.patient?.id}/records"
                        class="mr-1 btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-medical"></i> Records
                    </a>
                </div>
            </td>
        </tr>
    `;

    tbody.insertAdjacentHTML('afterbegin', html);
    renumberRows();
}

function addAppointmentRow(e) {

    hideNoAppointments();

    const a = e.appointment;
    const tbody = document.querySelector('#appointments_table_body') || document.querySelector('tbody');

    if (!tbody) return;

    let html = `
        <tr data-appointment="${a.id}">

            <!-- ID -->
            <td data-field="id">${a.id}</td>

            <!-- Patient -->
            <td data-field="patient">
                ${a.patient?.user?.name ?? '—'}
            </td>

            <!-- Clinic -->
            <td data-field="clinic">
                ${a.clinic?.name ?? '—'}
            </td>

            <!-- Department -->
            <td data-field="department">
                ${a.department?.name ?? '—'}
            </td>

            <!-- Doctor -->
            <td data-field="doctor">
                ${a.doctor?.employee?.user?.name ?? '—'}
            </td>

            <!-- Date -->
            <td data-field="date">
                ${a.date}
            </td>

            <!-- Time -->
            <td data-field="time">
                ${a.time?.slice(0,5) ?? '—'}
            </td>

            <!-- Status -->
            <td class="status-cell">
                ${renderStatusBadge(a.status)}
            </td>

            <!-- Action -->
            <td class="action-btns">
                <div class="d-flex justify-content-center">

                    <a href="/admin/details/appointment/${a.id}"
                        class="mr-1 btn btn-outline-success btn-sm"
                        data-bs-toggle="tooltip"
                        title="Details Appointment">
                        <i class="fa fa-eye"></i>
                    </a>

                    ${(!['Completed','Rejected','Cancelled'].includes(a.status)) ? `
                        <a href="/admin/edit/appointment/${a.id}"
                            class="mr-1 btn btn-outline-primary btn-sm"
                            data-bs-toggle="tooltip"
                            title="Edit Appointment">
                            <i class="fa fa-edit"></i>
                        </a>
                    ` : ''}

                    <button class="btn btn-outline-danger btn-sm delete-appointment"
                        data-id="${a.id}"
                        data-bs-toggle="tooltip"
                        title="Delete Appointment">
                        <i class="fa fa-trash"></i>
                    </button>

                </div>
            </td>

        </tr>
    `;

    tbody.insertAdjacentHTML('afterbegin', html);

    initTooltips?.();
}


function appendNurseAppointmentRow(e) {

    hideNoAppointments();

    const tbody = document.querySelector('tbody');
    if (!tbody) return;

    const a = e.appointment;

    const statusColors = {
        Pending:  '#ffc107',
        Accepted: '#189de4',
        Rejected: '#f90d25',
        Cancelled:'#6c757d',
        Completed:'#14ea6d'
    };

    let html = `
        <tr data-appointment="${a.id}">
            <td data-field="id">${a.id}</td>

            <td data-field="patient">
                ${a.patient?.user?.name ?? '—'}
            </td>

            <td data-field="doctor">
                ${a.doctor?.employee?.user?.name ?? '—'}
            </td>

            <td data-field="date">
                ${a.date}
            </td>

            <td data-field="time">
                ${a.time?.slice(0,5) ?? '—'}
            </td>

            <td class="status-cell">
                <span class="status-badge"
                    style="
                        min-width:140px;
                        display:inline-block;
                        text-align:center;
                        padding:4px 12px;
                        font-size:18px;
                        border-radius:50px;
                        color:#fff;
                        background:${statusColors[a.status] ?? '#6c757d'};
                    ">
                    ${a.status}
                </span>
            </td>

            <td class="action-btns">
                <div class="d-flex justify-content-center">

                    ${
                        !a.vital_sign_id
                        ? `<a href="/nurse/vital-signs/add/${a.id}"
                            class="btn btn-outline-primary btn-sm"
                            title="Add Vital Signs">
                                <i class="fas fa-heartbeat"></i>
                        </a>`
                        : `<a href="/nurse/vital-signs/view/${a.id}"
                            class="btn btn-outline-success btn-sm"
                            title="View Vital Signs">
                                <i class="fas fa-heartbeat"></i>
                        </a>`
                    }

                </div>
            </td>
        </tr>
    `;

    tbody.insertAdjacentHTML('afterbegin', html);
    renumberRows();
}


Echo.private(`App.Models.User.${currentUserId}`)
    .listen('.AppointmentUpdated', (e) => {

        // نحسب تاريخ اليوم
        const today = new Date().toISOString().slice(0, 10);

        // لو الصفحة هي صفحة الممرض اليومية
        const isNurseDailyPage = (userRole === 'employee' && jobTitle === 'Nurse');

        if (isNurseDailyPage) {

            let row = document.querySelector(
                `[data-appointment="${e.appointment.id}"]`
            );

            const today = new Date().toISOString().slice(0, 10);

            // الموعد لم يعد اليوم → نحذفه
            if (e.appointment.date !== today) {
                if (row) row.remove();
                showNoAppointmentsIfEmpty();
                renumberRows();
                return;
            }

            // الموعد أصبح اليوم ولم يكن موجود → أضفه بتنسيق nurse
            if (!row && e.appointment.date === today) {
                appendNurseAppointmentRow(e);
                return;
            }

            // لو موجود — نحدّث قيمه فقط
            if (row) {
                safeSet(row, '[data-field="patient"]', e.appointment.patient?.user?.name);
                safeSet(row, '[data-field="doctor"]', e.appointment.doctor?.employee?.user?.name);
                safeSet(row, '[data-field="date"]', e.appointment.date);
                safeSet(row, '[data-field="time"]', e.appointment.time?.slice(0,5));
            }
        }


        const doctorUserId = currentUserId;

        let row = document.querySelector(
            `[data-appointment="${e.appointment.id}"]`
        );

        // 👈 الدكتور القديم — احذف السجل
        if (e.oldDoctorUserId && e.oldDoctorUserId === doctorUserId) {
            if (row) row.remove();
            renumberRows();
            showNoAppointmentsIfEmpty();
            return;
        }

        // 👈 الدكتور الجديد — أضف السجل
        if (!row) {
            appendAppointmentRow(e);
            return;
        }

        // 👈 تحديث السجل الحالي
        safeSet(
            row,
            '[data-field="patient"]',
            e.appointment.patient?.user?.name,
            true,
            `/doctor/patients/${e.appointment.patient?.id}`
        );

        safeSet(row, '[data-field="clinic"]', e.appointment.clinic?.name);
        safeSet(row, '[data-field="department"]', e.appointment.department?.name);
        safeSet(row, '[data-field="date"]', e.appointment.date);
        safeSet(row, '[data-field="time"]', e.appointment.time?.slice(0,5));
    });







    // إضافة سجل في جدول المواعيد
    Echo.private(`App.Models.User.${currentUserId}`)
        .listen('.AppointmentCreated', (e) => {
            addAppointmentRow(e);
        });






    // ✔ جعل الحجوزات فورية في جدول الدكاترة

    Echo.private(`App.Models.User.${currentUserId}`)
        .listen('.AppointmentCreated', (e) => {

            // لا يوجد جدول ظاهر؟
            const table = document.querySelector('table');
            if (!table) return;

            const a = e.appointment;

            // اليوم بالشكل الموجود في الجدول (Saturday / Sunday …)
            const dayName = new Date(a.date).toLocaleDateString('en-US', {
                weekday: 'long'
            });

            // الوقت بنفس تنسيق الجدول H:i
            const time = a.time.slice(0,5); // 10:30

            // نبحث عن صف اليوم
            let rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {

                const firstCell = row.querySelector('td');
                if (!firstCell) return;

                // هذا ليس نفس اليوم
                if (firstCell.innerText.trim() !== dayName) return;

                // نجيب كل خلايا الوقت
                const timeCells = row.querySelectorAll('td');

                timeCells.forEach((cell, index) => {

                    // أول خلية هي اسم اليوم — نتخطاها
                    if (index === 0) return;

                    // عنوان العمود (الوقت)
                    const header = document.querySelectorAll('thead th')[index];
                    if (!header) return;

                    if (header.innerText.trim() === time) {

                        cell.innerHTML =
                            `<span class="text-success" style="font-size: 22px;">&#10004;</span>`;
                    }
                });
            });

        });





</script>
