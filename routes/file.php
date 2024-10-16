<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Http\Controllers\HomeController;


Route::get('/hello',function(){
    return 'Hello World!';
});


//File Download
Route::Get('/download',function(){
    $file= Storage::download('test.pdf');

    return $file;
});

//File url
Route::Get('/url',function(){
    $url= Storage::url('test.pdf');

    return $url;
}); 


//File storing
Route::get('/put', function(){

    $content = fopen(storage_path('app/images/uploads/z5JWyd3vJJF5C8FxWHBrLumzZZ1nNyjr9kdbgsnM.jpg'),'r');
    if (! Storage::put('file.jpg', $content)) {
        return false;
    }
    return true;
    
});


//File temporary url
Route::get('/temporary', function(){

    $url= Storage::temporaryUrl('test.pdf',now()->addSeconds(10));

    return $url;
    
});

//File metadata
Route::get('/metadata', function(){

    $size = Storage::size('test.pdf');
    $mime = Storage::mimeType('test.pdf');
    $time = Storage::lastModified('test.pdf');
    $path = Storage::path('test.pdf');

    echo $size.'</br>';
    echo $mime.'</br>';
    echo $time.'</br>';
    echo $path.'</br>';


    return ;
    
});

//File metadata
Route::get('/preApp', function(){

    $file = Storage::put('text.txt','body');
    Storage::prepend('text.txt','head');
    Storage::append('text.txt','foot');



    return $file;
    
});

//File move
Route::get('copyMove',function(){
    Storage::copy('text.txt','newtext.txt');
    Storage::move('text.txt','move/newtext.txt');
});

//File move
Route::get('putFile',function(){
    $path = Storage::putFile('photos', new File(storage_path('app/images/filename.jpg')));

    return $path;
});

//File visibility
Route::get('visible',function(){
    Storage::setVisibility('filename.jpg','private');
    
});

//File delete
Route::get('delete',function(){
    $del = Storage::delete('newtext.txt');
    return $del;
});

//File all
Route::get('allFiles',function(){
    $files = Storage::allFiles();
    return $files;
});


Route::get('arr',function(){
    $data = [
        'products' => [
            ['name' => 'Desk 1', 'price' => 100],
            ['name' => 'Desk 2'],
        ],
    ];
     
    data_fill($data, 'products.name.price', 200);

    return $data;

});

Route::get('num',function(){
    $result = Number::pairs(37, 7);

    return $result;

});

Route::get('path',function(){
    return response('Hello');
});

Route::get('url',function(){
    [$count, $duration] = Benchmark::value(fn () => User::count());

    return [$count, $duration];

});

Route::get('httpClient',function(){
    $response = Http::get('https://dummyjson.com/products/1');
    return $response->json();
});






