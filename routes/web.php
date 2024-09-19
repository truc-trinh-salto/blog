<?php

use App\Http\Controllers\BookCommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

//route default
Route::get('/welcome',[HomeController::class,'welcome']);

//Route redirect
Route::redirect('/','/welcome',301);

//Route views
Route::get('/register', function(){
    return view('auth.register',['name'=> 'Truc Trinh']);
});

//Route required parameters
Route::get('/user/{name}',function(string $name){
    return 'This is user : '.$name;
});

//Route optional parameters
Route::get('/user/{name?}',function(?string $name = 'Alice'){
    return 'This is user : '.$name;
});

//Route Regular Expression Constraints
Route::get('/book/{book:book_id}/info',function(Book $book){
    return $book;
})->whereNumber('book_id');

//Route named
Route::get(
    '/users/profileAll',
    [UserController::class, 'show']
)->name('profileAll');

Route::get('/profile/users',function(){
    return redirect()->route('profileAll');
});


//Route middleware 
Route::middleware('subscribed')->group(function(){
    Route::get('/management/{role}/books',function(){
        return Book::all();
    });

    Route::get('/management/{role}/categories',function(){
        return Category::all();
    });
});

//Route controller and prefix
Route::controller(CategoryController::class)->group(function (){
        Route::prefix('category')->group(function(){
            Route::get('/create', 'create');
            Route::post('/create', 'store');
        });
});

//Route name prefixes
Route::name('category.')->group(function(){
    Route::prefix('category')->group(function(){
        Route::get('/create', 'CategoryController@create')->name('create');
        Route::post('/create', 'CategoryController@store')->name('store');
    });
});

Route::get('create/category',function(){
    return redirect()->route('category.create');
});


//Route model bindings, customizes key
Route::get('/posts/{post:slug}', function (Post $post) {
    return $post->description;
});

//Route scope bindings
Route::get('users/{user}/orders/{order:id}', function (User $user, Order $order) {
    return $order;
})->scopeBindings();


//Route missing
Route::get('/users/{user}', function (User $user) {
    return $user->id;
})->missing(function(){
    return redirect('/welcome');
}); 

//Route fall back
Route::fallback(function(){
    return view('welcome');
});


Route::post('/register', [AuthController::class,'register']);


Route::resource('branches', BranchController::class);

Route::resource('books.comments', BookCommentController::class);









