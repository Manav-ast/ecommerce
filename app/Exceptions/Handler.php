<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Custom handling for 404 errors in admin routes
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('admin/*') || $request->is('admin')) {
                return response()->view('errors.404', [], 404);
            }
        });

        // Custom handling for 403 errors in admin routes
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->is('admin/*') || $request->is('admin')) {
                return response()->view('errors.403', [], 403);
            }
        });

        // Custom handling for AccessDeniedHttpException in admin routes
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('admin/*') || $request->is('admin')) {
                return response()->view('errors.403', [], 403);
            }
        });

        // Handling for 500 errors in admin routes
        $this->renderable(function (HttpException $e, $request) {
            if (($request->is('admin/*') || $request->is('admin')) && $e->getStatusCode() == 500) {
                return response()->view('errors.500', [], 500);
            }
        });

        // Fallback for other exceptions in admin routes
        $this->renderable(function (Throwable $e, $request) {
            if (($request->is('admin/*') || $request->is('admin')) && !$this->isHttpException($e)) {
                return response()->view('errors.500', [], 500);
            }
        });
    }
}
