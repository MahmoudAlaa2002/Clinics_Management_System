@extends('Backend.employees.nurses.master')

@section('title' , 'View Nurse Tasks')

@section('content')
    <style>
        html, body { height: 100%; margin: 0; }
        .page-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
        .content { flex: 1; display: flex; flex-direction: column; }
        .pagination-wrapper { margin-top: auto; padding-top: 80px; padding-bottom: 30px; }
    </style>

    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">View Nurse Tasks</h4>
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
                            <option value="patient_name">Patient Name</option>
                            <option value="doctor_name">Doctor Name</option>
                            <option value="performed_at">Performed At</option>
                            <option value="status">Status</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 text-center table-bordered table-striped custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Task</th>
                            <th>Performed At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="nurse_tasks_table_body">
                        @include('Backend.employees.nurses.nurse_tasks.search', ['nurse_tasks' => $nurse_tasks])
                    </tbody>
                </table>
                <div id="nurse-tasks-pagination" class="pagination-wrapper d-flex justify-content-center">
                    {{ $nurse_tasks->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script>
    initTooltips();

    let lastKeyword = '';

    function fetchNurseTasks(url = "{{ route('nurse.search_nurse_tasks') }}") {
        let keyword = $('#search_input').val().trim();
        let filter  = $('#search_filter').val();

        if (keyword === '' && lastKeyword === '') return;

        if (keyword === '' && lastKeyword !== '') {
            lastKeyword = '';
            window.location.href = "{{ route('nurse.view_nurse_tasks') }}";
            return;
        }

        lastKeyword = keyword;

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { keyword: keyword, filter: filter },
            success: function (response) {

                $('#nurse_tasks_table_body').html(response.html);
                initTooltips();

                if (response.searching) {
                    if (response.count > 12) {
                        $('#nurse-tasks-pagination').html(response.pagination).show();
                    } else {
                        $('#nurse-tasks-pagination').empty().hide();
                    }
                } else {
                    $('#nurse-tasks-pagination').show();
                }
            },
            error: function () {
                console.error("Failed to fetch nurse tasks.");
            }
        });
    }

    // البحث عند الكتابة
    $(document).on('input', '#search_input', function () {
        fetchNurseTasks();
    });

    // تغيير الفلتر
    $(document).on('change', '#search_filter', function () {
        fetchNurseTasks();
    });

    // باجينيشن مع AJAX
    $(document).on('click', '#nurse-tasks-pagination .page-link', function (e) {
        let keyword = $('#search_input').val().trim();
        if (keyword !== '') {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') fetchNurseTasks(url);
        }
    });



    // ================================
    // قبول الموعد — مع تأكيد
    // ================================
    $(document).on('click', '.complete-btn', function (e) {
        e.preventDefault();

        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to complete this task?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00A8FF',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Accept',
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "/employee/nurse/completed/nurse-task/" + id,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: 'Completed'
                    },

                    success: function () {

                        Swal.fire({
                            icon: 'success',
                            title: 'Task Completed',
                            text: 'The task status has been updated',
                            confirmButtonColor: '#00A8FF',
                        }).then(() => window.location.reload());
                    }
                });
            }
        });
    });
</script>

@endsection
