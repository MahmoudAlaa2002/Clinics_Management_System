@extends('Backend.clinics_managers.master')

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

        <!-- Search -->
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
                    </select>
                </div>
            </div>
        </div>

        <!-- النتائج -->
        <div class="row clinics-managers-grid" id="departments_managers_container">
            @if ($departments_managers->count() > 0)
                @foreach ($departments_managers as $department_manager)
                    <div class="col-md-4 col-sm-4 col-lg-3">
                        <div class="profile-widget">
                            <div class="doctor-img">
                                <a class="avatar"
                                   href="{{ route('clinic.profile_department_manager', ['id' => $department_manager->id]) }}">
                                    <img src="{{ $department_manager->user->image ? asset($department_manager->user->image) : asset('assets/img/user.jpg') }}">
                                </a>
                            </div>

                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item"
                                       href="{{ route('clinic.edit_department_manager', ['id' => $department_manager->id]) }}">
                                        <i class="fa fa-pencil m-r-5"></i> Edit
                                    </a>
                                    <a class="dropdown-item delete-department-manager"
                                        data-id="{{ $department_manager->id }}"
                                        href="javascript:void(0)">
                                            <i class="fa fa-trash-o m-r-5"></i> Delete
                                        </a>
                                </div>
                            </div>

                            <h4 class="doctor-name text-ellipsis" style="margin-bottom: 7px;">
                                <a href="{{ route('clinic.profile_department_manager', ['id' => $department_manager->id]) }}">
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
                <div class="text-center col-12">
                    <div class="alert alert-info"
                         style="font-weight: bold; font-size: 18px; margin-top:50px;">
                        No Departments Managers Available At The Moment
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper d-flex justify-content-center" id="departments_managers-pagination">
            {{ $departments_managers->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>

@endsection


@section('js')
<script>
    // DELETE
    $(document).on('click', '.delete-department-manager', function () {
        let id = $(this).data('id');
        let url = `/clinic-manager/delete/department-manager/${id}`;

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
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted',
                                text: 'Department manager has been deleted successfully',
                                icon: 'success',
                                confirmButtonColor: '#007BFF',
                            }).then(() => { location.reload(); });
                        } else {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    },
                });
            }
        });
    });

    let lastManagerKeyword = '';

    function fetchClinicsManagers(url = "{{ url('clinic-manager/search/departments-managers') }}") {
        let keyword     = $('#search_input').val().trim();
        let filter      = $('#search_filter').val();
        let $container  = $('#departments_managers_container');
        let $pagination = $('#departments_managers-pagination');

        // حالة إلغاء البحث
        if (keyword === '' && lastManagerKeyword !== '') {
            lastManagerKeyword = '';
            window.location.href = "{{ route('clinic.view_departments_managers') }}";
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

    $(document).on('input', '#search_input', function () {
        fetchClinicsManagers();
    });

    $(document).on('change', '#search_filter', function () {
        fetchClinicsManagers();
    });

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
