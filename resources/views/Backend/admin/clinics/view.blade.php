@extends('Backend.master')

@section('title' , 'View Clinics')

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
        padding-top: 80px;
        padding-bottom: 30px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Clinics</h4>
            </div>
            <div class="text-right col-sm-8 col-9 m-b-20">
                <a href="{{ Route('add_clinic') }}" class="float-right btn btn-primary btn-rounded" style="font-weight: bold;">
                    <i class="fa fa-plus"></i> Add Clinic
                </a>
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
                    <option value="clinic">Clinic Name</option>
                    <option value="location">Location</option>
                    <option value="day">Working Day</option>
                    <option value="status">Status</option>
                  </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 text-center table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Clinic Name</th>
                        <th>Location</th>
                        <th>Clinic Email</th>
                        <th>Clinic Phone</th>
                        <th>Available Days</th>
                        <th>Available Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="clinics_table_body">
                    @if($clinics->count() > 0)
                        @foreach ($clinics as $clinic)
                            <tr>
                                <td>{{ $clinic->id }}</td>
                                <td>{{ $clinic->name }}</td>
                                <td>{{ $clinic->location }}</td>
                                <td>{{ $clinic->email }}</td>
                                <td>{{ $clinic->phone }}</td>
                                <td>{{ $clinic->working_days ? implode(' , ', json_decode($clinic->working_days)) : '-' }}</td>
                                <td>{{ $clinic->opening_time }} AM - {{ $clinic->closing_time }} PM</td>
                                <td>
                                    @if($clinic->status === 'active')
                                        <span class="status-badge" style="padding: 6px 24px; font-size: 18px; border-radius: 50px; background-color: #13ee29; color: white;">Active</span>
                                    @else
                                        <span class="status-badge" style="padding: 6px 20px; font-size: 18px; border-radius: 50px; background-color: #f90d25; color: white;">Inactive</span>
                                    @endif
                                </td>
                                <td class="action-btns">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('description_clinic', ['id' => $clinic->id]) }}" class="mr-1 btn btn-outline-success btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit_clinic', ['id' => $clinic->id]) }}" class="mr-1 btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-outline-danger btn-sm delete-clinic" data-id="{{ $clinic->id }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center">
                                <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                    No Clinics Available At The Moment
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div id="clinics-pagination" class="pagination-wrapper d-flex justify-content-center">
                {{ $clinics->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let lastKeyword = '';

    function fetchClinics(url = "{{ route('search_clinics') }}") {
        let keyword = $('#search_input').val().trim();
        let filter  = $('#search_filter').val();

        // إذا البحث فاضي وكان آخر مرة فاضي → لا تعمل شيء
        if (keyword === '' && lastKeyword === '') {
            return;
        }

        // إذا البحث فاضي وكان قبلها فيه كلمة → رجع الجدول الأساسي
        if (keyword === '' && lastKeyword !== '') {
            lastKeyword = '';
            window.location.href = "{{ route('view_clinics') }}";
            return;
        }

        lastKeyword = keyword;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { keyword: keyword, filter: filter },
            success: function (response) {
                $('#clinics_table_body').html(response.html);
                if (response.searching) {
                    if (response.count > 12) {
                        $('#clinics-pagination').html(response.pagination).show();
                    } else {
                        $('#clinics-pagination').empty().hide();
                    }
                } else {
                    $('#clinics-pagination').show();
                }
            },
            error: function () {
                console.error("Failed to fetch clinics.");
            }
        });
    }

    // البحث عند الكتابة
    $('#search_input').on('input', function () {
        fetchClinics();
    });

    // البحث عند تغيير الفلتر
    $('#search_filter').on('change', function () {
        fetchClinics();
    });

    // دعم الباجينيشن في البحث
    $(document).on('click', '#clinics-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') {
                fetchClinics(url);
            }
        }
    });

    // حذف العيادة
    $(document).on('click', '.delete-clinic', function () {
        let clinicId = $(this).data('id');
        let url = `/admin/delete/clinic/${clinicId}`;

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
                                title: 'Deleted!',
                                text: 'Clinic Has Been Deleted Successfully',
                                icon: 'success'
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    },
                });
            }
        });
    });
</script>
@endsection
