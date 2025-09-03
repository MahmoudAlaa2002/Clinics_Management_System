@if($clinics->count() > 0)
    @foreach ($clinics as $clinic)
        @php
            // لو عندك working_days على مستوى الأطباء
            $doctors = ($clinic->clinicDepartments ?? collect())
                ->flatMap(fn($cd) => $cd->doctors ?? collect());

            $workingDays = $doctors->flatMap(function ($d) {
                $raw = $d->working_days;
                if (is_string($raw)) {
                    $arr = json_decode($raw, true);
                } elseif (is_array($raw)) {
                    $arr = $raw;
                } else {
                    $arr = [];
                }
                return is_array($arr) ? $arr : [];
            })->filter()->unique()->values();
        @endphp

        <tr style="vertical-align: middle;">
            {{-- ID --}}
            <td style="font-weight: bold;">{{ $clinic->id }}</td>

            {{-- Clinic Name --}}
            <td>{{ $clinic->name ?? '—' }}</td>

            {{-- Location --}}
            <td>{{ $clinic->location ?? $clinic->address ?? '—' }}</td>

            {{-- Clinic Email --}}
            <td>{{ $clinic->email ?? '—' }}</td>

            {{-- Clinic Phone --}}
            <td>{{ $clinic->phone ?? '—' }}</td>

            {{-- Available Days --}}
            <td>
                @php
                    $days = json_decode($clinic->working_days, true) ?? [];
                @endphp

                @if(!empty($days))
                    {{ implode(' , ', $days) }}
                @else
                    <span class="text-muted">—</span>
                @endif
            </td>

            {{-- Available Time --}}
            <td>
                {{ $clinic->opening_time ? $clinic->opening_time . ' AM' : '—' }}
                -
                {{ $clinic->closing_time ? $clinic->closing_time . ' PM' : '—' }}
            </td>

            {{-- Status --}}
            <td>
                @if($clinic->status === 'active')
                    <span class="status-badge" style="padding: 6px 24px; font-size: 18px; border-radius: 50px; background-color: #15ef70; color: white;">
                        Active
                    </span>
                @else
                    <span class="status-badge" style="padding: 6px 20px; font-size: 18px; border-radius: 50px; background-color: #f90d25; color: white;">
                        Inactive
                    </span>
                @endif
            </td>

            {{-- Actions --}}
            <td class="action-btns">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('description_clinic', ['id' => $clinic->id]) }}" class="mr-1 btn btn-outline-success btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('edit_clinic', ['id' => $clinic->id]) }}" class="mr-1 btn btn-outline-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm delete-clinic" data-id="{{ $clinic->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="p-4 text-center">
            <strong style="font-size: 18px; color: gray;">No Clinics Found</strong>
        </td>
    </tr>
@endif
