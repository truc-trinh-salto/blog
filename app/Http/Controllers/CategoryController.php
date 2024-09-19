<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request){
        var_dump($request->all());

        return view('category');
    }

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
