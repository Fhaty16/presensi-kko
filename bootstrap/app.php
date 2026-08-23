<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | TRUST PROXY
        |--------------------------------------------------------------------------
        |
        | Dibutuhkan agar Laravel mengenali HTTPS dari Cloudflare Tunnel.
        | Tanpa ini Laravel dapat menganggap request masih HTTP sehingga
        | CSS, session, CSRF, kamera, dan redirect dapat bermasalah.
        |
        */

        $middleware->trustProxies(
            at: '*',
            headers:
                Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO |
                Request::HEADER_X_FORWARDED_PREFIX
        );


        /*
        |--------------------------------------------------------------------------
        | MIDDLEWARE ALIAS
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {

        /*
        |--------------------------------------------------------------------------
        | JSON RESPONSE
        |--------------------------------------------------------------------------
        |
        | Request API atau AJAX yang meminta JSON akan mendapatkan
        | response JSON, bukan halaman HTML error.
        |
        */

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) =>
                $request->is('api/*') ||
                $request->expectsJson(),
        );

    })

    ->create();