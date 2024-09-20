<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use App\Enums\UserRole;

class AuthController extends Controller
{
    //Controller Denpendency Injection
    //Request Denpendency Injection
    public function register(Request $request): RedirectResponse{
        //Request inspect path and retrieve method

        //Request input 
        $input = $request->all();
        if($request->is('register') &&  $request->isMethod('post')){


            //Request Input Presence
            if(!$request->has(['name','email','password'])){

                return redirect('register')
                            ->withErrors(['name'=>'Name and Email are required',
                                                    'password'=>'Password and Confirm Password are required'])
                            ->withInput(); //Request Flashing Input Then Redirecting
            }

            $birthday = $request->date('birthday');

            //Request Merging Additional
            $request->merge(['role'=>'user']);


            //Request enum  validation
            $status = $request->enum('role', UserRole::class);

        }

        return redirect('register');
    }

    //Controller Denpendency Injection
    public function login(Request $request): RedirectResponse{
        //Request Content Negotiation
        if ($request->accepts(['text/html', 'application/json'])) {
            return redirect('login');
        }

        //Request retrieving portion of input
        $username = $request->only(['username']);

        return redirect()->view('welcome',['name' => $username]);
    }
}
