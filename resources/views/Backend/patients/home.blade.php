@extends('Backend.patients.master')

@section('title', 'Home')

@section('content')
    <main class="main">
        <section id="hero" class="hero section light-background">
            <img src="{{ asset('patients/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
            <div class="container position-relative">
                <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
                    <h2 style="color: #00A8FF;">WELCOME TO Clinics Management</h2>
                    <p>A modern website for managing medical clinics<br>and organizing appointments</p>
                </div>
                <div class="content row gy-4">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="why-box" data-aos="zoom-out" data-aos-delay="200" style="background-color:#00A8FF; ">
                            <h3>Why Choose Clinics Management System?</h3>
                            <p>
                                Our platform makes it easy for patients to book appointments with top clinics and the most
                                skilled doctors.
                                It ensures fast access to quality healthcare, saving time and effort for every patient.
                            </p>
                            <div class="text-center">
                                <a href="#about" class="more-btn"><span>Learn More</span> <i
                                        class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="row gy-4">
                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                                        <i class="bi bi-clipboard-data" style="color: #00A8FF"></i>
                                        <h4 style="color: #00A8FF">Corporis voluptates officia eiusmod</h4>
                                        <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut
                                            aliquip</p>
                                    </div>
                                </div>

                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                                        <i class="bi bi-gem" style="color: #00A8FF"></i>
                                        <h4 style="color: #00A8FF">Ullamco laboris ladore pan</h4>
                                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                            deserunt</p>
                                    </div>
                                </div>

                                <div class="col-xl-4 d-flex align-items-stretch">
                                    <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                                        <i class="bi bi-inboxes" style="color: #00A8FF"></i>
                                        <h4 style="color: #00A8FF">Labore consequatur incidid dolore</h4>
                                        <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container">
                <div class="row gy-4 gx-5">
                    <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('patients/img/Medical-Clinic.jpg') }}" class="img-fluid" alt=""
                            style="width: 800px; hight:800px;">
                    </div>
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <h3>About Us</h3>
                        <p>
                            Dolor iure expedita id fuga asperiores qui sunt consequatur minima. Quidem voluptas deleniti.
                            Sit quia molestiae quia quas qui magnam itaque veritatis dolores. Corrupti totam ut eius
                            incidunt reiciendis veritatis asperiores placeat.
                        </p>
                        <ul>
                            <li>
                                <i class="fa-solid fa-vial-circle-check"></i>
                                <div>
                                    <h5>Ullamco laboris nisi ut aliquip consequat</h5>
                                    <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-pump-medical"></i>
                                <div>
                                    <h5>Magnam soluta odio exercitationem reprehenderi</h5>
                                    <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata
                                        redi</p>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-heart-circle-xmark"></i>
                                <div>
                                    <h5>Voluptatem et qui exercitationem</h5>
                                    <p>Et velit et eos maiores est tempora et quos dolorem autem tempora incidunt maxime
                                        veniam</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section id="stats" class="stats section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="fa-regular fa-hospital"></i>
                        <div class="stats-item">
                            <span>{{ $clinics->count() }}</span>
                            <p>Clinics</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="fas fa-stethoscope"></i>
                        <div class="stats-item">
                            <span>{{ $departments->count() }}</span>
                            <p>Departments</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="fa-solid fa-user-doctor"></i>
                        <div class="stats-item">
                            <span>{{ $doctors->count() }}</span>
                            <p>Doctors</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="fas fa-user-injured"></i>
                        <div class="stats-item">
                            <span>{{ $patients->count() }}</span>
                            <p>Patients</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Services Section -->
        <section id="services" class="services section">
            <div class="container section-title" data-aos="fade-up">
                <h2 style="color: #00A8FF">Patient Services</h2>
                <p>Easy access to healthcare services designed for your comfort and convenience</p>
            </div>

            <div class="container">
                <div class="row gy-4">

                    <!-- Book Appointment -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon" style="background-color: #00A8FF">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <h3 style="color: #00A8FF">Book Appointment</h3>
                            <p>Schedule appointments with available doctors at your preferred date and time.</p>
                        </div>
                    </div>

                    <!-- Find Doctors -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon" style="background-color: #00A8FF">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <h3 style="color: #00A8FF">Find Doctors</h3>
                            <p>Browse doctors by specialty, experience, and department to find the right care.</p>
                        </div>
                    </div>

                    <!-- Medical Records -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon" style="background-color: #00A8FF">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <h3 style="color: #00A8FF">Medical Records</h3>
                            <p>View your medical history, diagnoses, prescriptions, and lab results securely.</p>
                        </div>
                    </div>

                    <!-- Appointment History -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon" style="background-color: #00A8FF">
                                <i class="fas fa-history"></i>
                            </div>
                            <h3 style="color: #00A8FF">Appointment History</h3>
                            <p>Track your past and upcoming appointments with full visit details.</p>
                        </div>
                    </div>

                    <!-- Prescriptions -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-item position-relative">
                            <div class="icon" style="background-color: #00A8FF">
                                <i class="fas fa-prescription-bottle-alt"></i>
                            </div>
                            <h3 style="color: #00A8FF">Prescriptions</h3>
                            <p>Access your prescribed medications, dosage instructions, and treatment plans.</p>
                        </div>
                    </div>

                    <!-- Profile & Security -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item position-relative">
                            <div class="icon" style="background-color: #00A8FF">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h3 style="color: #00A8FF">Profile & Security</h3>
                            <p>Update your personal information and manage account security settings.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <!-- Departments Section -->
        <section id="departments" class="Departments section">
            <div class="container section-title" data-aos="fade-up">
                <h2 style="color:#00A8FF">Departments</h2>
                <p>A Wide Range Of Medical Departments To Meet All Your Healthcare Needs</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <div class="col-lg-3" style="max-height: 500px; overflow-y: auto;">
                        <ul class="nav nav-tabs flex-column">
                            @foreach ($departments as $index => $department)
                                <li class="nav-item">
                                    <a class="nav-link {{ $index === 0 ? 'active show' : '' }}" data-bs-toggle="tab"
                                        href="#department-{{ $department->id }}">
                                        {{ $department->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-9 mt-4 mt-lg-0">
                        <div class="tab-content">
                            @foreach ($departments as $index => $department)
                                <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}"
                                    id="department-{{ $department->id }}">
                                    <div class="row">
                                        <div class="col-lg-8 details order-2 order-lg-1">
                                            <h3 style="color:#00A8FF">{{ $department->name }}</h3>
                                            <p>{{ $department->description }}</p>
                                        </div>
                                        <div class="col-lg-4 text-center order-1 order-lg-2">
                                            {{-- <img src="{{ asset('uploads/departments/' . $department->image) }}" alt="" class="img-fluid"> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Doctors Section -->
        <section id="doctors" class="doctors section">
            <div class="container section-title" data-aos="fade-up">
                <h2 style="color: #00A8FF">Doctors</h2>
                <p>Meet our expert doctors ready to care for your health</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    @foreach ($doctors as $doctor)
                            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="team-member d-flex align-items-start">
                                    <div class="pic"><img src="{{ asset($doctor->employee?->user?->image ?? 'assets/img/user.jpg') }}" class="img-fluid" alt=""></div>
                                    <div class="member-info">
                                        <h4>{{ $doctor->employee->user->name }}</h4>
                                        <span>{{ $doctor->employee->department->name }}</span>
                                        <p>{{ $doctor->employee->clinic->name }}</p>
                                        <div class="social">
                                            <a href=""><i class="bi bi-twitter-x"></i></a>
                                            <a href=""><i class="bi bi-facebook"></i></a>
                                            <a href=""><i class="bi bi-instagram"></i></a>
                                            <a href=""> <i class="bi bi-linkedin"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>

            </div>

        </section>

        <!-- Faq Section -->
        <section id="faq" class="faq section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2 style="color: #00A8FF;">Frequently Asked Questions</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
                        <div class="faq-container">
                            <div class="faq-item">
                                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                                <div class="faq-content">
                                    <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet
                                        non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor
                                        purus non.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Feugiat scelerisque varius morbi enim nunc faucibus?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum
                                        velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend
                                        donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in
                                        cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                                <div class="faq-content">
                                    <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus
                                        pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit.
                                        Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis
                                        tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum
                                        velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend
                                        donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in
                                        cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor?</h3>
                                <div class="faq-content">
                                    <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in
                                        est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl
                                        suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                                <div class="faq-content">
                                    <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed in
                                        suscipit sequi. Distinctio ipsam dolore et.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div><!-- End Faq Column-->

                </div>

            </div>

        </section>


        <!-- Testimonials Section -->
        {{-- <section id="testimonials" class="testimonials section">
        <div class="container">
            <div class="row align-items-center">
            <div class="col-lg-5 info" data-aos="fade-up" data-aos-delay="100">
                <h3>Patient Testimonials</h3>
                <p>
                This section showcases some of the feedback and experiences shared by patients who have used our platform to book appointments with doctors and subscribe to clinics.
                Their words reflect the quality of service and the ease of accessing medical care through our system.
                </p>
            </div>

            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">

                <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": "auto",
                    "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                    }
                    }
                </script>
                <div class="swiper-wrapper">

                    @foreach ($patientsTestimonials as $patientsTestimonial)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                            <div class="d-flex">
                                <img src="{{ asset($patientsTestimonial->patient->user->image) }}" class="testimonial-img flex-shrink-0" alt="">
                                <div>
                                <h3>{{ $patientsTestimonial->patient->user->name }}</h3>
                                <span>{{ $patientsTestimonial->patient->user->address }}</span>

                                <div class="stars">
                                    @php
                                        $rating = $patientsTestimonial->rating;
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                </div>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>{{ $patientsTestimonial->content }}</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            </div>
                        </div>
                    @endforeach -->
                    <div class="swiper-slide">
                    <div class="testimonial-item">
                    <div class="d-flex">
                        <div>
                            <h3>{{ $patientsTestimonial->patient->user->name }}</h3>
                            <span>{{ $patientsTestimonial->patient->user->address }}</span>
                        </div>
                    </div>
                    <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        <span>{{ $patientsTestimonial->content }}</span>
                        <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                    </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                </div>

            </div>

            </div>

        </div>

        </section> --}}


        <!-- Gallery Section -->
        <section id="gallery" class="gallery section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Gallery</h2>
                <p>Explore our photo gallery to get a glimpse of our clinics, modern equipment</p>
            </div>
            <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-0">
                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/gallery/gallery_01.jpg') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/gallery/gallery_02.jpg') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/image Hospital in Gaza/img1.jpg') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/image Hospital in Gaza/img2.jpg') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/image Hospital in Gaza/img3.jpg') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/image Hospital in Gaza/img4.jpg') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/gallery/gallery_07.jpg.webp') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('patients/img/gallery/gallery-8.jpg') }}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Have a question or need assistance? We’re here to help — get in touch with us anytime</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Address</h3>
                                <p>{{ $admin->address }}</p>
                            </div>
                        </div>

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>{{ $admin->phone }}</p>
                            </div>
                        </div>

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>{{ $admin->email }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-8">
                        <form action="{{ route('contact_send') }}" method="POST">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Your Name">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" id="email" class="form-control" name="email"
                                        placeholder="Your Email">
                                </div>

                                <div class="col-md-12">
                                    <input type="text" id="subject" class="form-control" name="subject"
                                        placeholder="Subject">
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" id="message" name="message" rows="6" placeholder="Message"></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary submit-btn addBtn"
                                        style="background-color: #00A8FF;">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection



@section('js')

<script>
    $('.addBtn').click(function (e) {
        e.preventDefault();

        let name = $('#name').val().trim();
        let email = $('#email').val().trim();
        let subject = $('#subject').val().trim();
        let message = $('#message').val();



        // إنشاء formData
        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('subject', subject);
        formData.append('message', message);

        if(name === '' || email === '' || subject === '' || message === ''){
            Swal.fire({
                title: 'Error!',
                text: 'Please Enter All Required Fields',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }else{
            $.ajax({
                method: 'POST',
                url: "{{ route('contact_send') }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.data == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: 'The Message Has Been Sent Successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#00A8FF',
                        }).then(() => {
                            window.location.href = '/patient/home';
                        });
                    }
                }
            });
        }
    });
</script>
@endsection
