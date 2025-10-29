<div class="header">
    <div class="header-left">
        <a href="{{ Route('dashboard') }}" class="logo">
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
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="float-right badge badge-pill bg-danger">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span>Notifications</span>
                </div>
                <div class="drop-scroll">
                    <ul class="notification-list">
                        @forelse(auth()->user()->notifications as $notification)
                            <li class="notification-message {{ $notification->read_at ? 'read' : 'unread' }}">
                                <a href="{{ $notification->data['url'] }}">
                                    <div class="media">
                                        <span class="avatar">
                                            <img alt="Notification" src="{{ asset($notification->data['image']) }}" class="img-fluid">
                                        </span>
                                        <div class="media-body">
                                            <p class="noti-details" style="color:black;">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <p class="noti-time">
                                                <span class="notification-time">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="text-center notification-message" style="margin-top:130px;">
                                <span class="text-muted">No notifications available</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="">View all Notifications</a>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown d-none d-sm-block">
            <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <span class="float-right badge badge-pill bg-danger">8</span></a>
        </li>
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" style="width: 40px; height:40px; margin-right:5px;" src="{{ asset($admin?->image) }}" alt="Admin">
                </span>
                <span>
                    Admin
                </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                <a class="dropdown-item" href="{{ route('my_profile') }}">My Profile</a>
                <a class="dropdown-item" href="{{ route('edit_profile') }}">Edit Profile</a>
                <a class="dropdown-item" href="{{ Route('logout') }}">Logout</a>
            </div>
        </li>
    </ul>
</div>
