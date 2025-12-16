@if($appointments->count() > 0)
    @foreach ($appointments as $appointment)
        <tr>
            <td>{{ $appointment->id }}</td>
            <td>{{ $appointment->patient->user->name }}</td>
            <td>{{ $appointment->doctor->employee->user->name }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
            <td>
                @if($appointment->status === 'Pending')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#ffc107; color:white;">
                        Pending
                    </span>
                @elseif($appointment->status === 'Accepted')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#189de4; color:white;">
                        Accepted
                    </span>
                @elseif($appointment->status === 'Rejected')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#f90d25; color:white;">
                        Rejected
                    </span>
                @elseif($appointment->status === 'Cancelled')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#6c757d; color:white;">
                        Cancelled
                    </span>
                @elseif($appointment->status === 'Completed')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#14ea6d; color:white;">
                        Completed
                    </span>
                @endif
            </td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    @if (!$appointment->vitalSigns)
                        <a href="{{ route('nurse.add_vital_signs' , ['appointment_id' => $appointment->id]) }}"
                        class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Add Vital Signs">
                            <i class="fas fa-heartbeat"></i>
                        </a>
                    @else
                        <a href="{{ route('nurse.view_vital_signs', ['appointment_id' => $appointment->id]) }}"
                        class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="View Vital Signs">
                            <i class="fas fa-heartbeat"></i>
                        </a>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px; margin-top:15px;">No Appointments Found</strong>
        </td>
    </tr>
@endif



