@if ($departments_managers->count() > 0)
    @foreach ($departments_managers as $department_manager)
        <div class="col-md-4 col-sm-4 col-lg-3">
            <div class="profile-widget">
                <div class="clinics-managers-img">
                    <a class="avatar" href="{{ Route('profile_department_manager' , ['id' => $department_manager->id]) }}">
                        <img src="{{ $department_manager->image ? asset($department_manager->image) : asset('default-avatar.png') }}">
                    </a>
                </div>
                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ Route('edit_department_manager' , ['id' => $department_manager->id]) }}">
                            <i class="fa fa-pencil m-r-5"></i> Edit
                        </a>
                        <a class="dropdown-item delete-departments_managers" data-id="{{ $department_manager->id }}"
                           href="{{ Route('profile_department_manager' , ['id' => $department_manager->id]) }}"
                           data-toggle="modal" data-target="#delete_departments_managers">
                            <i class="fa fa-trash-o m-r-5"></i> Delete
                        </a>
                    </div>
                </div>
                <h4 class="clinics-managers-name text-ellipsis">
                    <a href="{{ Route('profile_department_manager' , ['id' => $department_manager->id]) }}">
                        {{ $department_manager->name }}
                    </a>
                </h4>
                <div class="doc-prof">{{ $department_manager->employee->clinic->name ?? 'N/A' }}</div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center col-12">
        <div class="alert alert-info" style="font-weight: bold; font-size: 18px; margin-top:50px;">
            No Departments Managers Found
        </div>
    </div>
@endif
