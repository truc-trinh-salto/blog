<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    //Controller Denpendency Injection
    public function register(Request $request): RedirectResponse{
        // $validator = Validator::make($request->all(), [
        //     'name' => ['required', 'max:255','unique:users,name'],
        //     'phone_number' => ['nullable', 'max:11','unique:users,phone_number'],
        //     'birthday' => ['nullable', 'date'],
        //     'email' => ['required', 'email:rfc,dns','unique:users,email'],
        //     'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
        //     'password_confirmation' => 'required|min:8|same:password',
        // ]);

        // if ($validator->fails()) {
        //     // dd($request->input());
        //     return redirect('register')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        // $user = User::create([
        //     'name' => $request->name,
        //     'fullname' => $request->fullname,
        //     'phone_number' => $request->phone_number,
        //     'birthday' => $request->birthday,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password)]);

        return redirect('register');
    }

    //Controller Denpendency Injection
    public function login(Request $request): RedirectResponse{
        $username = $request->username;
        return redirect()->view('welcome',['name' => $username]);
    }
}
