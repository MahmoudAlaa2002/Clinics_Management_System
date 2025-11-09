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
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span
                    class="float-right badge badge-pill bg-danger">3</span></a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span>Notifications</span>
                </div>
                <div class="drop-scroll">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media">
                                    <span class="avatar">
                                        <img alt="John Doe" src="{{ asset('assets/img/user.jpg') }}" class="img-fluid">
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title">John Doe</span> added new task
                                            <span class="noti-title">Patient appointment booking</span></p>
                                        <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media">
                                    <span class="avatar">V</span>
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed
                                            the task name <span class="noti-title">Appointment booking with payment
                                                gateway</span></p>
                                        <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media">
                                    <span class="avatar">L</span>
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span
                                                class="noti-title">Domenic Houston</span> and <span
                                                class="noti-title">Claire Mapes</span> to project <span
                                                class="noti-title">Doctor available module</span></p>
                                        <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media">
                                    <span class="avatar">G</span>
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed
                                            task <span class="noti-title">Patient and Doctor video conferencing</span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media">
                                    <span class="avatar">V</span>
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added
                                            new task <span class="noti-title">Private chat module</span></p>
                                        <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="">View all Notifications</a>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i
                    class="fa fa-comment-o"></i> <span class="float-right badge badge-pill bg-danger">8</span></a>
        </li>
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" style="width: 40px; height:40px; margin-right:5px;"
                        src="{{ asset($doctor->image) }}" alt="Doctor">
                </span>
                <span>
                    {{ $doctor->name }}
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
