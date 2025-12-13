@if ($doctors->count() > 0)
    @foreach ($doctors as $doctor)
        <div class="col-md-4 col-sm-4 col-lg-3">
            <div class="profile-widget text-center">

                <div class="doctor-img">
                    <a class="avatar" href="{{ route('department.profile_doctor', $doctor->id) }}">
                        <img src="{{ optional(optional($doctor->employee)->user)->image
                            ? asset($doctor->employee->user->image)
                            : asset('assets/img/user.jpg') }}">
                    </a>
                </div>

                <h4 class="doctor-name text-ellipsis mb-2">
                    <a href="{{ route('department.profile_doctor', $doctor->id) }}">
                        {{ $doctor->employee->user->name }}
                    </a>
                </h4>

                {{-- Qualification --}}
                @if($doctor->qualification)
                    <div class="doctor-qualification">
                        <i class="fa fa-graduation-cap text-primary me-1"></i>
                        {{ $doctor->qualification }}
                    </div>
                @endif

                {{-- Rating Stars --}}
                <div class="doctor-rating">
                    @php
                        $rating = floor($doctor->rating); // عدد النجوم المضيئة
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= $rating ? 'star-filled' : 'star-empty' }}"></i>
                    @endfor
                </div>

            </div>
        </div>
    @endforeach
@else
    <div class="text-center col-12">
        <div class="alert alert-info" style="font-weight: bold; font-size: 18px; margin-top:50px;">
            No Doctors Available At The Moment
        </div>
    </div>
@endif
