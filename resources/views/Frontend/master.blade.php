<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Clinics Management - Home</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.ico') }}" rel="shortcut icon" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('homeView/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('homeView/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('homeView/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('homeView/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('homeView/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('homeView/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main CSS File -->
    <link href="{{asset('homeView/css/main.css')}}" rel="stylesheet">

</head>

<body class="index-page">



    @include('Frontend.layout.header')



    @include('Frontend.index')



    @include('Frontend.layout.footer')




    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" style="background-color: #00A8FF;"><i class="bi bi-arrow-up-short"></i></a>



    <script src="{{ asset('homeView/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('homeView/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('homeView/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('homeView/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('homeView/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('homeView/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('homeView/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js')
</body>

</html>






















