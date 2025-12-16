@if($medical_records->count() > 0)
    @foreach ($medical_records as $medical_record)
        <tr>
            <td>{{ $medical_records->firstItem() + $loop->index }}</td>
            <td>{{ $medical_record->appointment->id }}</td>
            <td>{{ $medical_record->patient->user->name }}</td>
            <td>{{ $medical_record->doctor->employee->user->name }}</td>
            <td>{{ $medical_record->record_date }}</td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('nurse.details_medical_record', ['id' => $medical_record->id]) }}" class="mr-1 btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Details Medical Record">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px; margin-top:50px;">No Medical Records Available At The Moment</strong>
        </td>
    </tr>
@endif

