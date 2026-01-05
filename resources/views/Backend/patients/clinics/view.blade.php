@extends('Backend.patients.master')

@section('title' , 'Clinics')

@section('content')
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
@endsection