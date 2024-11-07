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



//Helper Arr join method
Route::get('arrJoin',function(){
    $array = Arr::join([1,2,3,4],',');

    return $array;
});


//Helper Array keyBy method
Route::get('arrKeyBy',function(){
    //If value of key is duplicated, this will return the last element
    $array = [['name' => 'Trung Truc','university' =>'TDT'],['name' => 'Nguyen Van A','university' => 'TDT']];

    $keyBy = Arr::keyBy($array,'university');

    return $keyBy;
});

//Helper Array get method
Route::get('arrGet',function(){
    // $array = ['name' => 'Trung Truc','university' => 'TDT', 'age' => 21, 'phoneNumber' => '0934541496'];

    $array = ['university' => 'TDT', 'age' => 21, 'phoneNumber' => '0934541496'];

    //Default 'David' if null
    $data = Arr::get($array,'name','David');

    return $data;
});

//Helper Array first method
Route::get('arrFirst',function(){
    $collection = collect()->range(0,10);

    $first = Arr::first($collection);

    return $first;
});


//Helper Array last method
Route::get('arrLast',function(){
    $collection = collect()->range(0,10);

    $last = Arr::last($collection->toArray(),null);

    return $last;
});

//Helper Array pluck method
Route::get('arrPluck',function(){
    $array = [['name' => 'Trung Truc','university' =>'TDT','age'=>21],['name' => 'Nguyen Van A','university' => 'UEH','age'=>22]];

    $pluck = Arr::pluck($array,['university'],'name');

    return $pluck;
});

// Route::get('test',function(){
//     $array = [
//         // ['Li', 'Roman', 'Taylor'],   
//         // ['one' => 1, 'three' => 3, 'two' => 2],
//         // ['JavaScript', 'PHP', 'Ruby'],
//         // ['Li', 'Roman', 'Taylor'],
//         // ['one' => 1, 'three' => 3, 'two' => 2],
//         // ['Li', 'Roman', 'Taylor'],
//         // ['JavaScript', 'PHP', 'Ruby'], 
//         // ['one' => 1, 'three' => 3, 'two' => 2],
//         // ['Li', 'Roman', 'Taylor'],
        
//         ['JavaScript', 'PHP', 'Ruby'],
//         ['Li', 'Roman', 'Taylor'],



//     ];
     
//     $sorted = sort($array);
//     return $array;
// });

//Helper Number format method
Route::get('numberFormat',function(){
    $format = Number::format(1234567);

    return $format;
});

//Helper Number percentage method
Route::get('numberPercentage',function(){
    $percentage = Number::percentage(10);

    return $percentage;
});

//Helper Number currency method
Route::get('numberCurrency',function(){
    // $currency = Number::currency(1000,'USD');

    // $currency = Number::currency(1000,'VND');


    // $currency = Number::currency(1000,'EUR');

    $currency = Number::currency(1000,'JPY');

    return $currency;
});

//Helper Number fileSize method
Route::get('fileSize',function(){
    //value with Byte unit
    $file = Storage::size('file.jpg');

    // Convert with unit file size such as B KB MB GB
    $size = Number::fileSize($file);


    return $size;
});


//Helper Number forHumans method
Route::get('forHumans',function(){
    $data = Number::forHumans(123456789);

    return $data;
});

//Helper Number setLocale method
Route::get('setLocale',function(){
    // Number::setLocale('');
    $data = Number::withLocale('vi',function(){
        return Number::format(12345678.5);
    });

    return $data;
});


//Helper Urls action 
Route::get('action',function(){

    //return url localhost:8080/homeWithAll with route url which define in route
    $url = action([HomeController::class, 'getAll']);

    return $url;
});

//Helper Urls route
Route::get('route',function(){

    //return url which define in route via named route
    $url = route('profileAll');

    return $url;
});

//Helper Urls to_route
Route::get('toRoute',function(){
    //redirect to route with named route
    return to_route('transactions.show',['transaction' => 2]);
});

//Helper Urls url
Route::get('url',function(){
    return url('create/category');
});


//Helper Create Custom Helper for Book
Route::get('helperBook/{bookId}',function(int $bookId){
    return BookHelper::getItem($bookId);
});




















