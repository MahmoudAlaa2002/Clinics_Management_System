@if ($departments_managers->count() > 0)
    @foreach ($departments_managers as $department_manager)
        <div class="col-md-4 col-sm-4 col-lg-3">
            <div class="profile-widget">
                <div class="doctor-img">
                    <a class="avatar" href="{{ Route('clinic.profile_department_manager' , ['id' => $department_manager->id]) }}">
                        <img src="{{ asset($department_manager->user->image ?? 'assets/img/user.jpg') }}">
                    </a>
                </div>
                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ Route('clinic.edit_department_manager' , ['id' => $department_manager->id]) }}">
                            <i class="fa fa-pencil m-r-5"></i> Edit
                        </a>
                        <a class="dropdown-item delete-department-manager"
                           data-id="{{ $department_manager->id }}"
                           href="{{ Route('clinic.delete_department_manager' , ['id' => $department_manager->id]) }}"
                           data-toggle="modal" data-target="#delete_doctor">
                            <i class="fa fa-trash-o m-r-5"></i> Delete
                        </a>
                    </div>
                </div>
                <h4 class="doctor-name text-ellipsis" style="margin-bottom: 7px;">
                    <a href="{{ Route('clinic.profile_department_manager' , ['id' => $department_manager->id]) }}">
                        {{ $department_manager->user->name }}
                    </a>
                </h4>
                <div class="doc-prof">{{ $department_manager->department->name }}</div>
                <div class="user-country">
                    <i class="fa fa-map-marker"></i> {{ $department_manager->user->address }}
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-12 text-center">
        <div class="alert alert-info" style="font-weight: bold; font-size: 18px; margin-top:50px;">
            No Departments Managers Found
        </div>
    </div>
@endif
