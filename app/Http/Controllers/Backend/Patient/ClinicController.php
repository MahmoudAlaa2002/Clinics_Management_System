<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class ClinicController extends Controller {

    public function clinicsView(Request $request) {
        $clinics = Clinic::with('departments')->where('status', 'active')->paginate(9);
        return view('Backend.patients.clinics.view', compact('clinics'));
    }




    public function searchClinics(Request $request) {
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinics = Clinic::with(['departments'])->where('status', 'active');

        if ($keyword !== '') {

            switch ($filter) {

                case 'clinic':
                    $clinics->where('name', 'like', "{$keyword}%");
                    break;

                case 'department':
                    $clinics->whereHas('departments', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'rating':
                    $clinics->where('rating', (int) $keyword);
                    break;

                default:
                    $clinics->where(function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%")
                        ->orWhere('rating', (int) $keyword)
                        ->orWhereHas('departments', function ($d) use ($keyword) {
                            $d->where('name', 'like', "{$keyword}%");
                        });
                    });
                    break;
            }
        }

        $clinics = $clinics->orderBy('id', 'asc')->paginate(9);

        $view = view('Backend.patients.clinics.search', compact('clinics'))->render();
        $pagination = ($clinics->total() > $clinics->perPage())
            ? $clinics->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $clinics->total(),
            'searching'  => $keyword !== '',
        ]);
    }

}
