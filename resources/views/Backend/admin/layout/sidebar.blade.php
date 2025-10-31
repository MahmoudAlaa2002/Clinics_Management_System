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

                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu {{
                    Request::is('admin/add/clinic') ||
                    Request::is('admin/view/clinics') ||
                    Request::is('admin/edit/clinic/*') ||
                    Request::is('admin/details/clinic/*') ||
                    Request::is('admin/view/clinics-managers') ||
                    Request::is('admin/profile/clinics-managers/*') ||
                    Request::is('admin/edit/clinics-managers/*')
                    ? 'active' : ''
                }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinics </span> <span class="menu-arrow"></span></a>

                    <ul style="{{
                        Request::is('admin/add/clinic') ||
                        Request::is('admin/view/clinics') ||
                        Request::is('admin/edit/clinic/*') ||
                        Request::is('admin/details/clinic/*') ||
                        Request::is('admin/view/clinics-managers') ||
                        Request::is('admin/profile/clinics-managers/*') ||
                        Request::is('admin/edit/clinics-managers/*')
                        ? '' : 'display: none;'
                    }}">
                        <li>
                            <a href="{{ route('add_clinic') }}"
                               class="{{ Request::is('admin/add/clinic') ? 'active' : '' }}">
                               Add Clinic
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_clinics') }}"
                               class="{{ Request::is('admin/view/clinics') || Request::is('admin/edit/clinic/*') || Request::is('admin/details/clinic/*') ? 'active' : '' }}">
                               View Clinics
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_clinics_managers') }}"
                               class="{{ Request::is('admin/view/clinics-managers') || Request::is('admin/profile/clinics-managers/*') || Request::is('admin/edit/clinics-managers/*') ? 'active' : '' }}">
                               View Clinics Managers
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('admin/add/department') || Request::is('admin/view/departments') || Request::is('admin/edit/department/*') || Request::is('admin/details/department/*') || Request::is('admin/view/department-managers') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i> <span> Departments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/department') || Request::is('admin/view/departments') || Request::is('admin/edit/department/*') || Request::is('admin/details/department/*') || Request::is('admin/view/department-managers') ? '' : 'display: none;' }}">

                        <li>
                            <a href="{{ route('add_department') }}" class="{{ Request::is('admin/add/department') ? 'active' : '' }}">
                                Add Department
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_departments') }}" class="{{ Request::is('admin/view/departments') || Request::is('admin/edit/department/*') || Request::is('admin/details/department/*') ? 'active' : '' }}">
                                View Departments
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_departments_managers') }}" class="{{ Request::is('admin/view/departments-managers') ? 'active' : '' }}">
                                Departments Managers
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('admin/add/employee') || Request::is('admin/view/employees') || Request::is('admin/edit/employee/*') || Request::is('admin/profile/employee/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user"></i> <span> Employees </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/employee') || Request::is('admin/view/employees') || Request::is('admin/edit/employee/*') || Request::is('admin/profile/employee/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_employee') }}" class="{{ Request::is('admin/add/employee') ? 'active' : '' }}">Add Employee</a>
                        </li>
                        <li>
                            <a href="{{ route('view_employees') }}" class="{{ Request::is('admin/view/employees') || Request::is('admin/edit/employee/*') || Request::is('admin/profile/employee/*') ? 'active' : '' }}">View Employee</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('admin/add/doctor') || Request::is('admin/view/doctors') || Request::is('admin/edit/doctor/*') || Request::is('admin/profile/doctor/*')  || Request::is('admin/search/doctor/schedules') ? 'active' : '' }}">
                    <a href="#"><i class="fa-solid fa-user-doctor"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/doctor') || Request::is('admin/view/doctors') || Request::is('admin/edit/doctor/*') || Request::is('admin/profile/doctor/*')  || Request::is('admin/search/doctor/schedules') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_doctor') }}" class="{{ Request::is('admin/add/doctor') ? 'active' : '' }}">Add Doctor</a>
                        </li>
                        <li>
                            <a href="{{ route('view_doctors') }}" class="{{ Request::is('admin/view/doctors') || Request::is('admin/edit/doctor/*') || Request::is('admin/profile/doctor/*') ? 'active' : '' }}">View Doctors</a>
                        </li>
                        <li>
                            <a href="{{ route('search_doctor_schedules') }}" class="{{ Request::is('admin/search/doctor/schedules') ? 'active' : '' }}">Doctor Schedules</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('admin/add/patient') || Request::is('admin/view/patients') || Request::is('admin/edit/patient/*') || Request::is('admin/profile/patient/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-injured"></i> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/patient') || Request::is('admin/view/patients') || Request::is('admin/edit/patient/*') || Request::is('admin/profile/patient/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_patient') }}" class="{{ Request::is('admin/add/patient') ? 'active' : '' }}">Add Patient</a>
                        </li>
                        <li>
                            <a href="{{ route('view_patients') }}" class="{{ Request::is('admin/view/patients') || Request::is('admin/edit/patient/*') || Request::is('admin/profile/patient/*') ? 'active' : '' }}">View Patients</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('admin/add/appointment') || Request::is('admin/view/appointments') || Request::is('admin/search/appointments') || Request::is('admin/edit/appointment/*') || Request::is('admin/details/appointment/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-calendar-check-o"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/appointment') || Request::is('admin/view/appointments') || Request::is('admin/search/appointments') ||
                        Request::is('admin/edit/appointment/*') || Request::is('admin/details/appointment/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_appointment') }}" class="{{ Request::is('admin/add/appointment') ? 'active' : '' }}">Add Appointment</a>
                        </li>
                        <li>
                            <a href="{{ route('view_appointments') }}"
                            class="{{ Request::is('admin/view/appointments') || Request::is('admin/search/appointments') || Request::is('admin/edit/appointment/*') || Request::is('admin/details/appointment/*') ? 'active' : '' }}">View Appointments</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('admin/view/medical-records') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-notes-medical"></i> <span> Medical Records </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/view/medical-records') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('view_medical_records') }}" class="{{ Request::is('admin/view/medical-records') ? 'active' : '' }}">View Medical Records</a>
                        </li>
                    </ul>
                </li>
            </ul>




            <ul>
                <li class="menu-title">Invoices</li>

                <li class="submenu">
                    <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Invoices </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{ route('view_invoices') }}">View Invoices</a></li>
                    </ul>
                </li>
            </ul>


            <ul>
                <li class="menu-title">System</li>
                <li class="submenu {{ Request::is('admin/edit/profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/edit/profile')  ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('edit_profile') }}" class="{{ Request::is('admin/edit/profile') ? 'active' : '' }}">Edit Profile</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>



{{-- System
- Settings
- Notifications
- Audit Logs
- Support Tickets --}}
