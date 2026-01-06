<div class="row">

    @foreach ($doctors as $doctor)
        <div class="col-lg-4 mb-4 col-md-6">
            <div class="card doctor-card h-100">

                <div class="cardHeader">
                    <img src="{{ asset($doctor->employee->user->image ?? 'assets/img/user.jpg') }}"
                        class="card-img-top" alt="{{ $doctor->employee->user->name }}">

                    <div>
                        <h5 class="card-title">
                            {{ $doctor->employee->user->name }}
                        </h5>
                        <em>
                            {{ $doctor->employee->department->name ?? 'General' }}
                        </em>
                        <div class="rating">
                            @php $rating = (int) ($doctor->rating ?? 0); @endphp

                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @else
                                    <i class="fa-regular fa-star text-muted"></i>
                                @endif
                            @endfor

                            <span class="rating-number">
                                {{ number_format($rating, 1) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="detailsDoctor">
                        {{-- <span>
                            <small>{{ $doctor->experience ?? 'N/A' }} years of experience</small>
                        </span> --}}
                        <span>
                            <small>{{ $doctor->speciality ?? 'General' }}</small>
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
        <div class="modal fade modal-doctor" id="detailDoctor{{ $doctor->id }}" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Doctor Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        {{-- Doctor Header --}}
                        <div class="doctor-info d-flex gap-3 align-items-center">

                            <img src="{{ asset($doctor->employee->user->image ?? 'assets/img/user.jpg') }}"
                                 style="width:120px; height:120px; object-fit:cover; border-radius:50%; border:3px solid #eaeaea;"
                                 alt="{{ $doctor->employee->user->name }}">

                            <div>
                                <h4>{{ $doctor->employee->user->name }}</h4>

                                <h6 class="text-muted">
                                    {{ $doctor->employee->department->name ?? 'General Department' }}
                                </h6>

                                <div class="rating mt-1">

                                    @php $rating = (int) ($doctor->rating ?? 0); @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @else
                                            <i class="fa-regular fa-star text-muted"></i>
                                        @endif
                                    @endfor

                                    <span class="rating-number ms-2">
                                        {{ number_format($rating, 1) }}
                                    </span>
                                </div>
                            </div>
                        </div>


                        {{-- About --}}
                        <div class="about-doctor mt-4">

                            <div class="row">

                                {{-- Right Column --}}
                                <div class="col-md-6">

                                    {{-- Speciality Card --}}
                                    <div class="p-3 border rounded shadow-sm mb-3">

                                        <h4>Speciality & Qualification</h4>

                                        <p class="mb-2">
                                            <strong>Speciality:</strong>
                                            {{ $doctor->speciality ?? 'Not specified' }}
                                            <br>

                                            <strong>Qualification:</strong>
                                            {{ $doctor->qualification ?? 'Not specified' }}
                                        </p>
                                    </div>

                                    {{-- Consultation Fee Card --}}
                                    <div class="p-3 border rounded shadow-sm">

                                        <h4>Consultation Fee</h4>

                                        <p class="fs-5 fw-bold text-success mb-0">
                                            ${{ number_format($doctor->consultation_fee, 2) }}
                                        </p>

                                    </div>

                                </div>

                                {{-- Left Column --}}
                                <div class="col-md-6">

                                    <div class="p-3 border rounded shadow-sm">

                                        <h4>Working Hours</h4>

                                        <p>
                                            {{ \Carbon\Carbon::parse($doctor->employee->work_start_time)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($doctor->employee->work_end_time)->format('h:i A') }}
                                        </p>

                                        @php
                                            $days = is_string($doctor->employee->working_days)
                                                ? json_decode($doctor->employee->working_days, true)
                                                : $doctor->employee->working_days;
                                        @endphp

                                        <h4>Working Days</h4>

                                        <ul class="mb-0">
                                            @foreach ($days ?? [] as $day)
                                                <li>{{ $day }}</li>
                                            @endforeach
                                        </ul>

                                    </div>

                                </div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary px-4">
                                    Book Appointment
                                </button>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    @endforeach
</div>
