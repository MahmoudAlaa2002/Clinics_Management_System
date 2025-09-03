<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View{
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        $check = User::where('email' , '=' , $request->email)->first();         // هل الايميل موجود مسبقا
        if(isset($check)){
            return response()->json(['data' => 0]);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email =$request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->created_at = Carbon::now();
            $user->save();

            $user->assignRole(['patient']);

            Patient::create([
                'user_id' => $user->id,
            ]);


            event(new Registered($user));
            Auth::login($user);

            return response()->json([
                'data' => 1,
                'user_id' => $user->id,
            ]);
        }
    }
}
