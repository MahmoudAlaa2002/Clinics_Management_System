<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Clinics Mnagement - @yield('title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('patients/img/favicon.jpg') }}" rel="shortcut icon" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('patients/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('patients/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('patients/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('patients/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('patients/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('patients/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main CSS File -->
    <link href="{{ asset('patients/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page">

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
        /* تأثير التحويم: يظهر خط أبيض عند التحويم */
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
          margin-right: 100px;
          transition: margin-right 0.3s ease-in-out;
        }

        .auth-links i.fa-circle-user {
          padding: 6px 17px;
          font-size: 20px;
          display: flex;
          align-items: center;
          justify-content: center;
          border: 2px solid #fff !important;
          border-radius: 50%;
          color: white;
          text-decoration: none;
          transition: all 0.5s ease-in-out;
          background-color: transparent;
          font-weight: 500;
          cursor: pointer;
        }
        .auth-links i.fa-circle-user:hover, .auth-links.active i.fa-circle-user{
          color: #007BFF !important;
          background-color: white !important;
        }

    </style>

    @include('Backend.patients.layout.header')




    @yield('content')



    @include('Backend.patients.layout.footer')





    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" style="background-color: #00A8FF;"><i class="bi bi-arrow-up-short"></i></a>



    <script src="{{ asset('patients/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('patients/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('patients/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('patients/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('patients/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('patients/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('patients/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js')

</body>

</html>
