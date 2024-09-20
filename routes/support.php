<?php 

use Illuminate\Support\Facades\Route;

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

    $headers = array(
              'Content-Type: application/pdf',
            );
    //Response download file
    return response()->download($file, 'filename.pdf', $headers);
});


