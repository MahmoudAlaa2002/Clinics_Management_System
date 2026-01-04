<style>
    .notification-message.unread {
        background-color: #f4f7fe;
    }

    .notification-message.read {
        opacity: 0.7;
    }

    .header .dropdown-menu{
        width: 240px;
        border-radius: 14px;
        border: 1px solid #e6ecf3;
        box-shadow: 0 14px 28px rgba(0,0,0,.08);
        padding: 10px 0;
        overflow: hidden;
    }

    .dropdown-user-header{
        padding: 14px 16px;
        background:#f7f9fc;
        border-bottom: 1px solid #eef2f8;
    }

    .dropdown-user-header .user-name{
        font-weight: 700;
        font-size: 15px;
    }

    .dropdown-user-header .user-role{
        color:#6c757d;
        font-size: 13px;
    }

    /* each item */
    .header .dropdown-item{
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: .25s ease;
    }

    /* icons */
    .header .dropdown-item i{
        width: 18px;
        text-align: center;
        color:#6c757d;
    }

    /* hover */
    .header .dropdown-item:hover{
        background:#007bff;
        color:#fff;
    }

    .header .dropdown-item:hover i{
        color:#fff;
    }

    /* divider line */
    .dropdown-divider{
        margin: 6px 0;
    }

</style>

<div class="header">
    <div class="header-left">
        <a href="{{ Route('nurse_dashboard') }}" class="logo">
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
                    <img class="rounded-circle" style="width: 40px; height:40px; margin-right:5px;" src="{{ asset($nurse?->image ?? 'assets/img/user.jpg') }}" alt="">
                </span>
                <span>
                    Nurse
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="dropdown-user-header">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">Nurse</div>
                </div>
            
                <a class="dropdown-item" href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                <a class="dropdown-item" href="{{ route('nurse_profile') }}"><i class="fa fa-user"></i> My Profile</a>
                <a class="dropdown-item" href="{{ route('nurse_edit_profile') }}"><i class="fa fa-edit"></i> Edit Profile</a>
            
                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
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
