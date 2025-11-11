@extends('Backend.admin.master')

@section('title' , 'View Departments Managers')

@section('content')

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .pagination-wrapper {
        margin-top: auto;
        padding-top: 80px; /* مسافة من الجدول */
        padding-bottom: 30px;
    }

</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Departments Managers</h4>
            </div>
        </div>
        <div class="mb-4 row">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input type="text" id="search_input" name="keyword" class="form-control" placeholder="Search...">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Search by:</span>
                    </div>
                    <select id="search_filter" name="filter" class="form-control">
                        <option value="name">Manager Name</option>
                        <option value="clinic">Clinic Name</option>
                    </select>
                </div>
            </div>
        </div>

        @if ($departments_managers->count() > 0)
            <div class="row clinics-managers-grid" id="departments_managers_container">
                @foreach ($departments_managers as $department_manager)
                    <div class="col-md-4 col-sm-4 col-lg-3">
                        <div class="profile-widget">
                            <div class="clinics-managers-img">
                                <a class="avatar" href="{{ Route('profile_department_manager' , ['id' => $department_manager->id]) }}"> <img src="{{ $department_manager->image ? asset($department_manager->image) : asset('assets/img/user.jpg') }}"></a>
                            </div>
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ Route('edit_department_manager' , ['id' => $department_manager->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item delete-departments_managers" data-id="{{ $department_manager->id }}" href="{{ Route('profile_department_manager' , ['id' => $department_manager->id]) }}" data-toggle="modal" data-target="#delete_departments_managers"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                            <h4 class="clinics-managers-name text-ellipsis" style="margin-bottom: 7px;"><a href="{{ Route('profile_department_manager' , ['id' => $department_manager->id]) }}">{{ $department_manager->name }}</a></h4>
                            <div class="doc-prof">{{ $department_manager->employee->department->name }}</div>
                            <div class="user-country">
                                <i class="fa fa-map-marker"></i> {{ $department_manager->employee->user->address }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrapper d-flex justify-content-center" id="clinics-managers-pagination">
                {{ $departments_managers->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="text-center col-12">
                <div class="alert alert-info" style="font-weight: bold; font-size: 18px; margin-top:50px;">
                    No Departments Managers Available At The Moment
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


@section('js')
<script>
    $(document).on('click', '.delete-departments_managers', function () {
        let departmentsManagerId = $(this).data('id');
        let url = `/admin/delete/department-manager/${departmentsManagerId}`;

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            imageUrl: 'https://img.icons8.com/ios-filled/50/fa314a/delete-trash.png',
            imageWidth: 60,
            imageHeight: 60,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted',
                                text: 'Department Manager Has Been Deleted Successfully',
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    },
                });
            }
        });
    });

    let lastManagerKeyword = '';


    function fetchClinicsManagers(url = "{{ url('admin/search/departments-managers') }}") {
        let $searchInput = $('#search_input');
        let $filter      = $('#search_filter');
        let $container   = $('#departments_managers_container');
        let $pagination  = $('#departments_managers-pagination');


        if ($searchInput.length === 0 || $container.length === 0) {
            return;
        }

        let keyword = $searchInput.val().trim();
        let filter  = $filter.length ? $filter.val() : '';

        if (keyword === '' && lastManagerKeyword === '') {
            return;
        }

        if (keyword === '' && lastManagerKeyword !== '') {
            lastManagerKeyword = '';
            window.location.href = "{{ route('view_departments_managers') }}";
            return;
        }

        lastManagerKeyword = keyword;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { keyword: keyword, filter: filter },
            success: function (response) {
                $container.html(response.html);

                if (response.searching) {
                    if (response.count > 12) {
                        $pagination.html(response.pagination).show();
                    } else {
                        $pagination.empty().hide();
                    }
                } else {
                    $pagination.show();
                }
            },
            error: function () {
                console.error("Failed to fetch departments managers.");
            }
        });
    }

    // البحث عند الكتابة
    $(document).on('input', '#search_input', function () {
        fetchClinicsManagers();
    });

    // البحث عند تغيير الفلتر
    $(document).on('change', '#search_filter', function () {
        fetchClinicsManagers();
    });

    // دعم الباجينيشن في حالة البحث
    $(document).on('click', '#departments_managers-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') {
                fetchClinicsManagers(url);
            }
        }
    });
</script>
@endsection
