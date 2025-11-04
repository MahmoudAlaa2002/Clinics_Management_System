<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfileController extends Controller
{

    public function profile()
    {
        $doctor = Auth::user()->employee->doctor;

        return view('Backend.doctors.profile.view', compact('doctor'));
    }


    public function edit()
    {
        $doctor = Auth::user()->employee->doctor;
        return view('Backend.doctors.profile.edit', compact('doctor'));
    }

    public function update(Request $request)
    {
        $doctor = Auth::user()->employee->doctor;
        $user = $doctor->employee->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'speciality' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'consultation_fee' => 'nullable|numeric|min:0',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'address'));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/doctors'), $imageName);
            $user->update(['image' => 'assets/img/doctors/' . $imageName]);
        }

        // Update doctor-specific fields
        $doctor->update($request->only('speciality', 'qualification', 'consultation_fee'));

        return redirect()->route('doctor.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function settings()
    {
        $doctor = Auth::user()->employee->doctor;
        return view('Backend.doctors.profile.settings', compact('doctor'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // تحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // تحديث كلمة المرور
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('doctor.profile.settings')->with('success', 'Password updated successfully.');
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Email updated successfully.');
    }

    public function logoutAll()
    {
        $user = Auth::user();
        $currentSessionId = session()->getId();
        // Revoke all sessions except current
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        return back()->with('success', 'Logged out from all devices.');
    }
}
