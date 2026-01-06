@if($clinics->count() > 0)

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
                            @php $rating = (int) ($clinic->rating ?? 0); @endphp

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

        <div class="modal fade" id="detailsClinic{{ $clinic->id }}" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Clinic Details</h1>
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

                                    @php
                                        $rating = (int) ($clinic->rating ?? 0);
                                    @endphp

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

                                <button>Book Appointment</button>
                            </div>
                        </div>

                        @php
                            $departments = $clinic->departments;
                        @endphp
                        <div class="about-clinic">
                            <div>
                                <h3>Clinic Departments</h3>
                                <ul class="dept-list">
                                    @foreach ($departments as $department)
                                        <li>{{ $department->name }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            @php
                                $days = is_string($clinic->working_days)
                                    ? json_decode($clinic->working_days, true)
                                    : $clinic->working_days;
                            @endphp
                            <div>
                                <h3>Clinic Hours</h3>
                                <ul>
                                    <li>
                                        {{ \Carbon\Carbon::parse($clinic->opening_time)->format('h:i A') ?? 'Not specified' }}
                                        -
                                        {{ \Carbon\Carbon::parse($clinic->closing_time)->format('h:i A') ?? 'Not specified' }}
                                    </li>
                                </ul>

                                <h3>Working Days</h3>
                                <ul class="mb-0">
                                    @foreach ($days as $day)
                                    <li>- {{ $day }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="address-clinic">
                            <h3>Contact Information</h3>
                            <address>
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $clinic->location ?? 'Not specified' }}
                            </address>

                            <address>
                                <i class="fa-solid fa-envelope"></i>
                                {{ $clinic->email ?? 'Not specified' }}
                            </address>

                            <address>
                                <i class="fa-solid fa-phone"></i>
                                {{ $clinic->phone ?? 'Not specified' }}
                            </address>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

@else

    <div class="col-12 text-center p-4">
        <strong>No clinics found</strong>
    </div>

@endif
