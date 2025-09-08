<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void{
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(){
        Schema::defaultStringLength(125);

        View::composer([
                'Backend.admin.layout.*',
                'Backend.clinics_managers.layout.*',
                'Backend.departments_managers.layout.*',
                'Backend.doctors.layout.*',
                'Backend.employees.layout.*',
                'Backend.employees.accountants.layout.*',
                'Backend.employees.nurses.layout.*',
                'Backend.employees.pharmacists.layout.*',
                'Backend.employees.receptionists.layout.*',
                'Backend.employees.stores_supervisors.layout.*',
                'Backend.patients.layout.*',
            ], function ($view) {
            $currentUser = null;

            $admin = null;
            $clinicManager = null;
            $departmentManager = null;
            $doctorUser = null; // غيرت الاسم لتجنب التعارض
            $storeSupervisor = null;
            $accountant = null;
            $nurse = null;
            $receptionist = null;
            $pharmacist = null;

            $employee = null;
            $employeeJobTitle = null;
            $patient = null;

            if (Auth::check()) {
                $user = Auth::user();
                $currentUser = $user;

                if ($user->hasRole('admin')) {
                    $admin = $user;

                } elseif ($user->hasRole('clinic_manager')) {
                    $clinicManager = $user;

                } elseif ($user->hasRole('department_manager')) {
                    $departmentManager = $user;

                } elseif ($user->hasRole('doctor')) {
                    $doctorUser = $user;

                } elseif ($user->hasRole('employee')) {
                    $employee = $user;
                    $jobTitle = $user->employee?->jobTitles()->first();
                    $employeeJobTitle = $jobTitle ? $jobTitle->name : 'general';

                    if ($employeeJobTitle === 'store_supervisor') {
                        $storeSupervisor = $user;
                    } elseif ($employeeJobTitle === 'accountant') {
                        $accountant = $user;
                    } elseif ($employeeJobTitle === 'nurse') {
                        $nurse = $user;
                    } elseif ($employeeJobTitle === 'receptionist') {
                        $receptionist = $user;
                    } elseif ($employeeJobTitle === 'pharmacist') {
                        $pharmacist = $user;
                    }
                } elseif ($user->hasRole('patient')) {
                    $patient = $user;
                }
            }

            $view->with(compact(
                'currentUser',
                'admin',
                'clinicManager',
                'departmentManager',
                'doctorUser',  // اسم مختلف عن الـ Controller
                'storeSupervisor',
                'accountant',
                'nurse',
                'receptionist',
                'pharmacist',
                'employee',
                'employeeJobTitle',
                'patient'
            ));
        });

    }
}
