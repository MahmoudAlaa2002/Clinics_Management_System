@extends('Backend.patients.master')

@section('title', 'Clinics')

@section('content')
    <main class="main">
        <section class="ourClinics">
            <div class="container mt-5 mb-6 header-ourClinics">

                <!-- Header + Search -->
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h2 class="section-title" style="color: #007BFF">Our Clinics</h2>

                        <form method="GET" action="{{ route('patient.clinics_view') }}"
                            class="form d-flex justify-content-center gap-3">

                            <input type="search" name="search" value="{{ request('search') }}"
                                placeholder="Search About Clinics....">

                            <select name="department">
                                <option value="">Select specification clinic</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Clinics -->
                <div class="row">

                    @foreach ($clinics as $clinic)
                        <div class="col-lg-4 mb-4 col-md-6">
                            <div class="card clinic-card h-100">
                                <div class="cardHeader">
                                    <img src="{{ asset($clinic->image ?? 'patients/img/clinics/care-center.jpg') }}"
                                        class="card-img-top" alt="{{ $clinic->name }}">
                                </div>

                                <div class="card-body">
                                    <div class="detailsClinic">
                                        <h3>{{ $clinic->name }}</h3>
                                        <p>
                                            Specialisation:
                                            <mark>{{ $clinic->department->name ?? 'General' }}</mark>
                                        </p>

                                        <div class="rating">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                            <span class="rating-number">
                                                {{ number_format($clinic->rating ?? 4.9, 1) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="buttons">
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#detailsClinic{{ $clinic->id }}">
                                            Details
                                        </button>
                                        <button>Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="detailsClinic{{ $clinic->id }}" tabindex="-1" aria-hidden="true">

                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">{{ $clinic->name }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="clinic-info">
                                            <img src="{{ asset($clinic->image ?? 'patients/img/clinics/care-center.jpg') }}"
                                                class="img-fluid mb-3" alt="{{ $clinic->name }}">

                                            <div>
                                                <h3>{{ $clinic->name }}</h3>
                                                <p>
                                                    Specialisation:
                                                    <mark>{{ $clinic->department->name ?? 'General' }}</mark>
                                                </p>

                                                <div class="rating">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="fa-solid fa-star"></i>
                                                    @endfor
                                                    <span class="rating-number">
                                                        {{ number_format($clinic->rating ?? 4.9, 1) }}
                                                    </span>
                                                </div>

                                                <button>Book Appointment</button>
                                            </div>
                                        </div>

                                        <div class="about-clinic">
                                            <div>
                                                <h3>Clinic Departments</h3>
                                                <ul>
                                                    <li>
                                                        @foreach ($departments as $department)
                                                            {{ $department->name }},
                                                        @endforeach
                                                    </li>
                                                </ul>
                                            </div>

                                            <div>
                                                <h3>Clinic Hours</h3>
                                                <ul>
                                                    <li>
                                                        <i class="fa-solid fa-check"></i>
                                                        {{ \Carbon\Carbon::parse($clinic->opening_time)->format('h:i A') ?? 'Not specified' }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($clinic->closing_time)->format('h:i A') ?? 'Not specified' }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="address-clinic">
                                            <h3>Clinic Location</h3>
                                            <address>
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $clinic->location ?? 'Not specified' }}
                                            </address>
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
