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
        padding-top: 80px; /* مسافة من الجدول */
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
                <a href="{{ Route('add_clinic') }}" class="float-right btn btn-primary btn-rounded" style="font-weight: bold;"><i class="fa fa-plus"></i> Add Clinic</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Clinic Name</th>
                                <th>Location</th>
                                <th>Clinic Phone</th>
                                <th>Doctor In Charge</th>
                                <th>Available Days</th>
                                <th>Available Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($clinics->count() > 0)
                                @foreach ($clinics as $clinic)
                                    <tr>
                                        <td>{{ $clinic->id }}</td>
                                        <td>{{ $clinic->name }}</td>
                                        <td>{{ $clinic->location }}</td>
                                        <td>{{ $clinic->clinic_phone }}</td>
                                        <td>{{ $clinic->doctor ? $clinic->doctor->name : '-' }}</td>
                                        <td>{{ $clinic->working_days ? implode(' , ', json_decode($clinic->working_days)) : '-' }}</td>
                                        <td>{{ $clinic->opening_time }} AM - {{ $clinic->closing_time }} PM</td>
                                        <td>
                                            @if($clinic->status === 'active')
                                                <span class="status-badge" style="padding: 6px 24px; font-size: 18px; border-radius: 50px; background-color: #15ef70; color: white;">
                                                    Active
                                                </span>
                                            @else
                                                <span class="status-badge" style="padding: 6px 20px; font-size: 18px; border-radius: 50px; background-color: #f90d25; color: white;">
                                                    Inactive
                                                </span>
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
                                        <div  style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            No clinics available at the moment
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination-wrapper d-flex justify-content-center">
                        {{ $clinics->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    $(document).on('click', '.delete-clinic', function () {
        let clinicId = $(this).data('id');
        let url = `/delete/clinic/${clinicId}`;

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
                                text: 'Clinic Has Been Deleted Successfully',
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
