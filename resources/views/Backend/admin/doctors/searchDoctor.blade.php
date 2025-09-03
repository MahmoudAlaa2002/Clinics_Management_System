@if ($doctors->count() > 0)
    @foreach ($doctors as $doctor)
        <div class="col-md-4 col-sm-4 col-lg-3">
            <div class="profile-widget">
                <div class="doctor-img">
                    <a class="avatar" href="{{ Route('profile_doctor' , ['id' => $doctor->id]) }}">
                        <img src="{{ optional(optional($doctor->employee)->user)->image
                            ? asset(optional($doctor->employee->user)->image)
                            : asset('default-avatar.png') }}" alt="">
                    </a>
                </div>

                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ Route('edit_doctor' , ['id' => $doctor->id]) }}">
                            <i class="fa fa-pencil m-r-5"></i> Edit
                        </a>
                        <a class="dropdown-item delete-doctor"
                           data-id="{{ $doctor->id }}"
                           href="{{ Route('delete_doctor' , ['id' => $doctor->id]) }}"
                           data-toggle="modal" data-target="#delete_doctor">
                            <i class="fa fa-trash-o m-r-5"></i> Delete
                        </a>
                    </div>
                </div>

                <h4 class="doctor-name text-ellipsis">
                    <a href="{{ Route('profile_doctor' , ['id' => $doctor->id]) }}">{{ $doctor->employee->user->name }}</a>
                </h4>
                <div class="doc-prof">{{ optional($doctor->department)->name }}</div>
                <div class="user-country">
                    <i class="fa fa-map-marker"></i> {{ $doctor->employee->user->address }}
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
