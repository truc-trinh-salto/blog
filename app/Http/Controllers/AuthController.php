<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use App\Enums\UserRole;
use App\Http\Controllers\HomeController;

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
                            ->withInput() //Request Flashing Input Then Redirecting
                            ->with('status','Registered failed!'); // Response redirect with flash data
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
    public function login(Request $request){
        //Request Content Negotiation
        if (!$request->accepts(['text/html'])) {
            //Response redirect to controller action
            return redirect()->action([HomeController::class,'welcome']);
        }

        //Request retrieving portion of input
        $username = $request->only(['username']);

        //Response return view with data
        return response()->view('welcome',['name' => $username['username']]);
    }
}
