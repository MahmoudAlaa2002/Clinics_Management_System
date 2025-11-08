@extends('Backend.doctors.master')

@section('title', 'My Patients')

@section('content')
<style>
    html, body { height: 100%; margin: 0; }
    .page-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
    .content { flex: 1; display: flex; flex-direction: column; }
    .pagination-wrapper { margin-top: auto; padding-top: 60px; padding-bottom: 30px; }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row mb-3">
            <div class="col-sm-6 col-12">
                <h4 class="page-title">My Patients</h4>
            </div>
        </div>

        {{-- Filters & Search --}}
            <div class="card-box p-3 mb-4 shadow-sm">
                <form method="GET" action="{{ route('doctor.patients') }}">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="keyword">Filter</label>
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                placeholder="Search by Patient name, Email, Phone and Boold Type..." value="{{ request('keyword') }}">
                        </div>

                        <div class="col-md-2 text-end mt-3 mt-md-0">
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">
                                <i class="fa fa-search me-1"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        {{-- 📋 Table --}}
        <div class="table-responsive">
            <table class="table mb-0 text-center table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Blood Type</th>
                        <th>Emergency Contact</th>
                        <th>Allergies</th>
                        <th>Chronic Diseases</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr>
                            <td>{{ ($patients->currentPage() - 1) * $patients->perPage() + $loop->iteration }}</td>
                            <td>{{ $patient->user->name }}</td>
                            <td>{{ $patient->user->email ?? '-' }}</td>
                            <td>{{ $patient->user->phone ?? '-' }}</td>
                            <td>{{ $patient->user->address ?? '-' }}</td>
                            <td>{{ $patient->blood_type ?? '-' }}</td>
                            <td>{{ $patient->emergency_contact ?? '-' }}</td>
                            <td>{{ $patient->allergies ?? '-' }}</td>
                            <td>{{ $patient->chronic_diseases ?? '-' }}</td>
                            <td>
                                <a href="{{ route('doctor.patients.show', $patient) }}" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-eye"></i> View Patient details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center" style="font-weight: bold; font-size: 18px; margin-top: 15px;">
                                No patients found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper d-flex justify-content-center">
                {{ $patients->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
