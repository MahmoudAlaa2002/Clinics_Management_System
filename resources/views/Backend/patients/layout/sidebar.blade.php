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


            {{-- 📊 Personality statistics --}}
            <ul>
                <li class="menu-title">Personality statistics</li>

                <li class="{{ Request::is('patient/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('patient_dashboard') }}">
                        <i class="fa fa-chart-line"></i> <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            {{-- 🗓️ Appointments --}}
            <ul>
                <li class="menu-title">Appointments</li>

                <li class="{{ Request::is('patient/appointments') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-calendar-alt"></i> <span>All Appointments</span>
                    </a>
                </li>

                <li class="{{ Request::is('patient/appointments/today') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-calendar-day"></i> <span>Today's Appointments</span>
                    </a>
                </li>
            </ul>

            {{-- 👥 Medical Records --}}
            <ul>
                <li class="menu-title">Medical Records</li>

                <li class="{{ Request::is('patient/medical-records') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-notes-medical"></i> <span>My Records</span>
                    </a>
                </li>
            </ul>

            {{-- 👤 Profile --}}
            <ul>
                <li class="menu-title">Profile</li>

                <li class="{{ Request::is('patient/profile') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Profile</span>
                    </a>
                </li>

                <li class="{{ Request::is('patient/profile/edit') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-user-edit"></i> <span>Edit Profile</span>
                    </a>
                </li>

                <li class="{{ Request::is('patient/profile/settings') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>Account Settings</span>
                    </a>
                </li>
            </ul>

            {{-- 🔔 Notifications & Messages --}}
            <ul>
                <li class="menu-title">Notifications & Messages</li>

                <li class="{{ Request::is('patient/notifications') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-bell"></i> <span>Notifications</span>
                    </a>
                </li>

                <li class="{{ Request::is('patient/messages') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-comments"></i> <span>Messages</span>
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
