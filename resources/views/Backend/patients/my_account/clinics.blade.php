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
                <a href="index.html" class="logo d-flex align-items-center me-auto" style="margin-left: 30px;">
                    <img src="{{ asset('patients/img/logo.png') }}" width="40" height="40" alt="">
                    <span style="font-size: 24px;"><strong>Clinics Management</strong></span>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ route('clinics_view') }}" class="active">Clinics<br></a></li>
                        <li><a href="{{ route('doctors_view') }}">Doctors</a></li>
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
      <section class="ourClinics">
        <div class="container mt-5 mb-6 header-ourClinics">
          <div class="row">
            <div class="col-12 text-center mb-4">
              <h2 class="section-title" style="color: #007BFF">Our Clinics</h2>
              <div class="form d-flex justify-content-center">
                <input type="search" name="" id="" placeholder="Search About Clinics....">
                <select name="" id="">
                  <option value="" selected disabled>Select specification clinic</option>
                  <option value="general-clinic">General Clinics</option>
                  <option value="dental-clinic">Dental Clinics</option>
                  <option value="medical-specialist-clinics">Medical & Specialist Clinics</option>
                  <option value="pediatric-clinics">Pediatric Clinics</option>
                  <option value="eye-clinics">Eye Clinics</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card clinic-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/clinics/care-center.jpg') }}" class="card-img-top" alt="care center clinics">
                </div>
                <div class="card-body">
                  <div class="detailsClinic">
                    <h3>CarePoint Clinic</h3>
                    <p>Specialisation: <mark>General</mark></p>
                    <div class="rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <span class="rating-number">4.9</span>
                    </div>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailsClinic">Details</button>
                    <button>Book now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card clinic-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/clinics/clinic9sa_cover.jpg') }}" class="card-img-top" alt="clinics cover">
                </div>
                <div class="card-body">
                  <div class="detailsClinic">
                    <h3>LifeCare Clinic</h3>
                    <p>Specialisation: <mark>General</mark></p>
                    <div class="rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <span class="rating-number">4.9</span>
                    </div>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailsClinic">Details</button>
                    <button>Book now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card clinic-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/clinics/healte-center.jpg') }}" class="card-img-top" alt="healte center clinics">
                </div>
                <div class="card-body">
                  <div class="detailsClinic">
                    <h3>MediCare Center</h3>
                    <p>Specialisation: <mark>General</mark></p>
                    <div class="rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <span class="rating-number">4.9</span>
                    </div>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailsClinic">Details</button>
                    <button>Book now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card clinic-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/clinics/Medical-Clinic-Central_Reception.jpg') }}" class="card-img-top" alt="medical clinics centeral">
                </div>
                <div class="card-body">
                  <div class="detailsClinic">
                    <h3>Prime Health Clinic</h3>
                    <p>Specialisation: <mark>General</mark></p>
                    <div class="rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <span class="rating-number">4.9</span>
                    </div>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailsClinic">Details</button>
                    <button>Book now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card clinic-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/clinics/medical-clinics.jpg') }}" class="card-img-top" alt="medical clinics">
                </div>
                <div class="card-body">
                  <div class="detailsClinic">
                    <h3>Unity Medical Clinic</h3>
                    <p>Specialisation: <mark>General</mark></p>
                    <div class="rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <span class="rating-number">4.9</span>
                    </div>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailsClinic">Details</button>
                    <button>Book Now</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4 col-md-6">
              <div class="card clinic-card h-100">
                <div class="cardHeader">
                  <img src="{{ asset('patients/img/clinics/Patient-rooms-curved-headwall-fabricated-by-HIMACS-solid-surface-material.jpg') }}" class="card-img-top" alt="Patient rooms">
                </div>
                <div class="card-body">
                  <div class="detailsClinic">
                    <h3>City Health Clinic</h3>
                    <p>Specialisation: <mark>General</mark></p>
                    <div class="rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <span class="rating-number">4.9</span>
                    </div>
                  </div>
                  <div class="buttons">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#detailsClinic">Details</button>
                    <button>Book Now</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="detailsClinic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">City Health Clinic</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="clinic-info">
                      <img src="{{ asset('patients/img/clinics/Patient-rooms-curved-headwall-fabricated-by-HIMACS-solid-surface-material.jpg') }}" alt="clinic image" class="img-fluid mb-3">
                      <div>
                        <h3>City Health Clinic</h3>
                        <p>Specialisation: <mark>General</mark></p>
                        <div class="rating">
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <span class="rating-number">4.9</span>
                        </div>
                        <button>Book Appointment</button>
                      </div>
                    </div>
                    <div class="about-clinic">
                      <div>
                        <h3>Clinic Departments</h3>
                        <ul>
                          <li><i class="fa-solid fa-check"></i> General Medicine</li>
                          <li><i class="fa-solid fa-check"></i> Pediatrics</li>
                          <li><i class="fa-solid fa-check"></i> Dentistry</li>
                          <li><i class="fa-solid fa-check"></i> Cardiology</li>
                          <li><i class="fa-solid fa-check"></i> Dermatology</li>
                          <li><i class="fa-solid fa-check"></i> Orthopedics</li>
                          <li><i class="fa-solid fa-check"></i> Ophthalmology</li>
                          <li><i class="fa-solid fa-check"></i> Gynecology</li>
                          <li><i class="fa-solid fa-check"></i> Physiotherapy</li>
                        </ul>
                      </div>
                      <div>
                        <h3>Clinic Hours</h3>
                        <ul>
                          <li><i class="fa-solid fa-check"></i> Monday - Friday: 8:00 AM - 8:00 PM</li>
                          <li><i class="fa-solid fa-check"></i> Saturday: 9:00 AM - 5:00 PM</li>
                          <li><i class="fa-solid fa-check"></i> Sunday: Closed</li>
                        </ul>
                      </div>
                    </div>
                    <div class="address-clinic">
                      <h3>Clinic Location</h3>
                      <address><i class="fa-solid fa-location-dot"></i> 123 Main Street, City, Country</address>
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
