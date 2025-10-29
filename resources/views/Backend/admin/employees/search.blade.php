<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table mb-0 text-center table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Employee Name</th>
                        <th>Job Title</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($employees->count() > 0)
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->user->name ?? '-' }}</td>
                                <td>{{ $employee->job_title }}</td>
                                <td>{{ $employee->user->email ?? '-' }}</td>
                                <td>{{ $employee->user->phone ?? '-' }}</td>
                                <td class="action-btns">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('profile_employee', ['id' => $employee->id]) }}" class="mr-1 btn btn-outline-success btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit_employee', ['id' => $employee->id]) }}" class="mr-1 btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-outline-danger btn-sm delete-employee" data-id="{{ $employee->id }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">
                                <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                    No Employees Available At The Moment
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="pagination-wrapper d-flex justify-content-center" id="employees-pagination">
                {{ $employees->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
