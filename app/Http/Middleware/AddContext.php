<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Context
        Context::add('url', $request->url());
        Context::add('trace_id', Str::uuid()->toString());


        //Context listen event's DB
        DB::listen(function ($event) {
            Context::push('queries', [$event->time, $event->sql]);
        });


        //Context conditional
        Context::when(
            Auth::user(),
            fn ($context) => $context->add('permissions', Auth::user()->id),
            fn ($context) => $context->add('permissions', []),
        );
        return $next($request);
    }
}
