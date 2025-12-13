@if($medical_records->count() > 0)
    @foreach ($medical_records as $medical_record)
        <tr>
            <td>{{ $loop->iteration }}</td>
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
