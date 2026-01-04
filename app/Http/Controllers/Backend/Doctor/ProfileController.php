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

    public function profile(){
        $doctor = Auth::user();
        return view('Backend.doctors.profile.view', compact('doctor'));
    }


    public function edit() {
        $doctor = Auth::user();
        return view('Backend.doctors.profile.edit', compact('doctor'));
    }

    public function update(Request $request){
        $doctor = Auth::user();

        $password = $doctor->password;
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }

        $imagePath = $doctor->image; // الصورة القديمة
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $newPath = 'assets/img/doctor/' . $imageName;


            $file->move(public_path('assets/img/doctor'), $imageName);

            if (!empty($imagePath) && file_exists(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }

            $imagePath = $newPath;
        }

        $doctor->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $password,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'image'        => $imagePath,
            'date_of_birth'=> $request->date_of_birth,
            'gender'       => $request->gender,
        ]);

        return response()->json(['data' => 1]);
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
