<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Context;

use App\Events\MessageNotification;

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
            $userId = Auth::user()->id;
            $user = User::find($userId);

            //Cache add item
            Cache::add('email',$user->email);

            Log::info('User authenticated.', ['auth_id' => Auth::id()]);

            var_dump(Context::get('url'));

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
