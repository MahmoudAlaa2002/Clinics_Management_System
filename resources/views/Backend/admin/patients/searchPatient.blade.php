@if($patients->count() > 0)
    @foreach ($patients as $patient)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $patient->user->name }}</td>
            <td>{{ $patient->user->email }}</td>
            <td>{{ $patient->user->phone }}</td>
            <td>{{ $patient->user->address }}</td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('profile_patient', ['id' => $patient->id]) }}" class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('edit_patient', ['id' => $patient->id]) }}" class="mr-1 btn btn-outline-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm delete-patient" data-id="{{ $patient->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px; margin-top:50px;">No Patients Available At The Moment</strong>
        </td>
    </tr>
@endif

