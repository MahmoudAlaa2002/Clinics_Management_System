@if($appointments->count() > 0)
    @foreach ($appointments as $appointment)
        <tr data-appointment="{{ $appointment->id }}">
            <td>{{ $appointment->id }}</td>
            <td>{{ $appointment->patient->user->name }}</td>
            <td>{{ $appointment->doctor->employee->user->name }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
            <td class="status-cell">
                @if($appointment->status === 'Pending')
                    <span class="status-badge"
                          style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px;
                                 font-size:18px; border-radius:50px; background-color:#ffc107; color:white;">
                        Pending
                    </span>
                @elseif($appointment->status === 'Accepted')
                    <span class="status-badge"
                          style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px;
                                 font-size:18px; border-radius:50px; background-color:#189de4; color:white;">
                        Accepted
                    </span>
                @elseif($appointment->status === 'Rejected')
                    <span class="status-badge"
                          style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px;
                                 font-size:18px; border-radius:50px; background-color:#f90d25; color:white;">
                        Rejected
                    </span>
                @elseif($appointment->status === 'Cancelled')
                    <span class="status-badge"
                          style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px;
                                 font-size:18px; border-radius:50px; background-color:#6c757d; color:white;">
                        Cancelled
                    </span>
                @elseif($appointment->status === 'Completed')
                    <span class="status-badge"
                          style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px;
                                 font-size:18px; border-radius:50px; background-color:#14ea6d; color:white;">
                        Completed
                    </span>
                @endif
            </td>

            <td class="action-btns">
                <div class="d-flex justify-content-center">

                    @if($appointment->status === 'Pending')

                        {{-- قبول --}}
                        <button class="btn btn-outline-success btn-sm complete-btn" style="margin-right: 3px;"
                                data-bs-toggle="tooltip" title="Accept Appointment"
                                data-id="{{ $appointment->id }}">
                                <i class="fas fa-check-circle"></i>
                        </button>

                        {{-- رفض --}}
                        <button class="btn btn-outline-danger btn-sm reject-btn"
                                data-bs-toggle="tooltip" title="Reject Appointment"
                                data-id="{{ $appointment->id }}">
                                <i class="fa fa-times"></i>
                        </button>


                    @elseif($appointment->status === 'Accepted')

                        {{-- تفاصيل --}}
                        <a href="{{ route('receptionist.details_appointment', ['id' => $appointment->id]) }}"
                            data-bs-toggle="tooltip" title="Details Appointment"
                            class="mr-1 btn btn-outline-success btn-sm">
                            <i class="fa fa-eye"></i>
                        </a>

                        {{-- تعديل --}}
                        <a href="{{ route('receptionist.edit_appointment', ['id' => $appointment->id]) }}"
                            data-bs-toggle="tooltip" title="Edit Appointment"
                            class="mr-1 btn btn-outline-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                    @elseif(in_array($appointment->status, ['Rejected', 'Cancelled', 'Completed']))

                        {{-- تفاصيل --}}
                        <a href="{{ route('receptionist.details_appointment', ['id' => $appointment->id]) }}"
                            data-bs-toggle="tooltip" title="Details Appointment"
                            class="mr-1 btn btn-outline-success btn-sm">
                            <i class="fa fa-eye"></i>
                        </a>

                    @endif

                </div>
            </td>

        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px;">
                No Appointments Found
            </strong>
        </td>
    </tr>
@endif



<div class="modal fade" id="rejectReasonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#007BFF; color:white;">
                <h5 class="modal-title">Reason for Rejection</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <textarea id="reject-reason" class="form-control" rows="4"
                          placeholder="Write the reason here..."></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn" id="confirm-reject-btn"
                        style="background-color:#007BFF; color:white;">
                    Confirm
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    .white-close {
        filter: invert(1);
    }
</style>


