<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades;
use App\Http\ViewComposers\BookComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

use App\Models\User;
use App\Models\Branch;

use Illuminate\Support\Facades\Response;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Routing model explicit
        Route::model('user', User::class);
        

        //Route global configuration regex parttern
        Route::pattern('id', '[0-9]+');

        //Route Customizing the Resolution Logic
        Route::bind('branch', function (string $value) {
            return Branch::where('branch_id', $value)->firstOrFail();
        });

        //Route Rate Limiting
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(1000)->response(function (Request $request, array $headers) {
                return response('Custom response...', 429, $headers);
            });
        });

        //Views composer
        Facades\View::composer('home',BookComposer::class);

        Response::macro('caps', function (string $value) {
            return Response::make(strtoupper($value));
        });


        //Controller Localizing Resource URIs
        Route::resourceVerbs([
            'edit' => 'modifier'
        ]);

    }
}
