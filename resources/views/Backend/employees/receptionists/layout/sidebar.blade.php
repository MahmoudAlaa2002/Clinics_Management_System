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

                <li class="{{ Request::is('employee/receptionist/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('receptionist_dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu {{ Request::is('employee/receptionist/clinic-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinic </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/receptionist/clinic-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('receptionist.clinic_profile') }}" class="{{ Request::is('employee/receptionist/clinic-profile') ? 'active' : '' }}">
                                Clinic Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('employee/receptionist/depratment-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i> <span> Department </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/receptionist/depratment-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('receptionist.depratment_profile') }}" class="{{ Request::is('employee/receptionist/depratment-profile') ? 'active' : '' }}">
                                Department Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('employee/receptionist/view/doctors') || Request::is('employee/receptionist/profile/doctor/*') || Request::is('employee/receptionist/search/schedules') || Request::is('employee/receptionist/search/doctor/schedule') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-doctor"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/receptionist/view/doctors') || Request::is('employee/receptionist/profile/doctor/*') || Request::is('employee/receptionist/search/schedules') || Request::is('employee/receptionist/search/doctor/schedule') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('receptionist.view_doctors') }}" class="{{ Request::is('employee/receptionist/view/doctors') || Request::is('employee/receptionist/profile/doctor/*') ? 'active' : '' }}">View Doctors</a>
                        </li>
                        <li>
                            <a href="{{ route('receptionist.search_schedules') }}" class="{{ Request::is('employee/receptionist/search/schedules') || Request::is('employee/receptionist/search/doctor/schedule') ? 'active' : '' }}">Doctor Schedules</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/receptionist/add/patient') || Request::is('employee/receptionist/view/patients')  || Request::is('employee/receptionist/profile/patient/*') || Request::is('employee/receptionist/edit/patient') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-injured"></i> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/receptionist/add/patient') || Request::is('employee/receptionist/view/patients')  || Request::is('employee/receptionist/profile/patient/*') || Request::is('employee/receptionist/edit/patient') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('receptionist.add_patient') }}" class="{{ Request::is('employee/receptionist/add/patient') ? 'active' : '' }}">Add Patient</a>
                        </li>
                        <li>
                            <a href="{{ route('receptionist.view_patients') }}" class="{{ Request::is('employee/receptionist/view/patients') || Request::is('employee/receptionist/profile/patient/*') || Request::is('employee/receptionist/edit/patient') ? 'active' : '' }}">View Patients</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/receptionist/add/appointment')
                        || Request::is('employee/receptionist/view/appointments')
                        || Request::is('employee/receptionist/search/appointments')
                        || Request::is('employee/receptionist/details/appointment/*')
                        || Request::is('employee/receptionist/edit/appointment/*')
                        ? 'active' : ''
                    }}">

                    <a href="#">
                        <i class="fas fa-calendar-alt"></i>
                        <span> Appointments </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ Request::is('employee/receptionist/add/appointment')
                            || Request::is('employee/receptionist/view/appointments')
                            || Request::is('employee/receptionist/search/appointments')
                            || Request::is('employee/receptionist/details/appointment/*')
                            || Request::is('employee/receptionist/edit/appointment/*')
                            ? '' : 'display: none;'
                        }}
                    ">

                        <li>
                            <a href="{{ route('receptionist.add_appointment') }}"
                                class="{{ Request::is('employee/receptionist/add/appointment') ? 'active' : '' }}">
                                Add Appointment
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('receptionist.view_appointments') }}"
                                class="{{ Request::is('employee/receptionist/view/appointments')
                                        || Request::is('employee/receptionist/search/appointments')
                                        || Request::is('employee/receptionist/details/appointment/*')
                                        || Request::is('employee/receptionist/edit/appointment/*')
                                        ? 'active' : '' }}">
                                View Appointments
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>


            <ul>
                <li class="menu-title">Invoices</li>
                <li class="submenu
                    {{ Request::is('employee/receptionist/view/invoices') || Request::is('employee/receptionist/search/invoices') || Request::is('employee/receptionist/details/invoice/*') || Request::is('employee/receptionist/invoice-pdf/view/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-file-invoice"></i>
                        <span> Invoices </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{Request::is('employee/receptionist/view/invoices') || Request::is('employee/receptionist/search/invoices') || Request::is('employee/receptionist/details/invoice/*') || Request::is('employee/receptionist/invoice-pdf/view/*') ? '' : 'display: none;'}}">
                        <li>
                            <a href="{{ route('receptionist.view_invoices') }}" class="{{ Request::is('employee/receptionist/view/invoices') || Request::is('employee/receptionist/search/invoices') || Request::is('employee/receptionist/details/invoice/*') || Request::is('employee/receptionist/invoice-pdf/view/*') ? 'active' : '' }}">
                            View Invoices
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
                <li class="submenu {{ Request::is('employee/receptionist/edit/profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/receptionist/edit/profile')  ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('receptionist_edit_profile') }}" class="{{ Request::is('employee/receptionist/edit/profile') ? 'active' : '' }}">Edit Profile</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
