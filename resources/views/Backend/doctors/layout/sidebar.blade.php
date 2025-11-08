<style>
    .sidebar-menu li ul li a.active {
        color: #009efb !important;
        font-weight: bold;
        text-decoration: none !important;
    }

    .sidebar-menu li ul li a {
        color: #555 !important;
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            {{-- 📊 Dashboard & Reports --}}
            <ul>
                <li class="menu-title">Dashboard & Reports</li>

                <li class="{{ Request::is('doctor/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('doctor_dashboard') }}">
                        <i class="fa fa-chart-line"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ Request::is('doctor/reports') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-file-alt"></i> <span>Monthly Reports</span>
                    </a>
                </li>

                <li class="{{ Request::is('doctor/reviews') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Patient Reviews</span>
                    </a>
                </li>

                <li class="{{ Request::is('doctor/performance') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-chart-pie"></i> <span>Performance Charts</span>
                    </a>
                </li>
            </ul>


            {{-- 🗓️ Appointments Management --}}
            <ul>
                <li class="menu-title">Appointments</li>

                <li class="{{ Request::is('doctor/appointments') && request('date') !== 'today' ? 'active' : '' }}">
                    <a href="{{ route('doctor.appointments') }}">
                        <i class="fa fa-calendar-alt"></i> <span>All Appointments</span>
                    </a>
                </li>

                <li class="{{ request()->is('doctor/appointments') && request('date') === 'today' ? 'active' : '' }}">
                    <a href="{{ route('doctor.appointments') }}?date=today">
                        <i class="fa fa-calendar-day"></i> <span>Today's Appointments</span>
                    </a>
                </li>
            </ul>


            {{-- 👥 Patients Management --}}
            <ul>
                <li class="menu-title">Patients</li>

                <li class="{{ Request::is('doctor/patients') ? 'active' : '' }}">
                    <a href="{{ route('doctor.patients') }}">
                        <i class="fa fa-users"></i> <span>My Patients</span>
                    </a>
                </li>
            </ul>


            {{-- 🏥 Medical Records --}}
            <ul>
                <li class="menu-title">Medical Records</li>

                <li class="{{ Request::is('doctor/medical-records') ? 'active' : '' }}">
                    <a href="{{ route('doctor.medical_records') }}">
                        <i class="fa fa-notes-medical"></i> <span>All Records</span>
                    </a>
                </li>

                <li class="{{ Request::is('doctor/medical-records/create') ? 'active' : '' }}">
                    <a href="{{ route('doctor.medical_records.create') }}">
                        <i class="fa fa-plus"></i> <span>Create Record</span>
                    </a>
                </li>
            </ul>


            {{-- 💰 Invoices & Payments --}}
            <ul>
                <li class="menu-title">Invoices & Payments</li>

                <li class="{{ Request::is('doctor/invoices') ? 'active' : '' }}">
                    <a href="{{ route('doctor.invoices') }}">
                        <i class="fa fa-file-invoice-dollar"></i> <span>Invoices</span>
                    </a>
                </li>
            </ul>


            {{-- 👤 Profile --}}
            <ul>
                <li class="menu-title">Profile</li>

                <li class="{{ Request::is('doctor/profile/edit') ? 'active' : '' }}">
                    <a href="{{ route('doctor.profile.edit') }}">
                        <i class="fa fa-user-cog"></i> <span>Edit Profile</span>
                    </a>
                </li>

                <li class="{{ Request::is('doctor/profile/settings') ? 'active' : '' }}">
                    <a href="{{ route('doctor.profile.settings') }}">
                        <i class="fa fa-lock"></i> <span>Account Settings</span>
                    </a>
                </li>
            </ul>


            {{-- 🔔 Notifications & Communication --}}
            <ul>
                <li class="menu-title">Notifications & Communication</li>

                <li class="{{ Request::is('doctor/notifications') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-bell"></i> <span>Notifications</span>
                    </a>
                </li>

                <li class="{{ Request::is('doctor/messages') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-comments"></i> <span>Messages</span>
                    </a>
                </li>

                <li class="{{ Request::is('doctor/reports/submit') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-paper-plane"></i> <span>Submit Report</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar-inner');
        if (!sidebar) return;

        // بننتظر شوية بعد تحميل المكتبة لتكون جاهزة
        setTimeout(() => {
            const scrollElement = sidebar.querySelector('.slimScrollDiv') || sidebar;

            scrollElement.addEventListener('scroll', function() {
                localStorage.setItem('sidebar-scroll', scrollElement.scrollTop);
            });

            const savedScroll = localStorage.getItem('sidebar-scroll');
            if (savedScroll !== null) {
                scrollElement.scrollTop = savedScroll;
            }
        }, 500);
    });
</script>
