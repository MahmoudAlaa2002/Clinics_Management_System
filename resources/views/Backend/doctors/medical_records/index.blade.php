@extends('Backend.doctors.master')

@section('title', 'Manage Medical Records')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row mb-3 align-items-center">
            <div class="col-md-6 col-12">
                <h4 class="page-title mb-0">Manage Medical Records</h4>
            </div>
        </div>

        {{-- Filters & Search --}}
        <div class="card-box p-3 mb-4 shadow-sm">
            <form method="GET" action="{{ route('doctor.medical_records') }}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, diagnosis, treatment..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">From Date</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">To Date</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-2 text-end mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">
                            <i class="fa fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="card-box shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Diagnosis</th>
                            <th>Treatment</th>
                            <th>Date</th>
                            <th>Notes</th>
                            <th>Attachments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($medicalRecords as $record)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('doctor.patients.show', $record->patient) }}">
                                        {{ $record->patient->user->name ?? '-' }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($record->diagnosis, 40) }}</td>
                                <td>{{ Str::limit($record->treatment, 40) }}</td>
                                <td>{{ $record->record_date }}</td>
                                <td>{{ Str::limit($record->notes, 40) ?? '-' }}</td>
                                <td>
                                    @if($record->attachmentss)
                                        @php
                                            $files = json_decode($record->attachmentss, true);
                                        @endphp

                                        @if(is_array($files))
                                            <ul class="list-unstyled mb-0">
                                                @foreach($files as $file)
                                                    @if(is_string($file))
                                                        <li>
                                                            <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('doctor.medical_records.show', $record) }}" class="mr-1 btn btn-outline-success btn-sm">
                                            <i class="fa fa-eye"></i> Details
                                        </a>
                                        <a href="{{ route('doctor.medical_records.edit', $record) }}" class="mr-1 btn btn-outline-primary btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No medical records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $medicalRecords->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
