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
            <ul>
                <li class="menu-title">Core Modules</li>

                <li class="{{ Request::is('employee/nurse/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('nurse_dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu {{ Request::is('employee/nurse/clinic-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinic </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/nurse/clinic-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse.clinic_profile') }}" class="{{ Request::is('employee/nurse/clinic-profile') ? 'active' : '' }}">
                                Clinic Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('employee/nurse/depratment-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i> <span> Department </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/nurse/depratment-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse.depratment_profile') }}" class="{{ Request::is('employee/nurse/depratment-profile') ? 'active' : '' }}">
                                Department Profile
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/nurse/view/doctors') || Request::is('employee/nurse/profile/doctor/*') || Request::is('employee/nurse/search/schedules') || Request::is('employee/nurse/search/doctor/schedule') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-doctor"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/nurse/view/doctors') || Request::is('employee/nurse/profile/doctor/*') || Request::is('employee/nurse/search/schedules') || Request::is('employee/nurse/search/doctor/schedule') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse.view_doctors') }}" class="{{ Request::is('employee/nurse/view/doctors') || Request::is('employee/nurse/profile/doctor/*') ? 'active' : '' }}">View Doctors</a>
                        </li>
                        <li>
                            <a href="{{ route('nurse.search_schedules') }}" class="{{ Request::is('employee/nurse/search/schedules') || Request::is('employee/nurse/search/doctor/schedule') ? 'active' : '' }}">Doctor Schedules</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/nurse/view/patients')  || Request::is('employee/nurse/profile/patient/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-injured"></i> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/nurse/view/patients')  || Request::is('employee/nurse/profile/patient/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse.view_patients') }}" class="{{ Request::is('employee/nurse/view/patients') || Request::is('employee/nurse/profile/patient/*') ? 'active' : '' }}">View Patients</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/nurse/view/appointments') || Request::is('employee/nurse/search/appointments') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-calendar-alt"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/nurse/view/appointments') || Request::is('employee/nurse/search/appointments') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse.view_appointments') }}"
                            class="{{ Request::is('employee/nurse/view/appointments') || Request::is('employee/nurse/search/appointments') ? 'active' : '' }}">View Appointments</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/nurse/view/medical-records') || Request::is('employee/nurse/details/medical-record/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-notes-medical"></i>
                        <span> Medical Records </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ Request::is('employee/nurse/view/medical-records') || Request::is('employee/nurse/details/medical-record/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse.view_medical_records') }}"
                            class="{{ Request::is('employee/nurse/view/medical-records') || Request::is('employee/nurse/details/medical-record/*') ? 'active' : '' }}">
                                View Medical Record
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/nurse/view/nurse-tasks') || Request::is('employee/nurse/details/nurse-task/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-clipboard-list"></i>
                        <span> Nurse Task </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ Request::is('employee/nurse/view/nurse-tasks') || Request::is('employee/nurse/details/nurse-task/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse.view_nurse_tasks') }}"
                            class="{{ Request::is('employee/nurse/view/nurse-tasks') || Request::is('employee/nurse/details/nurse-task/*') ? 'active' : '' }}">
                                View Nurse Task
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul>
                <li class="menu-title">System</li>
                <li class="submenu {{ Request::is('employee/nurse/edit/profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/nurse/edit/profile')  ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('nurse_edit_profile') }}" class="{{ Request::is('employee/nurse/edit/profile') ? 'active' : '' }}">Edit Profile</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
