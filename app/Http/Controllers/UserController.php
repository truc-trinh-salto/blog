<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    public function show(){
        return User::all();
    }

    public function edit(User $user){
        //Logging info
        Log::info('Showing the user profile for user: {id}', ['id' => $user->id]);
        return User::find($user);
    }

    public function login(Request $request){
        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        if (Auth::attempt($login)) {
            session()->put('fullname',Auth::user()->fullname);
            session()->put('email',Auth::user()->email);
            return redirect('/home');
        } else {
            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
        }
    }

    public function logout(){
        Auth::logout();
        session()->invalidate();
        return redirect('/welcome');
    }
}
