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
                    Request::is('admin/description/clinic/*') ||
                    Request::is('admin/view/clinics/managers') ||
                    Request::is('admin/profile/clinics/managers/*') ||
                    Request::is('admin/edit/clinics/managers/*')
                    ? 'active' : ''
                }}">
                    <a href="#"><i class="fa fa-hospital"></i> <span> Clinics </span> <span class="menu-arrow"></span></a>

                    <ul style="{{
                        Request::is('admin/add/clinic') ||
                        Request::is('admin/view/clinics') ||
                        Request::is('admin/edit/clinic/*') ||
                        Request::is('admin/description/clinic/*') ||
                        Request::is('admin/view/clinics/managers') ||
                        Request::is('admin/profile/clinics/managers/*') ||
                        Request::is('admin/edit/clinics/managers/*')
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
                               class="{{ Request::is('admin/view/clinics') || Request::is('admin/edit/clinic/*') || Request::is('admin/description/clinic/*') ? 'active' : '' }}">
                               View Clinics
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_clinics_managers') }}"
                               class="{{ Request::is('admin/view/clinics/managers') || Request::is('admin/profile/clinics/managers/*') || Request::is('admin/edit/clinics/managers/*') ? 'active' : '' }}">
                               View Clinics Managers
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('admin/add/department') || Request::is('admin/view/departments') || Request::is('admin/edit/department/*') || Request::is('admin/description/department/*') || Request::is('admin/view/department-managers') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i> <span> Departments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/department') || Request::is('admin/view/departments') || Request::is('admin/edit/department/*') || Request::is('admin/description/department/*') || Request::is('admin/view/department-managers') ? '' : 'display: none;' }}">

                        <li>
                            <a href="{{ route('add_department') }}" class="{{ Request::is('admin/add/department') ? 'active' : '' }}">
                                Add Department
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_departments') }}" class="{{ Request::is('admin/view/departments') || Request::is('admin/edit/department/*') || Request::is('admin/description/department/*') ? 'active' : '' }}">
                                View Departments
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_departments_managers') }}" class="{{ Request::is('admin/view/departments/managers') ? 'active' : '' }}">
                                Departments Managers
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('admin/add/specialty') || Request::is('admin/view/specialties') || Request::is('admin/edit/specialty/*') || Request::is('admin/description/specialty/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-stethoscope"></i> <span> Specialties </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/specialty') || Request::is('admin/view/specialties') || Request::is('admin/edit/specialty/*') || Request::is('admin/description/specialty/*')  ? '' : 'display: none;' }}">

                        <li>
                            <a href="{{ route('add_specialty') }}" class="{{ Request::is('admin/add/specialty') ? 'active' : '' }}">
                                Add Specialty
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('view_specialties') }}" class="{{ Request::is('admin/view/specialties') || Request::is('admin/edit/specialty/*') || Request::is('admin/description/specialty/*') ? 'active' : '' }}">
                                View Specialties
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


                <li class="submenu {{ Request::is('admin/add/appointment') || Request::is('admin/view/appointments') || Request::is('admin/search/appointments') ||
                    Request::is('admin/edit/appointment/*') || Request::is('admin/description/appointment/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-calendar-check-o"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/appointment') || Request::is('admin/view/appointments') || Request::is('admin/search/appointments') ||
                        Request::is('admin/edit/appointment/*') || Request::is('admin/description/appointment/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_appointment') }}" class="{{ Request::is('admin/add/appointment') ? 'active' : '' }}">Add Appointment</a>
                        </li>
                        <li>
                            <a href="{{ route('view_appointments') }}"
                            class="{{ Request::is('admin/view/appointments') || Request::is('admin/search/appointments') || Request::is('admin/edit/appointment/*') || Request::is('admin/description/appointment/*') ? 'active' : '' }}">View Appointments</a>
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

            <ul>
                <li class="menu-title">Medical Operations</li>

                {{-- <li class="submenu {{ Request::is('admin/add/ervice') || Request::is('admin/view/services') || Request::is('admin/edit/ervice/*') || Request::is('admin/profile/service/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-procedures"></i> <span> Services </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/service') || Request::is('admin/view/services') || Request::is('admin/edit/service/*') || Request::is('admin/profile/service/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_service') }}" class="{{ Request::is('admin/add/service') ? 'active' : '' }}">Add Service</a>
                        </li>
                        <li>
                            <a href="{{ route('view_services') }}" class="{{ Request::is('admin/view/services') || Request::is('admin/edit/service/*') || Request::is('admin/profile/service/*') ? 'active' : '' }}">View Service</a>
                        </li>
                    </ul>
                </li> --}}

                <li class="submenu {{ Request::is('admin/add/medication') || Request::is('admin/view/medications') || Request::is('admin/edit/medication/*') || Request::is('admin/description/medication/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-capsules"></i> <span> Medications </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/medication') || Request::is('admin/view/medications') || Request::is('admin/edit/medication/*') || Request::is('admin/description/medication/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_medication') }}" class="{{ Request::is('admin/add/medication') ? 'active' : '' }}">Add Medication</a>
                        </li>
                        <li>
                            <a href="{{ route('view_medications') }}" class="{{ Request::is('admin/view/medications') || Request::is('admin/edit/medication/*') || Request::is('admin/description/medication/*') ? 'active' : '' }}">View Medications</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('admin/view/prescriptions') || Request::is('admin/prescription_items/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-file-medical"></i> <span> Prescriptions </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/view/prescriptions') || Request::is('admin/prescription_items/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('view_prescriptions') }}" class="{{ Request::is('admin/view/prescriptions') ? 'active' : '' }}">View Prescriptions</a>
                        </li>
                    </ul>
                </li>


                <li class="submenu {{ Request::is('admin/add/toStock') || Request::is('admin/view/stocks') || Request::is('admin/expired/alerts') || Request::is('admin/edit/stock/*') || Request::is('admin/description/stock/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-warehouse"></i> <span> Medicine Stock </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/toStock') || Request::is('admin/view/stocks') || Request::is('admin/expired/alerts') || Request::is('admin/edit/stock/*') || Request::is('admin/description/stock/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_to_stock') }}" class="{{ Request::is('admin/add/toStock') ? 'active' : '' }}">Add Stock</a>
                        </li>
                        <li>
                            <a href="{{ route('view_stocks') }}" class="{{ Request::is('admin/view/stocks') || Request::is('admin/edit/stock/*') || Request::is('admin/description/stock/*') ? 'active' : '' }}">View Stock</a>
                        </li>
                    </ul>
                </li>
            </ul>


            <ul>
                <li class="menu-title">Administration</li>

                <li class="submenu {{
                    Request::is('admin/view/invoices') ||
                    Request::is('admin/details/invoice/*') ||
                    Request::is('admin/edit/invoice/*') ||
                    Request::is('admin/view/payments') ||
                    Request::is('admin/details/payment/*') ||
                    Request::is('admin/edit/payment/*') ||
                    Request::is('admin/edit/payment/Details/*') ||
                    Request::is('admin/view/vendors/invoices') ||
                    Request::is('admin/details/vendor/invoice/*') ||
                    Request::is('admin/edit/vendor/invoice/*') ||
                    Request::is('admin/view/expenses') ||
                    Request::is('admin/details/expense/*') ||
                    Request::is('admin/edit/expense/*') ||
                    Request::is('admin/edit/expense/Details/*')
                    ? 'active' : '' }}">

                    <a href="#"><i class="fa fa-money"></i> <span> Finance </span> <span class="menu-arrow"></span></a>

                    <ul style="{{
                        Request::is('admin/view/invoices') ||
                        Request::is('admin/details/invoice/*') ||
                        Request::is('admin/edit/invoice/*') ||
                        Request::is('admin/view/payments') ||
                        Request::is('admin/details/payment/*') ||
                        Request::is('admin/edit/payment/*') ||
                        Request::is('admin/edit/payment/Details/*') ||
                        Request::is('admin/view/vendors/invoices') ||
                        Request::is('admin/details/vendor/invoice/*') ||
                        Request::is('admin/edit/vendor/invoice/*') ||
                        Request::is('admin/view/expenses') ||
                        Request::is('admin/details/expense/*') ||
                        Request::is('admin/edit/expense/*') ||
                        Request::is('admin/edit/expense/Details/*')
                        ? '' : 'display: none;' }}">

                        <li>
                            <a href="{{ route('view_invoices') }}"
                                class="{{ Request::is('admin/view/invoices') || Request::is('admin/details/invoice/*') || Request::is('admin/edit/invoice/*') ? 'active' : '' }}">
                                Patient Invoices
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_payments') }}"
                                class="{{ Request::is('admin/view/payments') || Request::is('admin/details/payment/*') || Request::is('admin/edit/payment/*') || Request::is('admin/edit/payment/Details/*') ? 'active' : '' }}">
                                Patient Payments
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_vendors_invoices') }}"
                                class="{{ Request::is('admin/view/vendors/invoices') || Request::is('admin/details/vendor/invoice/*') || Request::is('admin/edit/vendor/invoice/*') ? 'active' : '' }}">
                                Vendor Invoices
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_expenses') }}"
                                class="{{ Request::is('admin/view/expenses') || Request::is('admin/details/expense/*') || Request::is('admin/edit/expense/*') || Request::is('admin/edit/expense/Details/*') ? 'active' : '' }}">
                                Expenses
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Request::is('admin/view/reports') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-file-alt"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/view/reports') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('view_reports') }}" class="{{ Request::is('admin/view/reports') ? 'active' : '' }}">View Reports</a>
                        </li>
                    </ul>
                </li>

            </ul>

            <ul>
                <li class="menu-title">System</li>

                <li class="submenu {{ Request::is('admin/add/employee') || Request::is('admin/view/employees') || Request::is('admin/edit/employee/*') || Request::is('admin/profile/employee/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ Request::is('admin/add/employee') || Request::is('admin/view/employees') || Request::is('admin/edit/employee/*') || Request::is('admin/profile/employee/*') ? '' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('add_employee') }}" class="{{ Request::is('admin/add/employee') ? 'active' : '' }}">Add Employee</a>
                        </li>
                        <li>
                            <a href="{{ route('view_employees') }}" class="{{ Request::is('admin/view/employees') || Request::is('admin/edit/employee/*') || Request::is('admin/profile/employee/*') ? 'active' : '' }}">View Employee</a>
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
