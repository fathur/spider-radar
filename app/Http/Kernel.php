<?php

namespace Matagaruda\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Matagaruda\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,

        /**
         * External Library
         */
        \LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Matagaruda\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Matagaruda\Http\Middleware\RedirectIfAuthenticated::class,
        'csrf' => \Matagaruda\Http\Middleware\VerifyCsrfToken::class, // make some the authorization and resource server work correctly with Laravel5

        /**
         * External library
         */
        'oauth'         => \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class,
        'oauth-owner'   => \LucaDegasperi\OAuth2Server\Middleware\OAuthOwnerMiddleware::class,
        'check-authorization-params' => \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class
    ];
}
