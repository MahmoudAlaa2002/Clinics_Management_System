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
                <li class="menu-title">Main</li>


                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin_dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="submenu {{ Request::is('add/clinic') || Request::is('view/clinics') || Request::is('edit/clinic/*') || Request::is('description/clinic/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinics </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/clinic') || Request::is('view/clinics') || Request::is('edit/clinic/*') || Request::is('description/clinic/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_clinic') }}" class="{{ Request::is('add/clinic') ? 'active' : '' }}">Add Clinic</a>
                        </li>
                        <li>
                            <a href="{{ route('view_clinics') }}" class="{{ Request::is('view/clinics') || Request::is('edit/clinic/*') || Request::is('description/clinic/*') ? 'active' : '' }}">View Clinics</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('add/specialty') || Request::is('view/specialties') || Request::is('edit/specialty/*') || Request::is('description/specialty/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-stethoscope"></i> <span> Specialty </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/specialty') || Request::is('view/specialties') || Request::is('edit/specialty/*') || Request::is('description/specialty/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_specialty') }}" class="{{ Request::is('add/specialty') ? 'active' : '' }}">Add Specialty</a>
                        </li>
                        <li>
                            <a href="{{ route('view_specialties') }}" class="{{ Request::is('view/specialties') || Request::is('edit/specialty/*') || Request::is('description/specialty/*') ? 'active' : '' }}">View Specialty</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('add/doctor') || Request::is('view/doctors') || Request::is('edit/doctor/*') || Request::is('profile/doctor/*') || Request::is('view/clinic/managers') || Request::is('search/doctor/schedules') ? 'active' : '' }}">
                    <a href="#"><i class="fa-solid fa-user-doctor"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/doctor') || Request::is('view/doctors') || Request::is('edit/doctor/*') || Request::is('profile/doctor/*') || Request::is('view/clinic/managers') || Request::is('search/doctor/schedules') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_doctor') }}" class="{{ Request::is('add/doctor') ? 'active' : '' }}">Add Doctor</a>
                        </li>
                        <li>
                            <a href="{{ route('view_doctors') }}" class="{{ Request::is('view/doctors') || Request::is('edit/doctor/*') || Request::is('profile/doctor/*') ? 'active' : '' }}">View Doctors</a>
                        </li>
                        <li>
                            <a href="{{ route('view_clinic_managers') }}" class="{{ Request::is('view/clinic/managers') ? 'active' : '' }}">View Clinic Managers</a>
                        </li>
                        <li>
                            <a href="{{ route('search_doctor_schedules') }}" class="{{ Request::is('search/doctor/schedules') ? 'active' : '' }}">Doctor Schedules</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('add/patient') || Request::is('view/patients') || Request::is('edit/patient/*') || Request::is('profile/patient/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user-injured"></i> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/patient') || Request::is('view/patients') || Request::is('edit/patient/*') || Request::is('profile/patient/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_patient') }}" class="{{ Request::is('add/patient') ? 'active' : '' }}">Add Patient</a>
                        </li>
                        <li>
                            <a href="{{ route('view_patients') }}" class="{{ Request::is('view/patients') || Request::is('edit/patient/*') || Request::is('profile/patient/*') ? 'active' : '' }}">View Patients</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('add/appointment') || Request::is('view/appointments') || Request::is('search/appointments') ||
                    Request::is('edit/appointment/*') || Request::is('description/appointment/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-calendar-check-o"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/appointment') || Request::is('view/appointments') || Request::is('search/appointments') ||
                                    Request::is('edit/appointment/*') || Request::is('description/appointment/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_appointment') }}" class="{{ Request::is('add/appointment') ? 'active' : '' }}">Add Appointment</a>
                        </li>
                        <li>
                            <a href="{{ route('view_appointments') }}"
                            class="{{ Request::is('view/appointments') || Request::is('search/appointments') || Request::is('edit/appointment/*') || Request::is('description/appointment/*') ? 'active' : '' }}">View Appointments</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('add/medication') || Request::is('view/medications') || Request::is('edit/medication/*') || Request::is('description/medication/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-capsules"></i> <span> Medications </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/medication') || Request::is('view/medications') || Request::is('edit/medication/*') || Request::is('description/medication/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_medication') }}" class="{{ Request::is('add/medication') ? 'active' : '' }}">Add Medication</a>
                        </li>
                        <li>
                            <a href="{{ route('view_medications') }}" class="{{ Request::is('view/medications') || Request::is('edit/medication/*') || Request::is('description/medication/*') ? 'active' : '' }}">View Medications</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('view/prescriptions') || Request::is('prescription_items/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-file-medical"></i> <span> Prescriptions </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('view/prescriptions') || Request::is('prescription_items/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('view_prescriptions') }}" class="{{ Request::is('view/prescriptions') ? 'active' : '' }}">View Prescriptions</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('add/employee') || Request::is('view/employees') || Request::is('edit/employee/*') || Request::is('profile/employee/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-user"></i> <span> Employee </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/employee') || Request::is('view/employees') || Request::is('edit/employee/*') || Request::is('profile/employee/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_employee') }}" class="{{ Request::is('add/employee') ? 'active' : '' }}">Add Employee</a>
                        </li>
                        <li>
                            <a href="{{ route('view_employees') }}" class="{{ Request::is('view/employees') || Request::is('edit/employee/*') || Request::is('profile/employee/*') ? 'active' : '' }}">View Employee</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('add/toStock') || Request::is('view/stocks') || Request::is('expired/alerts') || Request::is('edit/stock/*') || Request::is('description/stock/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-warehouse"></i> <span> Medicine Stock </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('add/toStock') || Request::is('view/stocks') || Request::is('expired/alerts') ||
                                    Request::is('edit/stock/*') || Request::is('description/stock/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_to_stock') }}" class="{{ Request::is('add/toStock') ? 'active' : '' }}">Add Stock</a>
                        </li>
                        <li>
                            <a href="{{ route('view_stocks') }}" class="{{ Request::is('view/stocks') || Request::is('edit/stock/*') || Request::is('description/stock/*') ? 'active' : '' }}">View Stock</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu">
                    <a href="#"><i class="fa fa-money"></i> <span> Finance </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{ route('view_invoices') }}">Patient Invoices</a></li>
                        <li><a href="{{ route('view_payments') }}">Patient Payments</a></li>
                        <li><a href="{{ route('view_vendors_invoices') }}">Vendor Invoices</a></li>
                        <li><a href="{{ route('view_expenses') }}">Expenses</a></li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('view/reports') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-file-alt"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('view/reports') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('view_reports') }}" class="{{ Request::is('view/reports') ? 'active' : '' }}">View Reports</a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="submenu">
                    <a href="#"><i class="fa fa-book"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="salary.html"> Employee Salary </a></li>
                        <li><a href="salary-view.html"> Payslip </a></li>
                    </ul>
                </li>

                <li>
                    <a href="chat.html"><i class="fa fa-comments"></i> <span>Chat</span> <span class="float-right badge badge-pill bg-primary">5</span></a>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fa fa-video-camera camera"></i> <span> Calls</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="voice-call.html">Voice Call</a></li>
                        <li><a href="video-call.html">Video Call</a></li>
                        <li><a href="incoming-call.html">Incoming Call</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fa fa-envelope"></i> <span> Email</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="compose.html">Compose Mail</a></li>
                        <li><a href="inbox.html">Inbox</a></li>
                        <li><a href="mail-view.html">Mail View</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="blog-details.html">Blog View</a></li>
                        <li><a href="add-blog.html">Add Blog</a></li>
                        <li><a href="edit-blog.html">Edit Blog</a></li>
                    </ul>
                </li>

                <li>
                    <a href="assets.html"><i class="fa fa-cube"></i> <span>Assets</span></a>
                </li>

                <li>
                    <a href="activities.html"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fa fa-flag-o"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="expense-reports.html"> Expense Report </a></li>
                        <li><a href="invoice-reports.html"> Invoice Report </a></li>
                    </ul>
                </li>

                <li>
                    <a href="settings.html"><i class="fa fa-cog"></i> <span>Settings</span></a>
                </li>

                <li class="menu-title">UI Elements</li>

                <li class="submenu">
                    <a href="#"><i class="fa fa-laptop"></i> <span> Components</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="uikit.html">UI Kit</a></li>
                        <li><a href="typography.html">Typography</a></li>
                        <li><a href="tabs.html">Tabs</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fa fa-edit"></i> <span> Forms</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="form-basic-inputs.html">Basic Inputs</a></li>
                        <li><a href="form-input-groups.html">Input Groups</a></li>
                        <li><a href="form-horizontal.html">Horizontal Form</a></li>
                        <li><a href="form-vertical.html">Vertical Form</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fa fa-table"></i> <span> Tables</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="tables-basic.html">Basic Tables</a></li>
                        <li><a href="tables-datatables.html">Data Table</a></li>
                    </ul>
                </li>

                <li>
                    <a href="calendar.html"><i class="fa fa-calendar"></i> <span>Calendar</span></a>
                </li> --}}

                {{-- <li class="menu-title">Extras</li>
                <li class="submenu">
                    <a href="#"><i class="fa fa-columns"></i> <span>Pages</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="login.html"> Login </a></li>
                        <li><a href="register.html"> Register </a></li>
                        <li><a href="forgot-password.html"> Forgot Password </a></li>
                        <li><a href="change-password2.html"> Change Password </a></li>
                        <li><a href="lock-screen.html"> Lock Screen </a></li>
                        <li><a href="profile.html"> Profile </a></li>
                        <li><a href="gallery.html"> Gallery </a></li>
                        <li><a href="error-404.html">404 Error </a></li>
                        <li><a href="error-500.html">500 Error </a></li>
                        <li><a href="blank-page.html"> Blank Page </a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fa fa-share-alt"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="submenu">
                            <a href="javascript:void(0);"><span>Level 1</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><span>Level 1</span></a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
