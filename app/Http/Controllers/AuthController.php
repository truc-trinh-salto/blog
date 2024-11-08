<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use App\Enums\UserRole;
use App\Http\Controllers\HomeController;
use App\Http\Requests\RegisterPostRequest;

class AuthController extends Controller
{
    //Controller Denpendency Injection
    //Request Denpendency Injection
    public function registerWithoutValidation(Request $request): RedirectResponse{
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

    //Validation form request

    public function registerWithValidation (RegisterPostRequest $request){

        //Validation validate action
        $validated = $request->validated();

        //Validation get portion of validated input
        $inputValidated = $request->safe();

        return redirect('register');
    }


    //Validation using Facades/Validator
    public function registerWithValidationManual(Request $request){

        $input = $request->all();

        //Validation using Validator 
        //Validation using Password
        $validator = Validator::make($input,
                            [
                                'name' => 'required|unique:users|max:255|min:8|alpha_num:ascii',
                                'email' => 'required|unique:users|email:rfc,dns',
                                'fullname' => 'required|max:255',
                                'phone_number' => 'nullable|max:11',
                                'birthday' => 'nullable | date',
                                'checkTerm' => 'accepted',
                                'password'=>['required','confirmed',Password::min(8)->mixedCase()->numbers()],
                                'password_confirmation' => 'required|min:8|same:password'],

                            [
                                'name.unique' => 'This username has been already existed',
                                'email.unique' => 'This email address has been already existed'],
                            [
                                'email' => 'email address',
                                'name' => 'username'
                            ]);

        if($validator->fails()) {
            return back()->withErrors($validator)
            ->withInput();
        }

        //Retrieve validated input
        $inputValidated = $validator->validated();

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
