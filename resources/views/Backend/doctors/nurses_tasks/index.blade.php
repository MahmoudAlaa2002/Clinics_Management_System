@extends('Backend.doctors.master')

@section('title', 'Nursing Tasks')

@section('content')

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .custom-table tbody tr {
        transition: filter 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-table tbody tr:hover {
        filter: brightness(90%);
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        cursor: pointer;
    }
</style>

<div class="page-wrapper">
    <div class="content">

        <div class="row mb-4">
            <div class="col-sm-6">
                <h4 class="page-title">Nursing Tasks</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nurse Name</th>
                                <th>Patient Name</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Performed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($tasks->count() > 0)
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            {{ $task->nurse->user->name ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $task->appointment->patient->user->name ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $task->task }}
                                        </td>

                                        <td>
                                            @if($task->status === 'Completed')
                                                <span class="badge badge-success">Completed</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $task->performed_at ? \Carbon\Carbon::parse($task->performed_at)->format('Y-m-d H:i') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            No Nursing Tasks Available
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
