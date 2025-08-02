<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

     protected $routeMiddleware = [
        'admin'               => EnsureUserIsAdmin::class,

        'auth'                => \App\Http\Middleware\Authenticate::class,
        'guest'               => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified'            => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'throttle'            => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'can'                 => \Illuminate\Auth\Middleware\Authorize::class,
        'signed'              => \Illuminate\Routing\Middleware\ValidateSignature::class,

        'role'                => RoleMiddleware::class,
        'permission'          => PermissionMiddleware::class,
        'role_or_permission'  => RoleOrPermissionMiddleware::class,
    ];
}