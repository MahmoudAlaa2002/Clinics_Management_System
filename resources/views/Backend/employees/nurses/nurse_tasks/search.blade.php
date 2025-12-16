@if($nurse_tasks->count() > 0)
    @foreach ($nurse_tasks as $nurse_task)
        <tr>
            <td>{{ $nurse_tasks->firstItem() + $loop->index }}</td>
            <td>{{ $nurse_task->appointment_id }}</td>
            <td>{{ $nurse_task->appointment->patient->user->name }}</td>
            <td>{{ $nurse_task->appointment->doctor->employee->user->name }}</td>
            <td>{{ $nurse_task->task }}</td>
            <td>{{ \Carbon\Carbon::parse($nurse_task->performed_at)->format('Y-m-d') }}</td>
            <td>
                @if($nurse_task->status === 'Pending')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#ffc107; color:white;">
                        Pending
                    </span>
                @elseif($nurse_task->status === 'Completed')
                    <span class="status-badge" style="min-width: 140px; display:inline-block; text-align:center; padding:4px 12px; font-size:18px; border-radius:50px; background-color:#14ea6d; color:white;">
                        Completed
                    </span>
                @endif
            </td>
            <td class="action-btns">
                <div class="d-flex justify-content-center">

                    {{-- زر العرض --}}
                    <a href="{{ route('nurse.details_nurse_task', ['id' => $nurse_task->id]) }}"
                        class="mr-1 btn btn-outline-success btn-sm"
                        data-bs-toggle="tooltip" title="Details Nurse Task">
                        <i class="fa fa-eye"></i>
                    </a>

                    {{-- زر الإكمال فقط إذا المهمة pending --}}
                    @if($nurse_task->status === 'Pending')
                        <button class="btn btn-outline-success btn-sm complete-btn"
                                data-bs-toggle="tooltip" title="Complete Task"
                                data-id="{{ $nurse_task->id }}">
                            <i class="fas fa-check-circle"></i>
                        </button>
                    @endif

                </div>
            </td>


        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" class="p-4 text-center">
            <strong style="font-weight: bold; font-size: 18px; margin-top:50px;">No nurse task Available At The Moment</strong>
        </td>
    </tr>
@endif


