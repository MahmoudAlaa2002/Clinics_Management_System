@if ($clinics_managers->count() > 0)
    @foreach ($clinics_managers as $clinics_manager)
        <div class="col-md-4 col-sm-4 col-lg-3">
            <div class="profile-widget">
                <div class="clinics-managers-img">
                    <a class="avatar" href="{{ Route('profile_clinics_managers' , ['id' => $clinics_manager->id]) }}">
                        <img src="{{ $clinics_manager->image ? asset($clinics_manager->image) : asset('default-avatar.png') }}">
                    </a>
                </div>

                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ Route('edit_clinics_managers' , ['id' => $clinics_manager->id]) }}">
                            <i class="fa fa-pencil m-r-5"></i> Edit
                        </a>
                        <a class="dropdown-item delete-clinics_managers"
                           data-id="{{ $clinics_manager->id }}"
                           href="{{ Route('delete_clinics_managers' , ['id' => $clinics_manager->id]) }}"
                           data-toggle="modal" data-target="#delete_clinics_managers">
                            <i class="fa fa-trash-o m-r-5"></i> Delete
                        </a>
                    </div>
                </div>

                <h4 class="clinics-managers-name text-ellipsis">
                    <a href="{{ Route('profile_clinics_managers' , ['id' => $clinics_manager->id]) }}">{{ $clinics_manager->name }}</a>
                </h4>
                <div class="doc-prof">{{ $clinics_manager->employee->clinic->name }}</div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center col-12">
        <div class="alert alert-info" style="font-weight: bold; font-size: 18px; margin-top:50px;">
            No Clinics Managers Available At The Moment
        </div>
    </div>
@endif
