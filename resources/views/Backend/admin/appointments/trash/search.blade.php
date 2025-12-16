@if($appointments->count() > 0)
    @foreach ($appointments as $appointment)
        <tr>
            <td>{{ $appointment->id }}</td>
            <td>{{ optional(optional($appointment->patient)->user)->name ?? '-' }}</td>
            <td>{{ $appointment->clinicDepartment->clinic->name }}</td>
            <td>{{ $appointment->clinicDepartment->department->name }}</td>
            <td>{{ optional(optional(optional($appointment->doctor)->employee)->user)->name ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->admin_deleted_at)->format('Y-m-d') }}</td>
            <td class="action-btns">
                <div class="d-flex justify-content-center gap-1">

                    {{-- استرجاع --}}
                    <button class="btn btn-outline-success btn-sm restore-appointment"
                            data-bs-toggle="tooltip" title="Restore Appointment"
                            data-id="{{ $appointment->id }}"
                            style="margin-right: 4px;">
                        <i class="fa fa-undo"></i>
                    </button>

                    {{-- حذف نهائي --}}
                    <button class="btn btn-outline-danger btn-sm force-delete-appointment"
                            data-bs-toggle="tooltip" title="Delete Appointment"
                            data-id="{{ $appointment->id }}">
                        <i class="fa fa-times"></i>
                    </button>

                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="10" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px;">
                Trash Is Empty
            </strong>
        </td>
    </tr>
@endif
