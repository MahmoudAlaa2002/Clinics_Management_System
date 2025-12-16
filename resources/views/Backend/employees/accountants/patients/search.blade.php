@if($patients->count() > 0)
    @foreach ($patients as $patient)
        <tr>
            <td>{{ $patients->firstItem() + $loop->index }}</td>
            <td>{{ $patient->user->name }}</td>
            <td>{{ $patient->user->email }}</td>
            <td>{{ $patient->user->phone }}</td>
            <td>{{ $patient->user->address }}</td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('accountant.profile_patient', ['id' => $patient->id]) }}" class="mr-1 btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Profile Patient">
                        <i class="fa fa-eye"></i>
                    </a>

                    <a href="{{ route('accountant.view_invoices_patients' , ['id' => $patient->id]) }}" class="mr-1 btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="View Invoices Patients">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px; margin-top:50px;">No patients available at the moment</strong>
        </td>
    </tr>
@endif

