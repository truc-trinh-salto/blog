<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Middleware\EnsureValidCategoryName;

class CategoryController extends Controller implements HasMiddleware
{

    //Controller using middleware
    public static function middleware():array{
        return [new Middleware(EnsureValidCategoryName::class,only:['store'])];
    }


    public function create(Request $request){
        var_dump($request->all());

        return view('category');
    }


    //Controller Denpendency Injection
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name_category' => 'required|unique:categories|max:255',
        ]);

        // dd($request->all());
        
        if ($validator->fails()) {
            // dd($request->input());
            return redirect('category/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        // return redirect('/');
    }
}
