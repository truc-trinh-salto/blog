<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Process\Pipe;
use Illuminate\Process\Pool;
use App\Models\Book;
use App\Jobs\ProcessPodcast;
use Illuminate\Support\Facades\Context;



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


//Console 
Route::get('/sendMail/{id}', function (string $id) {
    $exitCode = Artisan::call('mail:send',['user_id'=>$id]);

    return $exitCode;
    // ...
});

Route::get('/processes',function(){
    // $result = Process::pipe(function (Pipe $pipe) {
    //     $pipe->path(__DIR__.'/..')->command('type example.txt');
    //     $pipe->path(__DIR__.'/..')->command('type example1.txt');
    // }, function (string $type, string $output) {
    //     echo $output.' ';
    // });

    // $result = Process::path(__DIR__.'/..')->run('type example.txt');

    // $result = Process::path(__DIR__.'/..')->input('Hello World')->run('type');

    // $process = Process::timeout(120)->path(__DIR__.'/..')->start('type example.txt',function(string $type, string $output){
    //     echo $output.' ';
    // });
 
    // while ($process->running()) {
        
    //     echo $process->latestOutput();
    // }

    // // $result = $process->wait();

    // $signal = $process->signal(SIGUSR2);

    // echo $signal;

    $pool = Process::pool( function(Pool $pool){
        $pool->as('first')->path(__DIR__.'/..')->command('type example.txt');
        $pool->as('second')->path(__DIR__.'/..')->command('type example1.txt');
        $pool->as('third')->path(__DIR__.'/..')->command('type example2.txt');
    })->start(function(string $type, string $output, string $key){
        // echo $type.'</br>';
    });


    // $results = $pool->wait();

    $iDs = $pool->running()->each->id();

    return $iDs;
});

Route::get('queue',function(){
    $book = Book::find(1);
    
    ProcessPodcast::dispatch($book)->withoutDelay();

});




