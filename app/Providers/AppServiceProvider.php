<?php

namespace App\Providers;

use App\View\Components\CardBook;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades;
use App\Http\ViewComposers\BookComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Illuminate\Log\Context\Repository;
use App\View\Components\Alert;

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

        //View share key data
        Facades\View::share('country', 'Viet Nam');

        //Views composer class base
        Facades\View::composer(['home','user.home','auth.*','user.test','user.view_cart'],BookComposer::class);

        //View composer colsure base with Multiple views
        Facades\View::composer(['home','auth.login','welcome'], function (View $view) {
            $view->with('district', 'District 7');
        });


        //Response macro
        Response::macro('caps', function (string $value) {
            return Response::make(strtoupper($value));
        });


        //Controller Localizing Resource URIs
        Route::resourceVerbs([
            'edit' => 'modifier'
        ]);

        //Blade template registering package components
        Blade::component('package-alert', Alert::class);
        Blade::component('card-book', CardBook::class);


        Context::hydrated(function (Repository $context) {
            $context->add('locale', 'en');
        });

    }
}
