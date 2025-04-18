<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {//*En esta seccion se añaden los middleware ya sea con alias para alguna parte en concreto o de forma global
        //Hay que añadir el middleware para que funcione en la ruta. En AppServiceProvider se ha añadido el middleware is.admin. para que funcione con ese alias se hace así
        $middleware->alias(
            ['is.admin' => \App\Http\Middleware\CheckIfAdmin::class]
        );
        //Si se desea que el middleware sea global se haría $middleware->add(\App\Http\Middleware\CheckAdmin::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
