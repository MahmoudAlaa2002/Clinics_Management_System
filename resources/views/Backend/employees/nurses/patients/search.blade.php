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
                    <a href="{{ route('nurse.profile_patient', ['id' => $patient->id]) }}" class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
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

