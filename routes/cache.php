<?php 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Contracts\Cache\LockTimeoutException;
use App\Models\User;
use App\Models\Book;
use App\Jobs\ProcessPodcast;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Client\Pool;


//Cache add item
Route::get('add',function(){
    if(session()->has('email')){
        $email = session()->get('email');
        Cache::add('email',$email,now()->addSeconds(30));
        Cache::add('cart',0, now()->addSeconds(30));
    }
});

//Cache retrieve item
Route::get('get',function(){
    if(Cache::has('email')){
        $email = Cache::get('email','default');
    }

    return $email;
});

//Cache incrementing
Route::get('incre/{quantity}',function(int $quantity){
    if(Cache::has('cart')){
        Cache::increment('cart',$quantity);
    }

    return Cache::get('cart',0);
});

//Cache decrementing
Route::get('decre/{quantity}',function(int $quantity){
    if(Cache::has('cart')){
        Cache::decrement('cart',$quantity);
    }

    return Cache::get('cart',0);
});

//Cache get item with function
Route::get('users',function(){
    $users = Cache::get('users',function(){
        return User::all();
    });

    return $users;
});

//Cache store item
Route::get('put',function(){
    $cart = 99;
    Cache::put('cart',$cart,now()->addSeconds(30));
});

//Cache retrieve and delete item
Route::get('pull',function(){
    $users = Cache::pull('users',0);
    return $users;
});

//Cache remove item
Route::get('delete',function(){
    Cache::forget('users');
    

    //Cache delete item with providing zero or negative expiration
    Cache::put('cart',100,-4);
    
    $cart = Cache::get('cart',0);
    $users = Cache::get('users',0);

    return [$users,$cart];
});

//Cache clear all data
Route::get('clear',function(){
    Cache::flush();
});


//Cache get item with REMEMBER
Route::get('usersRemember',function(){
    $users = Cache::remember('users',5,function(){
        return User::all();
    });

    return $users;
});


//Cache get item with FLEXIBLE
Route::get('usersFlexible',function(){
    $users = Cache::flexible('users',[5,10],function(){
        return User::all();
    });

    return $users;
});

//Cache helpers
Route::get('helper',function(){
    $email = cache('email','example@gmail.com');
    $cart = 50;
    cache(['cart'=>$cart],now()->addSeconds(15));

    $cart = cache('cart',0);

    $users = cache()->remember('users',5,function(){
        return User::all();
    });

    return [$email,$cart,$users];
});


//Cache managing locking
Route::get('lock',function(){
    $lock = Cache::lock('email', 10)->get(function(){
        sleep(5);
    });

    // if ($lock->get()) {
    
    //     sleep(5);
    //     $lock->release();
    // }
});

//Cache try get email when email is locked
Route::get('email',function(){
    $email = Cache::get('email');

    return $email.' with locking';
});

//Cache with using block, if accquired lock with N seconds, this will throw exception
Route::get('block',function(){
    $lock = Cache::lock('email', 10);
 
    try {
        echo $lock->block(5);
    
        // Lock acquired after waiting a maximum of 5 seconds...
    } catch (LockTimeoutException $e) {
        // Unable to acquire lock...
        return false;
    } finally {
        $lock->release();
    }
});

//Cache with locks processes
Route::get('process',function(){
    $lock = Cache::lock('processing',5);

    if ($lock->get()) {
        $book = Book::find(1);
        ProcessPodcast::dispatch($book, $lock->owner());
    }
    
});














