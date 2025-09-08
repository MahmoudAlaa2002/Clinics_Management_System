@extends('Backend.admin.master')

@section('title' , 'View Doctors')

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
                <h4 class="page-title">View Doctors</h4>
            </div>
            <div class="text-right col-sm-8 col-9 m-b-20">
                <a href="{{ Route('add_doctor') }}" class="float-right btn btn-primary btn-rounded" style="font-weight: bold;"><i class="fa fa-plus"></i> Add Doctor</a>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <input type="text" id="search_input" name="keyword" class="form-control" placeholder="Search...">
            </div>
            <div class="col-md-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Search by:</span>
                  </div>
                  <select id="search_filter" name="filter" class="form-control">
                    <option value="name">Doctor Name</option>
                    <option value="clinic">Clinic Name</option>
                    <option value="department">Department</option>
                    <option value="status">Status</option>
                  </select>
                </div>
            </div>
        </div>
        @if ($doctors->count() > 0)
            <div class="row doctor-grid" id="doctors_container">
                @foreach ($doctors as $doctor)
                    <div class="col-md-4 col-sm-4 col-lg-3">
                        <div class="profile-widget">
                            <div class="doctor-img">
                                <a class="avatar" href="{{ Route('profile_doctor' , ['id' => $doctor->id]) }}"> <img src="{{ optional(optional($doctor->employee)->user)->image
                                    ? asset(optional($doctor->employee->user)->image)
                                    : asset('default-avatar.png') }}"></a>
                            </div>
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ Route('edit_doctor' , ['id' => $doctor->id]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item delete-doctor" data-id="{{ $doctor->id }}" href="{{ Route('delete_doctor' , ['id' => $doctor->id]) }}" data-toggle="modal" data-target="#delete_doctor"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                            <h4 class="doctor-name text-ellipsis"><a href="{{ Route('profile_doctor' , ['id' => $doctor->id]) }}">{{ $doctor->employee->user->name }}</a></h4>
                            <div class="doc-prof">{{ optional($doctor->department)->name }}</div>
                            <div class="user-country">
                                <i class="fa fa-map-marker"></i> {{ $doctor->employee->user->address }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrapper d-flex justify-content-center" id="doctors-pagination">
                {{ $doctors->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="col-12 text-center">
                <div class="alert alert-info" style="font-weight: bold; font-size: 18px; margin-top:50px;">
                    No Doctors Available At The Moment
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


@section('js')
<script>
    $(document).on('click', '.delete-doctor', function () {
        let doctorId = $(this).data('id');
        let url = `/admin/delete/doctor/${doctorId}`;

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
                                title: 'Deleted!',
                                text: 'Doctor Has Been Deleted Successfully',
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


    let lastDoctorKeyword = '';

    function fetchDoctors(url = "{{ route('search_doctors') }}") {
        let $searchInput = $('#search_input');
        let $filter       = $('#search_filter');
        let $container    = $('#doctors_container');     // ✅ بدّلنا الهدف لكونتينر الكروت
        let $pagination   = $('#doctors-pagination');    // ✅ بدّلنا هدف الباجينيشن

        // تأكد من وجود العناصر قبل أي شيء
        if ($searchInput.length === 0 || $container.length === 0) {
            return;
        }

        let keyword = $searchInput.val().trim();
        let filter  = $filter.length ? $filter.val() : '';

        // إذا البحث فاضي وكان آخر مرة فاضي → لا تعمل شيء
        if (keyword === '' && lastDoctorKeyword === '') {
            return;
        }

        // إذا البحث فاضي وكان قبلها فيه كلمة → رجّع الواجهة الأصلية
        if (keyword === '' && lastDoctorKeyword !== '') {
            lastDoctorKeyword = '';
            window.location.href = "{{ route('view_doctors') }}";
            return;
        }

        lastDoctorKeyword = keyword;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { keyword: keyword, filter: filter },
            success: function (response) {
                // response.html = أعمدة الكروت فقط (بدون row)
                $container.html(response.html);      // ✅ استبدال الأعمدة داخل نفس الـ row.doctor-grid

                if (response.searching) {
                    if (response.count > 12) {
                        $pagination.html(response.pagination).show();  // ✅ استبدال الباجينيشن فقط
                    } else {
                        $pagination.empty().hide();
                    }
                } else {
                    $pagination.show();
                }
            },
            error: function () {
                console.error("Failed to fetch doctors.");
            }
        });
    }

    // البحث عند الكتابة
    $(document).on('input', '#search_input', function () {
        fetchDoctors();
    });

    // البحث عند تغيير الفلتر
    $(document).on('change', '#search_filter', function () {
        fetchDoctors();
    });

    // دعم الباجينيشن في حالة البحث
    $(document).on('click', '#doctors-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') {
                fetchDoctors(url);
            }
        }
    });
</script>
@endsection



