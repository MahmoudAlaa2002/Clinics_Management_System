@if($appointments->count() > 0)
    @foreach ($appointments as $appointment)
        <tr style="vertical-align: middle;">
            <td style="font-weight: bold;">{{ $appointment->id }}</td>
            <td>{{ $appointment->patient->name }}</td>
            <td>{{ $appointment->clinic->name }}</td>
            <td>{{ $appointment->specialty->name }}</td>
            <td>{{ $appointment->doctor->name }}</td>
            <td>
                <span class="badge badge-light" style="font-size: 14px;">
                    {{ $appointment->appointment_date }}
                </span>
            </td>
            <td>
                <span class="badge badge-light" style="font-size: 14px;">
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                </span>
            </td>
            <td>
                @php
                    $color = match($appointment->status) {
                        'Scheduled' => '#189de4',
                        'Completed' => '#15ef70',
                        default => '#f90d25'
                    };
                @endphp
                <span class="badge" style="background-color: {{ $color }}; color: white; font-size: 14px; border-radius: 20px; padding: 6px 14px;">
                    {{ $appointment->status }}
                </span>
            </td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('description_appointment', ['id' => $appointment->id]) }}" class="mr-1 btn btn-outline-success btn-sm"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('edit_appointment', ['id' => $appointment->id]) }}" class="mr-1 btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                    <button class="btn btn-outline-danger btn-sm delete-appointment" data-id="{{ $appointment->id }}"><i class="fa fa-trash"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="p-4 text-center">
            <strong style="font-size: 18px; color: gray;">No appointments found</strong>
        </td>
    </tr>
@endif



