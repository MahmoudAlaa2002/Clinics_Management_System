@extends('Backend.admin.master')

@section('title' , 'View Prescription Items')


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

    .pagination-wrapper {
        margin-top: auto;
        padding-top: 80px; /* مسافة من الجدول */
        padding-bottom: 30px;
    }

</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">View Prescription Items</h4>
                <h4 style="margin-top: 30px; color:black;">Prescription ID: {{ $prescriptionItems->first()->prescription_id ?? '-' }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table mb-0 text-center table-bordered table-striped custom-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Medicine Name</th>
                                <th>Dosage Form</th>
                                <th>Strength</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($prescriptionItems->count() > 0)
                                @foreach ($prescriptionItems as $prescriptionItem)
                                    <tr>
                                        <td>{{ $prescriptionItem->id }}</td>
                                        <td>{{ $prescriptionItem->medications->name ?? '-' }}</td>
                                        <td>{{ $prescriptionItem->medications->dosageForm->name ?? '-' }}</td>
                                        <td>{{ $prescriptionItem->medications->strength ?? '-' }}</td>
                                        <td>{{ $prescriptionItem->frequency }}</td>
                                        <td>{{ $prescriptionItem->duration }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div  style="font-weight: bold; font-size: 18px; margin-top:15px;">
                                            No Prescription Item available at the moment
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{-- <div class="pagination-wrapper d-flex justify-content-center">
                        {{ $prescriptionItems->links('pagination::bootstrap-4') }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
