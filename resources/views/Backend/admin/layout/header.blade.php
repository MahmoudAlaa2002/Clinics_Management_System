<style>
    .header .dropdown-menu .dropdown-item:hover {
        background-color: #007BFF;
        color: #ffffff;
    }
    .notification-message.unread {
        background-color: #f4f7fe;
    }

    .notification-message.read {
        opacity: 0.7;
    }

</style>



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
        @include('partials.notifications.notifications')


        @include('Backend.chat.index')


        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" style="width: 40px; height:40px; margin-right:5px;"
                         src="{{ asset($admin?->image ?? 'assets/img/user.jpg') }}" alt="">
                </span>
                <span>Admin</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                <a class="dropdown-item" href="{{ route('my_profile') }}">My Profile</a>
                <a class="dropdown-item" href="{{ route('edit_profile') }}">Edit Profile</a>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
</div>
