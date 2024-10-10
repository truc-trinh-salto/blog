<?php

use App\Http\Controllers\BookCommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ManagementController;
use App\Events\OrderShipmentStatusUpdated;
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
use Illuminate\Support\Facades\Concurrency;
use App\Http\Middleware\EnsureValidUsername;
use App\Http\Middleware\EnsureValidCategoryName;
use App\Http\Middleware\AddContext;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;


//Route default
Route::get('/welcome',[HomeController::class,'welcome']);


Route::get('/home',[HomeController::class,'home']);


//Route redirect
Route::redirect('/','/welcome',301);

//Route views
Route::get('/register', function(){
    return view('auth.register',['name'=> 'Truc Trinh']);
});

//Route required parameters
//Request query parameters /user?name=
Route::get('/user',function(Request $request){
    $name = $request->query('name');

    // return 'This is user : '.$name;
    //Response using macro name 'caps'
    return response()->caps($name);
});

Route::get('test',function (){
    return view('test');
});

//Route optional parameters
// Route::get('/user/{name?}',function(?string $name = 'Alice'){
//     return 'This is user : '.$name;
// });

//Route Regular Expression Constraints
//Middleware passing parameters
//Reponse Models and Collections
Route::get('/book/{book:book_id}/info',function(Book $book){
    return $book;
})->whereNumber('book_id')->middleware('bookEdit:edit');

//Route named
Route::get(
    '/users/profileAll',
    [UserController::class, 'show']
)->name('profileAll');

//Route named
Route::get(
    '/users/profile/{user}',
    [UserController::class, 'edit']
)->name('profileUser');

Route::get('/profile/users/{user}',function(User $user){
    //Response populating models eloquent
    return redirect()->route('profileUser',[$user]);
});

Route::get('/profile/users',function(){

    //Response Redirect name routes
    return redirect()->route('profileAll');
});

Route::get('/errors/user',function(){
    if(!session()->has('cart')){
        $cart = array();
        $qtyCart = array();
        session()->put('cart', $cart);
        session()->put('qty_array',$qtyCart);
    }
    //Response Redirect name routes
    return ;
});




//Route middleware 
//Middleware Excluding
Route::middleware('subscribed')->group(function(){
    Route::get('/management/{role}/books',function(){
        return Book::all();
    });

    Route::get('/management/{role}/categories',function(){
        return Category::all();
    })->withoutMiddleware('subscribed');
});

//Route controller and prefix

Route::controller(CategoryController::class)->group(function (){
        Route::prefix('category')->group(function(){
            Route::get('/create', 'create');
            //Middleware assgining 
            Route::post('/create', 'store');
        });
});

//Route name prefixes
Route::name('category.')->group(function(){
    Route::prefix('category')->group(callback: function(){
        Route::get('/create', [CategoryController::class,'create'])->name('create');
        Route::post('/create', [CategoryController::class,'store'])->name('store');
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
    OrderShipmentStatusUpdated::dispatch($order);
    return $order;
})->scopeBindings();


//Route missing
Route::get('/users/{user}', function (User $user) {
    return $user->id;
})->missing(function(){

    //Response Redirects
    return redirect('/welcome');
}); 

//Route fall back
Route::fallback(function(){
    return view('welcome');
});

//Middleware using group 
Route::post('/register', [AuthController::class,'registerWithValidationManual']);

Route::get('/logout', [UserController::class,'logout']);

Route::post('/login', [UserController::class,'login'])->middleware(AddContext::class);

Route::post('/management/book/create',[BookController::class,'create']);
Route::get('/management/book/create',[ManagementController::class,'pageCreateBook']);




//ROUTES OF CART
Route::post('/cart/addToCart',[CartController::class,'addToCart']);

Route::get('/cart/removeFromCart',[CartController::class,'removeFromCart']);

Route::get('/cart/showCart',[CartController::class,'showCart']);

Route::get('/cart/clearCart',[CartController::class,'clearCart']);

//Session blocking
Route::post('/cart/updateCart',[CartController::class,'updateCart'])
->block($lockSeconds = 5,$waitSeconds = 5);


//Controller Additional Resources
Route::get('/branches/search/{search}',[BranchController::class,'search']);

//Controller Resource
//Controller Handle Missing
//Controller Names Resource Routes
Route::resource('branches', BranchController::class)
                ->names(['create' => 'save'])
                ->missing(function(Request $request){
                    return redirect()->route('branches.index');
                });

//Controller partial resource

Route::resource('transactions', TransactionController::class)->only([
                    'index', 'show'
                ]);

//Controller Nested Resource
//Controller Scoping Resource Routes
Route::resource('books.comments', BookCommentController::class)->scoped([
    'comment' => 'text',
]);


//Controller Resource Singleton
Route::singleton('profile', ProfileController::class);


Route::get('/collection', function(){

    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
 
    $slice = $collection->slice(4);
     
    $slice->all();

    Log::info('Test context');

    echo $slice;
});


Route::get('/context', function(){
    $context = Context::all();

    var_dump($context);


})->middleware(AddContext::class);











