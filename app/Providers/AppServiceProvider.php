<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    public function register(): void{
        //
    }


    public function boot(){
        Schema::defaultStringLength(125);

        View::composer([
                'Backend.admin.layout.*',
                'Backend.clinics_managers.layout.*',
                'Backend.departments_managers.layout.*',
                'Backend.doctors.layout.*',
                'Backend.employees.layout.*',
                'Backend.employees.nurses.layout.*',
                'Backend.employees.receptionists.layout.*',
                'Backend.employees.accountants.layout.*',
                'Backend.patients.layout.*',
            ], function ($view) {
            $currentUser = null;

            $admin = null;
            $clinicManager = null;
            $departmentManager = null;
            $doctor = null; // غيرت الاسم لتجنب التعارض
            $nurse = null;
            $receptionist = null;
            $accountant = null;


            $employee = null;
            $employeeJobTitle = null;
            $patient = null;

            if (Auth::check()) {
                $user = Auth::user();
                $currentUser = $user;

                if ($user->role == 'admin') {
                    $admin = $user;

                } elseif ($user->role == 'clinic_manager') {
                    $clinicManager = $user;

                } elseif ($user->role == 'department_manager') {
                    $departmentManager = $user;

                } elseif ($user->role == 'doctor') {
                    $doctor = $user;

                } elseif ($user->role == 'employee') {
                    $employee = $user;
                    $employeeJobTitle = $user->employee->job_title;

                    if ($employeeJobTitle === 'receptionist') {
                        $receptionist = $user;
                    } elseif ($employeeJobTitle === 'nurse') {
                        $nurse = $user;
                    } elseif ($employeeJobTitle === 'accountant') {
                        $accountant = $user;
                    }

                } elseif ($user->role == 'patient') {
                    $patient = $user;
                }
            }

            $view->with(compact(
                'currentUser',
                'admin',
                'clinicManager',
                'departmentManager',
                'doctor',  // اسم مختلف عن الـ Controller
                'nurse',
                'receptionist',
                'accountant',
                'employee',
                'employeeJobTitle',
                'patient'
            ));
        });

    }
}
