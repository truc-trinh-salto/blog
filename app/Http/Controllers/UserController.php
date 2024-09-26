<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function show(){
        return User::all();
    }

    public function edit(User $user){

        return User::find($user);
    }
}
