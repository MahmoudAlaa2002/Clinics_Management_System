<?php

namespace App\Http\Controllers\Backend\Shared;

use App\Models\User;
use App\Models\Message;
use App\Events\TestMessage;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller {


    //  عرض محادثة / إنشاء إذا لم توجد
    public function open($userId) {
        $current = Auth::user();
        $target  = User::findOrFail($userId);

        // ممنوع محادثة نفسه
        if ($current->id == $target->id) abort(403);

        // التحقق من قواعد السماح
        if (! $this->canChat($current, $target)) {
            abort(403, 'You are not allowed to chat with this user');
        }

        // البحث عن محادثة سابقة
        $conversation = Conversation::whereHas('participants', function ($q) use ($current) {
                $q->where('user_id', $current->id);
            })
            ->whereHas('participants', function ($q) use ($target) {
                $q->where('user_id', $target->id);
            })
            ->first();

        // إنشاء محادثة جديدة
        if (! $conversation) {
            $conversation = Conversation::create(['type' => 'private']);
            $conversation->participants()->attach([$current->id, $target->id]);
        }

        $conversation->load([
            'participants',
            'messages' => fn($q) => $q->orderBy('created_at', 'asc')
        ]);

        $conversation->messages()->where('sender_id', '!=', Auth::id())->where('is_read', false)
            ->update([
                'is_read' => true
            ]);

        return view('Backend.chat.conversation', compact('conversation', 'target'));
    }


    //  إرسال رسالة
    public function send(Request $request, $conversationId) {

        $request->validate([
            'message' => 'required|string|max:5000'
        ]);

        $conversation = Conversation::with('participants')->findOrFail($conversationId);

        // 🔥 هنا التعديل
        if (! $conversation->participants->contains('id', Auth::id())) {
            abort(403);
        }

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message'   => $request->message,
            'is_read'   => false,
        ]);

        broadcast(new \App\Events\NewChatMessage($message))->toOthers();

        return response()->json([
            'status'  => 'ok',
            'message' => $message
        ]);
    }


    // جعل الرسالة مقروءة طالما فاتح المحادثة
    public function markRead($conversationId){
        $conversation = Conversation::findOrFail($conversationId);

        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'ok']);
    }





    //  قواعد السماح بالتواصل
    private function canChat($current, $target) {

        // ⭐ Admin → مع الجميع
        if ($current->role === 'admin') return true;

        if ($current->role === 'clinic_manager')
            return $this->clinicManagerRules($current, $target);

        if ($current->role === 'department_manager')
            return $this->departmentManagerRules($current, $target);

        if ($current->role === 'doctor')
            return $this->doctorRules($current, $target);

        if ($current->role === 'employee')
            return $this->employeeRules($current, $target);

        if ($current->role === 'patient')
            return $this->patientRules($current, $target);

        return false;
    }




    public function index() {
        $userId = auth()->id();

        $conversations = Conversation::whereHas('participants', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('messages')
            ->with([
                'participants' => function ($q) use ($userId) {
                    $q->where('users.id', '!=', $userId);
                },

                'participants.patient',
                'participants.employee',
                'participants.doctor',

                'messages' => function ($q) {
                    $q->latest()->limit(1);
                }
            ])
            ->withCount([
                'messages as unread_count' => function ($q) use ($userId) {
                    $q->where('sender_id', '!=', $userId)
                      ->where('is_read', false);
                }
            ])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->take(1)
            )
            ->get();

        return view('Backend.chat.index', compact('conversations'));
    }












    // عرض المحادثات المتاحة لكل مستخدم
    public function contacts() {
        $current = Auth::user();
        $users = User::where('id', '!=', $current->id)->with('employee')->get();
        $filtered = $users->filter(function($user) use ($current){
            return $this->canChat($current, $user);
        });

        $page = request('page', 1);
        $perPage = 25;

        $contacts = new \Illuminate\Pagination\LengthAwarePaginator(
            $filtered->forPage($page, $perPage),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('Backend.chat.contacts', compact('contacts'));
    }



    private function clinicManagerRules($cm , $target) {
        $clinic = $cm->employee->clinic_id;

        if ($target->role === 'admin') return true;

        if ($target->role === 'department_manager'
            && $target->employee->clinic_id == $clinic) return true;

        if ($target->role === 'doctor'
            && $target->employee->clinic_id == $clinic) return true;

        if ($target->role === 'employee'
            && $target->employee->clinic_id == $clinic
            && in_array($target->employee->job_title, ['Accountant','Receptionist']))
            return true;

        if ($target->role === 'patient') {
            return $target->patient->clinics()->where('clinics.id', $clinic)->exists();
        }

        return false;
    }



    private function departmentManagerRules($dm , $target) {
        $clinic = $dm->employee->clinic_id;
        $dept   = $dm->employee->department_id;

        if ($target->role === 'admin') return true;

        if ($target->role === 'clinic_manager' && $target->employee->clinic_id == $clinic) return true;

        if ($target->role === 'doctor' && $target->employee->clinic_id == $clinic
            && $target->employee->department_id == $dept) return true;

        if ($target->role === 'employee' && $target->employee->clinic_id == $clinic && $target->employee->department_id == $dept
            && $target->employee->job_title == 'Receptionist') return true;

        return false;
    }



    private function doctorRules($doctor , $target) {
        $clinic = $doctor->employee->clinic_id;
        $dept   = $doctor->employee->department_id;

        if ($target->role === 'admin') return true;

        if ($target->role === 'clinic_manager'
            && $target->employee->clinic_id == $clinic) return true;

        if ($target->role === 'department_manager' && $target->employee->clinic_id == $clinic
            && $target->employee->department_id == $dept) return true;

        if ($target->role === 'employee' && $target->employee->clinic_id == $clinic
            && $target->employee->department_id == $dept
            && in_array($target->employee->job_title, ['Nurse','Receptionist']))
            return true;

        // المرضى الذين تعالجوا عنده
        if ($target->role === 'patient')
            return $target->patient->appointments()
                ->where('doctor_id', $doctor->employee->doctor->id)
                ->exists();


        return false;
    }



    private function employeeRules($emp , $target) {
        $job = $emp->employee->job_title;

        if ($job === 'Nurse')
            return $this->nurseRules($emp, $target);

        if ($job === 'Receptionist')
            return $this->receptionistRules($emp, $target);

        if ($job === 'Accountant')
            return $this->accountantRules($emp, $target);

        return false;
    }


    private function nurseRules($nurse , $target){
        $clinic = $nurse->employee->clinic_id;
        $dept = $nurse->employee->department_id;

        if ($target->role === 'admin') return true;

        if ($target->role === 'doctor' && $target->employee->clinic_id == $clinic
            && $target->employee->department_id == $dept) return true;

        if ($target->role === 'patient') {
            return $target->patient->vitalSigns()->where('nurse_id', $nurse->employee->id)->exists();
        }

        return false;
    }


    private function accountantRules($acc , $target) {
        $clinic_id = $acc->employee->clinic_id;

        if ($target->role === 'admin') return true;

        if ($target->role === 'clinic_manager' && $target->employee->clinic_id == $clinic_id)
            return true;

        if ($target->role === 'patient') {
            return $target->patient->invoices()->whereHas('appointment.clinicDepartment', function ($q) use ($clinic_id) {
                $q->where('clinic_id', $clinic_id);
                })->exists();
            }
            return false;
    }


    private function receptionistRules($rec , $target) {
        $clinic = $rec->employee->clinic_id;
        $dept = $rec->employee->department_id;

        if ($target->role === 'admin') return true;

        if ($target->role === 'clinic_manager' && $target->employee->clinic_id == $clinic) return true;

        if ($target->role === 'department_manager' && $target->employee->clinic_id == $clinic
            && $target->employee->department_id == $dept) return true;

        if ($target->role === 'doctor' && $target->employee->clinic_id == $clinic
            && $target->employee->department_id == $dept) return true;

        if ($target->role === 'patient') {
            return $target->patient->appointments()
                ->whereHas('clinicDepartment', function ($q) use ($clinic , $dept) {
                    $q->where('clinic_id', $clinic)->where('department_id', $dept);
                })->exists();
        }

        return false;
    }



    private function patientRules($patient , $target) {
        $patient = $patient->patient;

        if ($target->role === 'admin') return true;

        if ($target->role === 'doctor'
            && $patient->appointments()
                ->where('doctor_id', $target->employee->doctor->id)
                ->exists())
            return true;

        if ($target->role === 'employee'
            && $target->employee->job_title === 'Nurse'
            && $patient->vitalSigns()
                ->where('nurse_id', $target->employee->id)
                ->exists())
            return true;

            if ($target->role === 'employee'
                && $target->employee->job_title === 'Accountant'
                && $patient->invoices()
                    ->whereHas('appointment.clinicDepartment', function ($q) use ($target) {
                        $q->where('clinic_id', $target->employee->clinic->id);
                    })->exists())
                return true;

        if ($target->role === 'employee'
            && $target->employee->job_title === 'Receptionist'
            && $patient->appointments()
                ->whereHas('clinicDepartment', function ($q) use ($target) {
                    $q->where('clinic_id', $target->employee->clinic_id)
                    ->where('department_id', $target->employee->department_id);
                })
                ->exists())
            return true;

        return false;
    }
}
