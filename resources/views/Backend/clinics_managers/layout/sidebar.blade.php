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

                <li class="{{ Request::is('clinic-manager/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('clinic_manager_dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>


                <li class="submenu {{ Request::is('clinic-manager/clinic-profile') || Request::is('clinic-manager/edit/clinic-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinic </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinic-manager/clinic-profile') || Request::is('clinic-manager/edit/clinic-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic_profile') }}" class="{{ Request::is('clinic-manager/clinic-profile') ? 'active' : '' }}">
                                Clinic Profile
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('edit_clinic_profile') }}" class="{{ Request::is('clinic-manager/edit/clinic-profile') ? 'active' : '' }}">
                                Edit Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('clinic-manager/add/department/toClinic') || Request::is('clinic-manager/view/departments') || Request::is('clinic-manager/details/department/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i> <span> Departments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinic-manager/add/department/toClinic') || Request::is('clinic-manager/view/departments') || Request::is('clinic-manager/details/department/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic.add_department') }}" class="{{ Request::is('clinic-manager/add/department/toClinic') ? 'active' : '' }}">
                                Add Department
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('clinic.view_departments') }}" class="{{ Request::is('clinic-manager/view/departments') || Request::is('clinic-manager/details/department/*') ? 'active' : '' }}">
                                View Departments
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('clinic.view_departments_managers') }}" class="{{ Request::is('clinic-manager/view/departments-managers') ? 'active' : '' }}">
                                Departments Managers
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('clinic-manager/add/employee') || Request::is('clinic-manager/view/employees') || Request::is('clinic-manager/edit/employee/*') || Request::is('clinic-manager/profile/employee/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-tie"></i> <span> Employees </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinic-manager/add/employee') || Request::is('clinic-manager/view/employees') || Request::is('clinic-manager/edit/employee/*') || Request::is('clinic-manager/profile/employee/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic.add_employee') }}" class="{{ Request::is('clinic-manager/add/employee') ? 'active' : '' }}">Add Employee</a>
                        </li>
                        <li>
                            <a href="{{ route('clinic.view_employees') }}" class="{{ Request::is('clinic-manager/view/employees') || Request::is('clinic-manager/edit/employee/*') || Request::is('clinic-manager/profile/employee/*') ? 'active' : '' }}">View Employees</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('clinic-manager/add/doctor') || Request::is('clinic-manager/view/doctors') || Request::is('clinic-manager/edit/doctor/*') || Request::is('clinic-manager/profile/doctor/*') || Request::is('clinic-manager/search/schedules') || Request::is('clinic-manager/search/doctor/schedule') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-doctor"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinic-manager/add/doctor') || Request::is('clinic-manager/view/doctors') || Request::is('clinic-manager/edit/doctor/*') || Request::is('clinic-manager/profile/doctor/*') || Request::is('clinic-manager/search/schedules') || Request::is('clinic-manager/search/doctor/schedule') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic.add_doctor') }}" class="{{ Request::is('clinic-manager/add/doctor') ? 'active' : '' }}">Add Doctor</a>
                        </li>
                        <li>
                            <a href="{{ route('clinic.view_doctors') }}" class="{{ Request::is('clinic-manager/view/doctors') || Request::is('clinic-manager/edit/doctor/*') || Request::is('clinic-manager/profile/doctor/*') ? 'active' : '' }}">View Doctors</a>
                        </li>
                        <li>
                            <a href="{{ route('clinic.search_schedules') }}" class="{{ Request::is('clinic-manager/search/schedules') || Request::is('clinic-manager/search/doctor/schedule') ? 'active' : '' }}">Doctor Schedules</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('clinic-manager/add/patient') || Request::is('clinic-manager/view/patients')  || Request::is('clinic-manager/profile/patient/*') || Request::is('clinic-manager/edit/patient/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-injured"></i> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinic-manager/view/patients')  || Request::is('clinic-manager/profile/patient/*') || Request::is('clinic-manager/edit/patient/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic.add_patient') }}" class="{{ Request::is('clinic-manager/add/patient') ? 'active' : '' }}">Add Patient</a>
                        </li>

                        <li>
                            <a href="{{ route('clinic.view_patients') }}" class="{{ Request::is('clinic-manager/view/patients') || Request::is('clinic-manager/profile/patient/*') || Request::is('clinic-manager/edit/patient/*') ? 'active' : '' }}">View Patients</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('clinic-manager/view/appointments') || Request::is('clinic-manager/search/appointments') || Request::is('clinic-manager/details/appointment/*') || Request::is('clinic-manager/appointments-trash') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-calendar-alt"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinic-manager/view/appointments') || Request::is('clinic-manager/search/appointments') || Request::is('clinic-manager/details/appointment/*') || Request::is('clinic-manager/appointments-trash') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic.view_appointments') }}"
                            class="{{ Request::is('clinic-manager/view/appointments') || Request::is('clinic-manager/search/appointments') || Request::is('clinic-manager/details/appointment/*') || Request::is('clinic-manager/appointments-trash') ? 'active' : '' }}">View Appointments</a>
                        </li>
                    </ul>
                </li>

            </ul>


            <ul>
                <li class="menu-title">Invoices & Reports</li>
                <li class="submenu {{ Request::is('clinic-manager/view/invoices') || Request::is('clinic-manager/details/invoice/*') || Request::is('clinic-manager/details/refund-invoice/*') || Request::is('clinic-manager/invoice-pdf/view/*') || Request::is('clinic-manager/cancelled-invoice-pdf/view/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span> Invoices </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ Request::is('clinic-manager/view/invoices') || Request::is('clinic-manager/details/invoice/*') || Request::is('clinic-manager/details/refund-invoice/*') || Request::is('clinic-manager/invoice-pdf/view/*') || Request::is('clinic-manager/cancelled-invoice-pdf/view/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic.view_invoices') }}"
                               class="{{ Request::is('clinic-manager/view/invoices') || Request::is('clinic-manager/details/invoice/*') || Request::is('clinic-manager/details/refund-invoice/*') || Request::is('clinic-manager/invoice-pdf/view/*') || Request::is('clinic-manager/cancelled-invoice-pdf/view/*') ? 'active' : '' }}">
                                View Invoices
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu  {{ Request::is('clinic-manager/view/reports') || Request::is('clinic-manager/details/patients-reports*') || Request::is('clinic-manager/details/appointments-reports*') || Request::is('clinic-manager/details/invoices-reports*') || Request::is('clinic-manager/details/doctors-reports*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-file-alt"></i>
                        <span> Reports </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ Request::is('clinic-manager/view/report') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic.view_reports') }}"
                               class="{{ Request::is('clinic-manager/view/reports') || Request::is('clinic-manager/details/patients-reports*') || Request::is('clinic-manager/details/appointments-reports*') || Request::is('clinic-manager/details/invoices-reports*') || Request::is('clinic-manager/details/doctors-reports*') ? 'active' : '' }}">
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
                <li class="submenu {{ Request::is('clinic-manager/edit/profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('clinic-manager/edit/profile')  ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('clinic_manager_edit_profile') }}" class="{{ Request::is('clinic-manager/edit/profile') ? 'active' : '' }}">Edit Profile</a>
                        </li>
                    </ul>
                </li>
            </ul>



        </div>
    </div>
</div>
