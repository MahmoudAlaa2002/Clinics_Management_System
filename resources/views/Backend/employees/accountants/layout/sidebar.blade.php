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

                <li class="{{ Request::is('employee/accountant/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('accountant_dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu {{ Request::is('employee/accountant/clinic-profile') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinic </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/accountant/clinic-profile') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('accountant.clinic_profile') }}" class="{{ Request::is('employee/accountant/clinic-profile') ? 'active' : '' }}">
                                Clinic Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('employee/accountant/view/depratments') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i> <span> Department </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/accountant/view/depratments') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('accountant.view_depratments') }}" class="{{ Request::is('employee/accountant/view/depratments') ? 'active' : '' }}">
                                View Departments
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/accountant/view/doctors') || Request::is('employee/accountant/profile/doctor/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-doctor"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/accountant/view/doctors') || Request::is('employee/accountant/profile/doctor/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('accountant.view_doctors') }}" class="{{ Request::is('employee/accountant/view/doctors') || Request::is('employee/accountant/profile/doctor/*') ? 'active' : '' }}">View Doctors</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/accountant/view/patients')  || Request::is('employee/accountant/profile/patient/*') || Request::is('employee/accountant/view/invoices-patients/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-injured"></i> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/accountant/view/patients')  || Request::is('employee/accountant/profile/patient/*') || Request::is('employee/accountant/view/invoices-patients/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('accountant.view_patients') }}" class="{{ Request::is('employee/accountant/view/patients') || Request::is('employee/accountant/profile/patient/*') || Request::is('employee/accountant/view/invoices-patients/*') ? 'active' : '' }}">View Patients</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('employee/accountant/view/appointments') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-calendar-alt"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/accountant/view/appointments') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('accountant.view_appointments') }}"
                            class="{{ Request::is('employee/accountant/view/appointments') ? 'active' : '' }}">View Appointments</a>
                        </li>
                    </ul>
                </li>

            </ul>


            <ul>
                <li class="menu-title">Invoices</li>
                <li class="submenu
                    {{ Request::is('employee/accountant/view/invoices') || Request::is('employee/accountant/details/invoice/*') || Request::is('employee/accountant/details/refund-invoice/*')  || Request::is('employee/accountant/invoice-pdf/view/*') || Request::is('employee/accountant/edit/invoice/*') || Request::is('employee/accountant/refund-confirm/*') || Request::is('employee/accountant/cancelled-invoice-pdf/view/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-file-invoice"></i>
                        <span> Invoices </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ Request::is('employee/accountant/view/invoices') || Request::is('employee/accountant/details/invoice/*') || Request::is('employee/accountant/details/refund-invoice/*') || Request::is('employee/accountant/invoice-pdf/view/*') || Request::is('employee/accountant/edit/invoice/*') || Request::is('employee/accountant/refund-confirm/*') || Request::is('employee/accountant/cancelled-invoice-pdf/view/*') ? '' : 'display: none;'}}">
                        <li>
                            <a href="{{ route('accountant.view_invoices') }}" class="{{ Request::is('employee/accountant/view/invoices') || Request::is('employee/accountant/details/invoice/*') || Request::is('employee/accountant/details/refund-invoice/*') || Request::is('employee/accountant/invoice-pdf/view/*') || Request::is('employee/accountant/edit/invoice/*') || Request::is('employee/accountant/refund-confirm/*') || Request::is('employee/accountant/cancelled-invoice-pdf/view/*') ? 'active' : '' }}">
                            View Invoices
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul>
                <li class="menu-title">System</li>
                <li class="submenu {{ Request::is('employee/accountant/edit/profile') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('employee/accountant/edit/profile')  ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('accountant_edit_profile') }}" class="{{ Request::is('employee/accountant/edit/profile') ? 'active' : '' }}">Edit Profile</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
