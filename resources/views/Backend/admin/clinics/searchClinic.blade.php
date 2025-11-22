@if($clinics->count() > 0)
    @if(isset($searching) && $searching)
        @foreach ($clinics as $clinic)
            <tr style="vertical-align: middle;">
                <td style="font-weight: bold;">{{ $loop->iteration }}</td>
                <td>{{ $clinic->name ?? '—' }}</td>
                <td>{{ $clinic->location ?? $clinic->address ?? '—' }}</td>
                <td>{{ $clinic->email ?? '—' }}</td>
                <td>{{ $clinic->phone ?? '—' }}</td>
                <td>
                    @if($clinic->status === 'active')
                        <span class="status-badge" style="padding: 6px 24px; font-size: 18px; border-radius: 50px; background-color: #13ee29; color: white;">
                            Active
                        </span>
                    @else
                        <span class="status-badge" style="padding: 6px 20px; font-size: 18px; border-radius: 50px; background-color: #f90d25; color: white;">
                            Inactive
                        </span>
                    @endif
                </td>
                <td class="action-btns">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('details_clinic', ['id' => $clinic->id]) }}" class="mr-1 btn btn-outline-success btn-sm">
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
        @foreach ($clinics as $clinic)
            <tr style="vertical-align: middle;">
                <td style="font-weight: bold;">{{ $clinic->id }}</td>
                <td>{{ $clinic->name ?? '—' }}</td>
                <td>{{ $clinic->location ?? $clinic->address ?? '—' }}</td>
                <td>{{ $clinic->email ?? '—' }}</td>
                <td>{{ $clinic->phone ?? '—' }}</td>
                <td>
                    @if($clinic->status === 'active')
                        <span class="status-badge" style="padding: 6px 24px; font-size: 18px; border-radius: 50px; background-color: #13ee29; color: white;">
                            Active
                        </span>
                    @else
                        <span class="status-badge" style="padding: 6px 20px; font-size: 18px; border-radius: 50px; background-color: #f90d25; color: white;">
                            Inactive
                        </span>
                    @endif
                </td>
                <td class="action-btns">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('details_clinic', ['id' => $clinic->id]) }}" class="mr-1 btn btn-outline-success btn-sm">
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
    @endif
@else
    <tr>
        <td colspan="9" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px; margin-top:50px;">No Clinics Found</strong>
        </td>
    </tr>
@endif
