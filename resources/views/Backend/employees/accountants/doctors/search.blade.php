@if ($doctors->count() > 0)
    @foreach ($doctors as $doctor)
        <div class="col-md-4 col-sm-4 col-lg-3">
            <div class="profile-widget">
                <!-- Doctor Image -->
                <div class="doctor-img">
                    <a class="avatar" href="{{ route('nurse.profile_doctor', ['id' => $doctor->id]) }}">
                        <img src="{{ $doctor->employee->user->image
                            ? asset($doctor->employee->user->image)
                            : asset('assets/img/user.jpg') }}"
                             alt="">
                    </a>
                </div>


                <!-- Doctor Info -->
                <h4 class="doctor-name text-ellipsis" style="margin-bottom: 7px;">
                    <a href="{{ route('nurse.profile_doctor', ['id' => $doctor->id]) }}">
                        {{ $doctor->employee->user->name }}
                    </a>
                </h4>
                <div class="doc-prof">
                    {{ optional($doctor->employee->department)->name }}
                </div>
                <div class="user-country">
                    <i class="fa fa-map-marker"></i>
                    {{ $doctor->employee->user->address ?? 'No Address Available' }}
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
