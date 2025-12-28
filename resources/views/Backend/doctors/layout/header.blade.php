<div class="header">
    <div class="header-left">
        <a href="{{ Route('doctor_dashboard') }}" class="logo">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.png') }}" width="35" height="35" alt="">
                <span><strong>CMS</strong></span>
            </div>
        </a>
    </div>
    <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
    <a id="mobile_btn" class="float-left mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
    <ul class="float-right nav user-menu">


        {{-- Notifications --}}
        @include('partials.notifications.notifications')

        @include('Backend.chat.index')


        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" style="width: 40px; height:40px; margin-right:5px;"
                        src="{{ asset($doctor->image ?? 'assets/img/user.jpg') }}" alt="">
                </span>
                <span>
                    Doctor
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 p-3" style="min-width: 230px;">
                <div class="px-3 pb-2 border-bottom">
                    <h6 class="mb-0 fw-semibold text-secondary">Doctor Menu</h6>
                </div>

                <a href="{{ route('doctor_dashboard') }}"
                    class="dropdown-item py-2 d-flex align-items-center {{ request()->routeIs('doctor_dashboard') ? 'text-primary fw-semibold' : 'text-dark' }}">
                    <i class="fa fa-chart-line me-2 text-primary"></i> Dashboard
                </a>

                <a href="{{ route('doctor_profile') }}"
                    class="dropdown-item py-2 d-flex align-items-center {{ request()->routeIs('doctor_profile') ? 'text-primary fw-semibold' : 'text-dark' }}">
                    <i class="fa fa-user-md me-2 text-primary"></i> My Profile
                </a>

                <a href="{{ route('doctor.profile.edit') }}"
                    class="dropdown-item py-2 d-flex align-items-center {{ request()->routeIs('doctor.profile.edit') ? 'text-primary fw-semibold' : 'text-dark' }}">
                    <i class="fa fa-pen me-2 text-primary"></i> Edit Profile
                </a>

                <a href="{{ route('doctor.profile.settings') }}"
                    class="dropdown-item py-2 d-flex align-items-center {{ request()->routeIs('doctor.profile.settings') ? 'text-primary fw-semibold' : 'text-dark' }}">
                    <i class="fa fa-lock me-2 text-primary"></i> Account Settings
                </a>

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="dropdown-item py-2 d-flex align-items-center text-danger fw-semibold">
                        <i class="fa fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>

        </li>
    </ul>
</div>



<script>
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
