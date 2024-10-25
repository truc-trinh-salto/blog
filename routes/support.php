<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;


Route::get('/hello',function(){
    return 'Hello World!';
});

Route::Get('/download/display',function(){
    $file= public_path(). "/download/test.pdf";

    $headers = array(
              'Content-Type: application/pdf',
            );
    //Response display file
    return response()->file($file, $headers);
});

Route::Get('/download',function(){
    $file= public_path(). "/download/test.pdf";

    $contents = Storage::get('images/filename.jpg');

    echo $contents;

    $headers = array(
              'Content-Type: application/pdf',
            );
    //Response download file
    return response()->download($file, 'filename.pdf', $headers);
});

Route::get('/sendMail/{id}', function (string $id) {
    $exitCode = Artisan::call('mail:send',['user_id'=>$id]);
    return $exitCode;
    // ...
});


