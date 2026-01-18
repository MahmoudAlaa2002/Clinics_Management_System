@extends('Backend.admin.master')

@section('title' , 'View Employees')

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

    .custom-table tbody tr {
        transition: filter 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-table tbody tr:hover {
        filter: brightness(90%);
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        cursor: pointer;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Employees</h4>
            </div>
            <div class="text-right col-sm-8 col-9 m-b-20">
                <a href="{{ Route('add_employee') }}" class="float-right btn btn-primary btn-rounded" style="font-weight: bold;">
                    <i class="fa fa-plus"></i> Add Employee
                </a>
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
                        <option value="name">Employee Name</option>
                        <option value="job">Job Title</option>
                        <option value="clinic">Clinic Name</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="employees_container">
            @include('Backend.admin.employees.search', ['employees' => $employees])
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    initTooltips();
    let lastEmployeeKeyword = '';

    function fetchEmployees(url = "{{ route('search_employees') }}") {
        let $searchInput = $('#search_input');
        let $filter      = $('#search_filter');
        let $container   = $('#employees_container');

        if ($searchInput.length === 0 || $container.length === 0) {
            return;
        }

        let keyword = $searchInput.val().trim();
        let filter  = $filter.length ? $filter.val() : '';

        // أول مرة فارغ -> لا تعمل بحث
        if (keyword === '' && lastEmployeeKeyword === '') return;

        // إذا رجع المستخدم ومسح النص -> ارجع للوضع العادي
        if (keyword === '' && lastEmployeeKeyword !== '') {
            lastEmployeeKeyword = '';
            window.location.href = "{{ route('view_employees') }}";
            return;
        }

        lastEmployeeKeyword = keyword;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { keyword: keyword, filter: filter },
            success: function (response) {
                $container.html(response.html);
                initTooltips();
            },
            error: function () {
                console.error("Failed to fetch employees.");
            }
        });
    }

    // البحث عند الكتابة
    $(document).on('input', '#search_input', function () {
        fetchEmployees();
    });

    // البحث عند تغيير الفلتر
    $(document).on('change', '#search_filter', function () {
        fetchEmployees();
    });

    // دعم الباجينيشن في حالة البحث
    $(document).on('click', '#employees-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') {
                fetchEmployees(url);
            }
        }
    });

    // حذف الموظف
    $(document).on('click', '.delete-employee', function () {
        let employeeId = $(this).data('id');
        let url = `/admin/delete/employee/${employeeId}`;

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
                                text: 'Employee has been deleted successfully',
                                icon: 'success',
                                confirmButtonColor: '#00A8FF',
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
</script>
@endsection
