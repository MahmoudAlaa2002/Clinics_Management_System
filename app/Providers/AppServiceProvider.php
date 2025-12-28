<?php

namespace App\Providers;

use App\Models\Conversation;
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

        //  قيم افتراضية تمنع Undefined variable في أي View
        View::share('navbarUnreadCount', 0);
        View::share('conversations', collect());

        // =========================
        // 1) Composer أدوار المستخدمين
        // =========================
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
            $doctor = null;
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
                'doctor',
                'nurse',
                'receptionist',
                'accountant',
                'employee',
                'employeeJobTitle',
                'patient'
            ));
        });


        /*
        |--------------------------------------------------------------------------
        | 2) عدّاد الرسائل غير المقروءة في الأيقونة
        |--------------------------------------------------------------------------
        */
        View::composer('*', function ($view) {

            if (!Auth::check()) return;

            $userId = Auth::id();

            $unread = Conversation::whereHas('participants', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->whereHas('messages', function($q) use ($userId) {
                    $q->where('is_read', false)
                      ->where('sender_id', '!=', $userId);
                })
                ->with('messages')
                ->get()
                ->sum(function ($c) use ($userId) {
                    return $c->messages
                        ->where('is_read', false)
                        ->where('sender_id', '!=', $userId)
                        ->count();
                });

            $view->with('navbarUnreadCount', $unread);
        });


        /*
        |--------------------------------------------------------------------------
        | 3) قائمة المحادثات للـ Dropdown (مع unread_count لكل محادثة)
        |--------------------------------------------------------------------------
        */
        View::composer('*', function ($view) {

            if (!Auth::check()) return;

            $userId = Auth::id();

            $conversations = Conversation::whereHas('participants', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->whereHas('messages')
                ->with([
                    'participants' => function ($q) use ($userId) {
                        $q->where('users.id', '!=', $userId);
                    },
                    'messages' => function ($q) {
                        $q->latest()->limit(1);
                    }
                ])
                ->get()
                ->map(function ($c) use ($userId) {

                    $c->unread_count = $c->messages()
                        ->where('is_read', false)
                        ->where('sender_id', '!=', $userId)
                        ->count();

                    return $c;
                })
                ->sortByDesc(fn ($c) => optional($c->messages->first())->created_at)
                ->values();

            $view->with('conversations', $conversations);
        });

    }
}
