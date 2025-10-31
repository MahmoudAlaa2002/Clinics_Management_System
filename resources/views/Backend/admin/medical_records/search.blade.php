@if($medical_records->count() > 0)
    @foreach ($medical_records as $medical_record)
        <tr>
            <td>{{ $medical_record->id }}</td>
            <td>{{ $medical_record->appointment_id }}</td>
            <td>{{ $medical_record->patient->user->name ?? 'Unknown' }}</td>
            <td>{{ $medical_record->doctor->employee->user->name ?? 'Unknown' }}</td>
            <td>{{ $medical_record->appointment->clinicDepartment->clinic->name }}</td>
            <td>{{ $medical_record->diagnosis }}</td>
            <td>{{ $medical_record->record_date }}</td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('details_medical_record', ['id' => $medical_record->id]) }}" class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('edit_medical_record', ['id' => $medical_record->id]) }}" class="mr-1 btn btn-outline-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm delete-medical-record" data-id="{{ $medical_record->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" class="text-center">
            <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                No Medical Records Found
            </div>
        </td>
    </tr>
@endif
