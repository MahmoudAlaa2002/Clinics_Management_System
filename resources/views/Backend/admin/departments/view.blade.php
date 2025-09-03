@extends('Backend.master')

@section('title' , 'View Departments')

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
                <h4 class="page-title">View Departments</h4>
            </div>
            <div class="text-right col-sm-8 col-9 m-b-20">
                <a href="{{ Route('add_department') }}" class="float-right btn btn-primary btn-rounded" style="font-weight: bold;"><i class="fa fa-plus"></i> Add Department</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Department Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('description_department', ['id' => $department->id]) }}" class="mr-1 btn btn-outline-success btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('edit_department', ['id' => $department->id]) }}" class="mr-1 btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <button class="btn btn-outline-danger btn-sm delete-department" data-id="{{ $department->id }}"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper d-flex justify-content-center">
                        {{ $departments->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        $(document).on('click', '.delete-department', function () {
            let departmentId = $(this).data('id');
            let url = `/admin/delete/department/${departmentId}`;

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
                                    text: 'Department Has Been Deleted Successfully',
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
    </script>
@endsection
