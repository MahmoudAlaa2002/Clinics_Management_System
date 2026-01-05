@extends('Backend.patients.master')

@section('title' , 'Doctors')

@section('content')
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
@endsection