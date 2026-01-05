<header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center justify-content-between">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('my_account') }}" class="logo d-flex align-items-center me-auto" style="margin-left: 30px;">
                <img src="{{ asset('patients/img/logo.png') }}" width="40" height="40" alt="">
                <span style="font-size: 24px;"><strong>Clinics Management</strong></span>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li>
                        <a class="{{ request()->routeIs('my_account') ? 'active' : '' }}"
                           href="{{ route('my_account') }}">
                            My Account
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.clinics_view') ? 'active' : '' }}"
                           href="{{ route('patient.clinics_view') }}">
                            Clinics
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.doctors_view') ? 'active' : '' }}"
                           href="{{ route('patient.doctors_view') }}">
                            Doctors
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.appointments_view') ? 'active' : '' }}"
                           href="{{ route('patient.appointments_view') }}">
                            Make-An-Appointment
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('patient.invoices_view') ? 'active' : '' }}"
                           href="{{ route('patient.invoices_view') }}">
                            Invoices
                        </a>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>

        <div class="auth-links">
            <i class="fa-solid fa-circle-user"></i>
            <div class="informationAboutuser">
              <div class="name">
                <span>{{ Auth::user()->name }}</span>
                <i class="fa-solid fa-user"></i>
              </div>
              <div class="myAppointment">
                <span><a href="myAppointment.html">My Appointments</a></span>
                <i class="fa-solid fa-calendar-check"></i>
              </div>
              <div class="settings">
                <span>Settings</span>
                <i class="fa-solid fa-gear"></i>
              </div>
          </div>
        </div>
    </div>
</header>