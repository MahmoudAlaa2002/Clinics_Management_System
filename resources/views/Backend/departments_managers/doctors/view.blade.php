@extends('Backend.departments_managers.master')

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

    .doctor-qualification {
        margin: 8px 0;
        font-size: 14px;
        color: #555;
    }

    .doctor-rating {
        margin: 10px 0;
    }

    .doctor-rating i {
        font-size: 15px;
        margin: 0 1px;
    }

    .star-filled {
        color: #fbc02d; /* ذهبي */
    }

    .star-empty {
        color: #ddd;
    }

</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Doctors</h4>
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
                    <option value="name">Doctor Name</option>
                    <option value="rating">Rating</option>
                    <option value="status">Status</option>
                  </select>
                </div>
            </div>
        </div>
        @if ($doctors->count() > 0)
            <div class="row doctor-grid" id="doctors_container">
                @foreach ($doctors as $doctor)
                    <div class="col-md-4 col-sm-4 col-lg-3">
                        <div class="profile-widget text-center">

                            <div class="doctor-img">
                                <a class="avatar" href="{{ route('department.profile_doctor', $doctor->id) }}">
                                    <img src="{{ optional(optional($doctor->employee)->user)->image
                                        ? asset('storage/'.$doctor->employee->user->image)
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
            </div>

            <div class="pagination-wrapper d-flex justify-content-center" id="doctors-pagination">
                {{ $doctors->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="text-center col-12">
                <div class="alert alert-info" style="font-weight: bold; font-size: 18px; margin-top:50px;">
                    There Are No Doctors Listed Yet
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


@section('js')
<script>

    let lastDoctorKeyword = '';

    function fetchDoctors(url = "{{ route('department.search_doctors') }}") {
        let $searchInput = $('#search_input');
        let $filter       = $('#search_filter');
        let $container    = $('#doctors_container');
        let $pagination   = $('#doctors-pagination');

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
            window.location.href = "{{ route('department.view_doctors') }}";
            return;
        }

        lastDoctorKeyword = keyword;

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



