<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Models\VitalSign;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Events\InvoiceCancelled;
use Illuminate\Support\Facades\DB;
use App\Events\AppointmentAccepted;
use App\Events\AppointmentRejected;
use App\Events\AppointmentCancelled;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\AppointmentStatusUpdated;

class AppointmentController extends Controller
{
    public function allAppointments(Request $request)
    {
        $doctor = Auth::user()->employee->doctor;
        $appointments = Appointment::with(['patient.user', 'clinic', 'department', 'vitalSign'])->where('doctor_id', $doctor->id);

        if ($request->has('date') && !empty($request->date)) {
            if ($request->date == 'today') {
                $appointments->where('date', date('Y-m-d'));
            }
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $appointments->where('date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $appointments->where('date', '<=', $request->to_date);
        }

        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $appointments->where(function ($query) use ($keyword) {
                $query->where('status', 'LIKE', "%$keyword%")
                    ->orWhere('date', 'LIKE', "%$keyword%")
                    ->orWhere('time', 'LIKE', "%$keyword%")
                    ->orWhereHas('patient.user', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%$keyword%");
                    });
            });
        }

        return view('Backend.doctors.appointments.index', [
            'appointments' => $appointments->orderBy('date', 'desc')->orderBy('time', 'desc')->paginate(20),
        ]);
    }

    public function show(Appointment $appointment)
    {
        return view('Backend.doctors.appointments.show', compact('appointment'));
    }

    public function confirmAppointment(Appointment $appointment)
    {
        $appointment->status = 'Accepted';
        $appointment->save();

        AppointmentAccepted::dispatch($appointment, auth()->user());
        event(new AppointmentStatusUpdated($appointment));
        
        return redirect()->back()->with('success', 'Appointment confirmed successfully.');
    }

    public function rejectAppointment(Appointment $appointment)
    {
        $appointment->status = 'Rejected';
        $appointment->save();

        AppointmentRejected::dispatch($appointment, auth()->user());
        event(new AppointmentStatusUpdated($appointment));

        return redirect()->back()->with('success', 'Appointment rejected successfully.');
    }

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use($appointment, $validated){
            $note = $validated['note'] ?? 'Appointment cancelled by doctor';
            $appointment->update([
                'notes' => $note,
            ]);

            $appointment->status = 'Cancelled';
            $appointment->save();
        });

        $paidAmount = $appointment->invoice->paid_amount;
        $appointment->invoice->update([
            'invoice_status'  => 'Cancelled',
            'due_date'        => null,
            'refund_amount'   => $paidAmount,
        ]);

        AppointmentCancelled::dispatch($appointment, auth()->user());
        InvoiceCancelled::dispatch($appointment->invoice);
        event(new AppointmentStatusUpdated($appointment));

        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }

    public function calendar()
    {
        $doctor = Auth::user()->employee->doctor;

        $appointments = $doctor->appointments()
            ->with(['patient.user'])
            ->get()
            ->map(function($a) {
                return [
                    'title' => $a->patient->user->name,
                    'start' => $a->date . ' ' . $a->time,
                    'color' => $a->status == 'Accepted' ? '#03A9F4' :
                            ($a->status == 'Completed' ? '#28a745' :
                            ($a->status == 'Cancelled' ? '#dc3545' : '#6c757d')),
                    'extendedProps' => [
                        'status' => $a->status,
                        'notes'  => $a->notes,
                    ]
                ];
            });

        return view('Backend.doctors.appointments.calendar', [
            'appointmentsJson' => $appointments->toJson(),
        ]);
    }

    public function vitalSignsShow(VitalSign $vitalSigns)
    {
        $vitalSigns->load([
            'nurse.user',
            'appointment.patient.user',
            'appointment.doctor.employee.user',
        ]);

        return view('Backend.doctors.vital_signs.show', compact('vitalSigns'));
    }


}
