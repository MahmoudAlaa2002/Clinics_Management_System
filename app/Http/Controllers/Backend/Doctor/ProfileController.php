<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->employee->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        // تحديث البيانات
        $user = $doctor->employee->user;
        $user->update($request->only('name', 'email', 'phone', 'address'));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/doctors'), $imageName);
            $imagePath = 'assets/img/doctors/' . $imageName;
            $user->update(['image' => $imagePath]);
        }

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
}
