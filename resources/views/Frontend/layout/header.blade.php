<style>
    /* لو أردت أن تضمن أن النص يبقى واضح */
    .header a,
    .header h1,
    .header span,
    .header i {
        color: white !important;
    }

    .header a {
        color: white !important;
        text-decoration: none !important;
        border-bottom: none !important;
    }

    /* العنصر النشط: يظهر تحته خط أبيض */
    .header a.active {
        border-bottom: 2px solid white;
    }


    .navmenu a::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 100%;
        height: 2px;
        background-color: white;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease-in-out;
    }

    /* عند التحويم أو الصفحة النشطة */
    .navmenu a:hover::after,
    .navmenu a.active::after {
        transform: scaleX(1);
    }

    .auth-links {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-right: 10px;
    }

    .auth-links a {
        padding: 6px 16px;
        border-radius: 20px;
        border: 2px solid #fff !important;
        color: white;
        font-size: 14px;
        text-decoration: none;
        transition: 0.3s ease-in-out;
        background-color: transparent;
        font-weight: 500;
    }

    .auth-links a{
        min-width: 120px;
        text-align: center;
    }

    .auth-links a:hover {
        background-color: white !important;
        color: #007BFF !important;
    }

</style>

<header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto" style="margin-left: 30px;">
                <img src="{{ asset('assets/img/logo.png') }}" width="40" height="40" alt="">
                <span style="font-size: 24px;"><strong>Clinics Management</strong></span>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home<br></a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#departments">Departments</a></li>
                    <li><a href="#doctors">Doctors</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>

        <div class="auth-links">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        </div>
    </div>

</header>
