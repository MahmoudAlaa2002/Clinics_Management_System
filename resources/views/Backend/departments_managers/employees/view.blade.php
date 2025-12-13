@extends('Backend.departments_managers.master')

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
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Employees</h4>
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
                    </select>
                </div>
            </div>
        </div>


        <div id="employees_container">
            @include('Backend.departments_managers.employees.search', ['employees' => $employees])
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let lastEmployeeKeyword = '';

    function fetchEmployees(url = "{{ route('department.search_employees') }}") {
        let $searchInput = $('#search_input');
        let $filter      = $('#search_filter');
        let $container   = $('#employees_container');

        if ($searchInput.length === 0 || $container.length === 0) {
            return;
        }

        let keyword = $searchInput.val().trim();
        let filter  = $filter.length ? $filter.val() : '';

        if (keyword === '' && lastEmployeeKeyword === '') return;

        if (keyword === '' && lastEmployeeKeyword !== '') {
            lastEmployeeKeyword = '';
            window.location.href = "{{ route('department.view_employees') }}";
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

</script>
@endsection
