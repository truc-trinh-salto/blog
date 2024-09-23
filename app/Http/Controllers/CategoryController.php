<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Middleware\EnsureValidCategoryName;
use App\Models\Category;

class CategoryController extends Controller implements HasMiddleware
{

    //Controller using middleware
    public static function middleware():array{
        return [new Middleware(EnsureValidCategoryName::class,only:['store'])];
    }

    //Request Denpendency Injection
    public function create(Request $request){
        // var_dump($request->all());

        return view('category');
    }


    //Controller Denpendency Injection
    public function store(Request $request){
        //Request retrieveing input
        $name = $request->input('name_category','Science');

        //Request stringable intput
        $name = $request->string('name')->trim();

        //Request uploads File
        if ($request->file('myfile')->isValid()) {
            $file = $request->file('myfile');


            //Create images/uploads/img.jpg in storage/app/
            $path = $request->myfile->store('images/uploads');

            echo $path;
        }


        //Request input persence
        $request->whenHas('name', function (string $input) {
            $category = Category::where('name_category',$input)->get();
            if($category){
                return back()
                        ->withErrors(['name_category' => 'Category name already exists'])
                        ->withInput();//Response redirect back
            }
        }, function(){
            return view('category');
        });

        return view('category');        
    }
}
