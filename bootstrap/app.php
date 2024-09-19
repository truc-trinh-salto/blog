<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsurePostIdValid;
use App\Http\Middleware\EnsureValidEmail;
use App\Http\Middleware\EnsureValidUsername;
use App\Http\Middleware\EnsureBookHasEdit;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        //ROUTE CUSTOMIZATION
        then: function(){
            Route::middleware('api')
                ->prefix('support')
                ->name('support.')
                ->group(base_path('routes\support.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        //Middleware Alisas
        $middleware->alias([
            'subscribed' => EnsurePostIdValid::class,
            'bookEdit' => EnsureBookHasEdit::class
        ]);


        //Middleware Groups
        $middleware->appendToGroup('ensureUsernameEmail',[
            EnsureValidUsername::class,
            EnsureValidEmail::class,
        ]);

        //Middleware Sorting
        $middleware->priority([
            EnsureValidEmail::class,
            EnsureValidUsername::class,
        ]);

        //CRSF's middleware
        $middleware->validateCsrfTokens();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
