@extends('Backend.patients.master')

@section('title', 'Doctors')

@section('content')
    <main class="main">
        <section class="ourDoctors">
            <div class="container mt-5 mb-6 header-ourDoctors">

                <!-- Header + Search -->
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h2 class="section-title" style="color:#007BFF">Our Doctors</h2>

                        <form method="GET" class="form d-flex justify-content-center gap-3">
                            <input type="search" name="search" value="{{ request('search') }}"
                                placeholder="Search About Doctor....">

                            <select name="specialtie">
                                <option value="">Select Specialty</option>
                                @foreach ($specialties as $specialty)
                                    <option value="{{ $specialty }}"
                                        {{ request('specialtie') == $specialty ? 'selected' : '' }}>
                                        {{ $specialty }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Doctors -->
                <div class="row">

                    @foreach ($doctors as $doctor)
                        <div class="col-lg-4 mb-4 col-md-6">
                            <div class="card doctor-card h-100">

                                <div class="cardHeader">
                                    <img src="{{ asset($doctor->employee->user->image ?? 'patients/img/doctors/doctors-1.jpg') }}"
                                        class="card-img-top" alt="{{ $doctor->employee->user->name }}">

                                    <div>
                                        <h5 class="card-title">
                                            {{ $doctor->employee->user->name }}
                                        </h5>
                                        <em>
                                            {{ $doctor->employee->department->name ?? 'General' }}
                                        </em>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="detailsDoctor">
                                        {{-- <span>
                                            <small>{{ $doctor->experience ?? 'N/A' }} years of experience</small>
                                        </span> --}}
                                        <span>
                                            <small>{{ $doctor->employee->department->name ?? 'General' }}</small>
                                        </span>
                                    </div>

                                    <div class="buttons">
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#detailDoctor{{ $doctor->id }}">
                                            Details
                                        </button>
                                        <button>Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade modal-doctor" id="detailDoctor{{ $doctor->id }}" tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">
                                            {{ $doctor->employee->user->name }}
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="doctor-info">
                                            <img src="{{ asset($doctor->employee->user->image ?? 'patients/img/doctors/doctors-1.jpg') }}"
                                                class="card-img-top" alt="{{ $doctor->employee->user->name }}">

                                            <div>
                                                <h2>{{ $doctor->employee->user->name }}</h2>
                                                <small>
                                                    {{ $doctor->employee->department->name ?? 'General' }}
                                                    {{-- - {{ $doctor->experience ?? 'N/A' }} years experience --}}
                                                </small>

                                                <div class="rating">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="fa-solid fa-star"></i>
                                                    @endfor
                                                    <span class="rating-number">
                                                        {{ number_format($doctor->rating ?? 4.9, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="about-doctor">
                                            <h3>About Doctor</h3>
                                            <p>{{ $doctor->bio ?? 'No biography available.' }}</p>

                                            <h3>Working Hours</h3>
                                            <p>{{ $doctor->working_hours ?? 'Not specified' }}</p>

                                            <button type="button">Book Appointment</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    </main>
@endsection
