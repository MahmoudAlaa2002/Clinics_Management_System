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

                <li class="{{ Request::is('department-manager/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('department_manager_dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>


                <li class="submenu {{ Request::is('department-manager/clinic-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinic </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('department-manager/clinic-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('department.clinic_profile') }}" class="{{ Request::is('department-manager/clinic-profile') ? 'active' : '' }}">
                                Clinic Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('department-manager/depratment-profile') || Request::is('department-manager/edit/depratment-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i> <span> Department </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('department-manager/depratment-profile') || Request::is('department-manager/edit/depratment-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('depratment_profile') }}" class="{{ Request::is('department-manager/depratment-profile') ? 'active' : '' }}">
                                View Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('edit_depratment_profile') }}" class="{{ Request::is('department-manager/edit/depratment-profile') ? 'active' : '' }}">
                                Edit Profile
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('department-manager/view/employees') || Request::is('department-manager/profile/employee/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-tie"></i> <span> Employees </span> <span class="menu-arrow"></span></a>
                    <ul style="{{  Request::is('department-manager/view/employees') || Request::is('department-manager/profile/employee/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('department.view_employees') }}" class="{{ Request::is('department-manager/view/employees') || Request::is('department-manager/profile/employee/*') ? 'active' : '' }}">View Employees</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('department-manager/view/doctors') || Request::is('department-manager/profile/doctor/*') || Request::is('department-manager/search/schedules') || Request::is('department-manager/search/doctor/schedule') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-doctor"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('department-manager/view/doctors') || Request::is('department-manager/profile/doctor/*') || Request::is('department-manager/search/schedules') || Request::is('department-manager/search/doctor/schedule') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('department.view_doctors') }}" class="{{ Request::is('department-manager/view/doctors') || Request::is('department-manager/profile/doctor/*') ? 'active' : '' }}">View Doctors</a>
                        </li>
                        <li>
                            <a href="{{ route('department.search_schedules') }}" class="{{ Request::is('department-manager/search/schedules') || Request::is('department-manager/search/doctor/schedule') ? 'active' : '' }}">Doctor Schedules</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('department-manager/view/patients')  || Request::is('department-manager/profile/patient/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-injured"></i> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('department-manager/view/patients')  || Request::is('department-manager/profile/patient/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('department.view_patients') }}" class="{{ Request::is('department-manager/view/patients') || Request::is('department-manager/profile/patient/*') ? 'active' : '' }}">View Patients</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('department-manager/view/appointments') || Request::is('department-manager/search/appointments') || Request::is('department-manager/details/appointment/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-calendar-alt"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('department-manager/view/appointments') || Request::is('department-manager/search/appointments') || Request::is('department-manager/details/appointment/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('department.view_appointments') }}"
                            class="{{ Request::is('department-manager/view/appointments') || Request::is('department-manager/search/appointments') || Request::is('department-manager/details/appointment/*') ? 'active' : '' }}">View Appointments</a>
                        </li>
                    </ul>
                </li>

            </ul>


            <ul>
                <li class="menu-title">Reports</li>
                <li class="submenu  {{ Request::is('department-manager/view/reports') || Request::is('department-manager/details/patients-reports*') || Request::is('department-manager/details/appointments-reports*') || Request::is('department-manager/details/doctors-reports*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-file-alt"></i>
                        <span> Reports </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ Request::is('department-manager/view/report') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('department.view_reports') }}"
                               class="{{ Request::is('department-manager/view/reports') || Request::is('department-manager/details/patients-reports*') || Request::is('department-manager/details/appointments-reports*') || Request::is('department-manager/details/doctors-reports*') ? 'active' : '' }}">
                                View Reports
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>


            <ul>
                <li class="menu-title">Contacts</li>
                <li class="submenu {{ Request::is('clinics-management/chat/contacts') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-comments"></i> <span> Chats </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinics-management/chat/contacts')  ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('chat_contacts') }}" class="{{ Request::is('clinics-management/chat/contacts') ? 'active' : '' }}">View Chats</a>
                        </li>
                    </ul>
                </li>
            </ul>


            <ul>
                <li class="menu-title">System</li>
                <li class="submenu {{ Request::is('department-manager/edit/profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('department-manager/edit/profile')  ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('department_manager_edit_profile') }}" class="{{ Request::is('department-manager/edit/profile') ? 'active' : '' }}">Edit Profile</a>
                        </li>
                    </ul>
                </li>
            </ul>


            </ul>
        </div>
    </div>
</div>
