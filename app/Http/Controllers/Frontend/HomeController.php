<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Testimonial;
use App\Jobs\SendContactMessageJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller{

    public function home(){
        $admin = User::role('admin')->first();
        $clinic_count = Clinic::count();
        $department_count = Department::count();
        $departments = Department::all();
        $doctor_count = Doctor::count();
        $patient_count = Patient::count();

        // $featuredDoctors = Doctor::where('is_featured', true)->take(4)->get();
        // if ($featuredDoctors->count() < 4) {
        //     $randomDoctors = Doctor::inRandomOrder()->take(4 - $featuredDoctors->count())->get();
        //     $doctors = $featuredDoctors->concat($randomDoctors);
        // } else {
        //     $doctors = $featuredDoctors;
        // }


        $patientsTestimonial = Testimonial::where('is_approved', true)->take(4)->get();
        if ($patientsTestimonial->count() < 5) {
            $randomPatientsTestimonial = Testimonial::where('is_approved', true)->inRandomOrder()->take(4 - $patientsTestimonial->count())->get();
            $patientsTestimonials = $patientsTestimonial->concat($randomPatientsTestimonial);
        } else {
            $patientsTestimonials = $patientsTestimonial;
        }
        return view('Frontend.master' , compact('admin' , 'clinic_count' , 'department_count' , 'departments' , 'doctor_count' , 'patient_count' ,  'patientsTestimonials'));
    }





    public function send(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // إرسال الإيميل عبر الـ Job (Queue)
        SendContactMessageJob::dispatch($validated);

        return response()->json(['data' => 1]);
    }
}
