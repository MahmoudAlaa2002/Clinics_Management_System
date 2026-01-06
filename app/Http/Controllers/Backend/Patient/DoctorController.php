<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DoctorController extends Controller {

    public function doctorsView(Request $request) {
        $doctors = Doctor::with(['employee.user', 'employee.department'])->paginate(12);
        return view('Backend.patients.doctors.view', compact('doctors'));
    }




    public function searchDoctors(Request $request) {
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $doctors = Doctor::with([
            'employee.user',
            'employee.clinic',
            'employee.department'
        ]);

        if ($keyword !== '') {

            switch ($filter) {

                case 'doctor':
                    $doctors->whereHas('employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'clinic':
                    $doctors->whereHas('employee.clinic', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'department':
                    $doctors->whereHas('employee.department', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'rating':
                    $doctors->where('rating', (int)$keyword);
                    break;

                default:
                    $doctors->where(function ($q) use ($keyword) {

                        $q->whereHas('employee.user', function ($u) use ($keyword) {
                            $u->where('name', 'like', "{$keyword}%");
                        })
                        ->orWhereHas('employee.clinic', function ($c) use ($keyword) {
                            $c->where('name', 'like', "{$keyword}%");
                        })
                        ->orWhereHas('employee.department', function ($d) use ($keyword) {
                            $d->where('name', 'like', "{$keyword}%");
                        })
                        ->orWhere('rating', (int)$keyword);
                    });

                    break;
            }
        }

        $doctors = $doctors->orderBy('id', 'asc')->paginate(12);

        $view = view('Backend.patients.doctors.search', compact('doctors'))->render();

        $pagination = ($doctors->total() > $doctors->perPage())
            ? $doctors->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $doctors->total(),
            'searching'  => $keyword !== '',
        ]);
    }

}
