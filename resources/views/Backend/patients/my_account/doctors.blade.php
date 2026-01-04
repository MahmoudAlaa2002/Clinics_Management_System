<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Clinics Mnagement - Home</title>
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

    <header id="header" class="header sticky-top">
        <div class="branding d-flex align-items-center justify-content-between">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ route('index') }}" class="logo d-flex align-items-center me-auto" style="margin-left: 30px;">
                    <img src="{{ asset('patients/img/logo.png') }}" width="40" height="40" alt="">
                    <span style="font-size: 24px;"><strong>Clinics Management</strong></span>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ route('clinics_view') }}">Clinics<br></a></li>
                        <li><a href="{{ route('doctors_view') }}" class="active">Doctors</a></li>
                        <li><a href="makeAnAppointment.html">Make-An-Appointment</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>
            </div>

            <div class="auth-links">
                <i class="fa-solid fa-circle-user"></i>
                <div class="informationAboutuser">
                  <div class="name">
                    <span>Abdullah Badwan</span>
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




    <main class="main">
      <section class="ourDoctors">
        <div class="container mt-5 mb-6 header-ourDoctors">
          <div class="row">
            <div class="col-12 text-center mb-4">
              <h2 class="section-title" style="color: #007BFF">Our Doctors</h2>
              <div class="form d-flex justify-content-center">
                <input type="search" name="" id="" placeholder="Search About Doctor....">
                <select name="" id="">
                  <option value="" selected disabled>Select Specialty</option>
                  <option value="cardiology">Cardiology</option>
                  <option value="pediatrics">Pediatrics</option>
                  <option value="dermatology">Dermatology</option>
                  <option value="neurology">Neurology</option>
                  <option value="orthopedics">Orthopedics</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            
            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card doctor-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/doctors/doctors-1.jpg') }}" class="card-img-top" alt="Dr. John Doe">
                  <div class="">
                    <h5 class="card-title">Dr. John Doe</h5>
                    <em>Internal diseases</em>
                  </div>
                </div>
                <div class="card-body">
                  <div class="detailsDoctor">
                    <span><small>12 years of experience</small></span>
                    <span><small>Emergency reception</small></span>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailDoctor">Details</button>
                    <button>Book now</button>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card doctor-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/doctors/doctors-2.jpg') }}" class="card-img-top" alt="Dr. Jane Smith">
                  <div class="">
                    <h5 class="card-title">Dr. Jane Smith</h5>
                    <em>Internal diseases</em>
                  </div>
                </div>
                <div class="card-body">
                  <div class="detailsDoctor">
                    <span><small>12 years of experience</small></span>
                    <span><small>Emergency reception</small></span>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailDoctor">Details</button>
                    <button  type="button">Book now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card doctor-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/doctors/doctors-1.jpg') }}" class="card-img-top" alt="Dr. John Doe">
                  <div class="">
                    <h5 class="card-title">Dr. John Doe</h5>
                    <em>Internal diseases</em>
                  </div>
                </div>
                <div class="card-body">
                  <div class="detailsDoctor">
                    <span><small>12 years of experience</small></span>
                    <span><small>Emergency reception</small></span>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailDoctor">Details</button>
                    <button>Book now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card doctor-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/doctors/doctors-1.jpg') }}" class="card-img-top" alt="Dr. John Doe">
                  <div class="">
                    <h5 class="card-title">Dr. John Doe</h5>
                    <em>Internal diseases</em>
                  </div>
                </div>
                <div class="card-body">
                  <div class="detailsDoctor">
                    <span><small>12 years of experience</small></span>
                    <span><small>Emergency reception</small></span>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailDoctor">Details</button>
                    <button>Book now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card doctor-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/doctors/doctors-1.jpg') }}" class="card-img-top" alt="Dr. John Doe">
                  <div class="">
                    <h5 class="card-title">Dr. John Doe</h5>
                    <em>Internal diseases</em>
                  </div>
                </div>
                <div class="card-body">
                  <div class="detailsDoctor">
                    <span><small>12 years of experience</small></span>
                    <span><small>Emergency reception</small></span>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailDoctor">Details</button>
                    <button>Book Now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card doctor-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/doctors/doctors-1.jpg') }}" class="card-img-top" alt="Dr. John Doe">
                  <div class="">
                    <h5 class="card-title">Dr. John Doe</h5>
                    <em>Internal diseases</em>
                  </div>
                </div>
                <div class="card-body">
                  <div class="detailsDoctor">
                    <span><small>12 years of experience</small></span>
                    <span><small>Emergency reception</small></span>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailDoctor">Details</button>
                    <button>Book Now</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade modal-doctor" id="detailDoctor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Dr. John Doe</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="doctor-info">
                      <img src="{{ asset('patients/img/doctors/doctors-1.jpg') }}" class="card-img-top" alt="Dr. John Doe">
                      <div>
                        <h2>Dr. John Doe</h2>
                        <small>Cardiologist - 12 years experience</small>
                        <div class="rating">
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <span class="rating-number">4.9</span>
                        </div>
                      </div>
                    </div>
                    <div class="about-doctor">
                      <h3>About Doctor</h3>
                      <p>Dr. John Doe is a highly experienced cardiologist with over 12 years of practice in treating various heart conditions. He is dedicated to providing comprehensive care and personalized treatment plans for his patients.</p>
                      <h3>Working Hours</h3>
                      <p>Sun – Thu: 9:00 AM – 5:00 PM</p>
                      <button type="button">Book Appointment</button>
                    </div>
                    

                  </div>
                  <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div> -->
                </div>
              </div>
            </div>
      </section>
    </main>






    <footer id="footer" class="footer light-background">

        <div class="container footer-top">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
              <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <span class="sitename">CMS</span>
              </a>
              <div class="footer-contact pt-3">
                <p>A108 Adam Street</p>
                <p>New York, NY 535022</p>
                <p class="mt-3"><strong style="color:#00A8FF;">Phone:</strong> <span>+1 5589 55488 55</span></p>
                <p><strong style="color:#00A8FF;">Email:</strong> <span>info@example.com</span></p>
              </div>
              <div class="social-links d-flex mt-4">
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
              <h4>Useful Links</h4>
              <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Terms of service</a></li>
                <li><a href="#">Privacy policy</a></li>
              </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li><a href="#">Web Design</a></li>
                <li><a href="#">Web Development</a></li>
                <li><a href="#">Product Management</a></li>
                <li><a href="#">Marketing</a></li>
                <li><a href="#">Graphic Design</a></li>
              </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
              <h4>Hic solutasetp</h4>
              <ul>
                <li><a href="#">Molestiae accusamus iure</a></li>
                <li><a href="#">Excepturi dignissimos</a></li>
                <li><a href="#">Suscipit distinctio</a></li>
                <li><a href="#">Dilecta</a></li>
                <li><a href="#">Sit quas consectetur</a></li>
              </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
              <h4>Nobis illum</h4>
              <ul>
                <li><a href="#">Ipsam</a></li>
                <li><a href="#">Laudantium dolorum</a></li>
                <li><a href="#">Dinera</a></li>
                <li><a href="#">Trodelas</a></li>
                <li><a href="#">Flexo</a></li>
              </ul>
            </div>

          </div>
        </div>

        <div class="container copyright text-center mt-4">
          <p>© <span>Copyright</span> <strong class="px-1 sitename">CMS</strong> <span>All Rights Reserved</span></p>
        </div>

    </footer>





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
</body>

</html>