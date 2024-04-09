<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use TypeError;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
        });

        // $this->renderable(function (Exception $exception, $request) {

        //     if ($exception instanceof ModelNotFoundException) {
        //         $modelName = strtolower(class_basename($exception->getModel()));
        //         return $this->errorResponse(
        //             "Does not exists any {$modelName} with the specific identicator",
        //             404
        //         );
        //     }

        //     if ($exception instanceof NotFoundHttpException) {
        //         return $this->errorResponse(
        //             "The specified URL cannot be found",
        //             403
        //         );
        //     }

        //     if ($exception instanceof AuthenticationException) {
        //        return $this->errorResponse('Unauthenticated', 401);
        //     }

        //     if ($exception instanceof AuthorizationException) {
        //       return  $this->errorResponse('Authorize', 403);
        //     }

        // });
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse(
                "Does not exists any {$modelName} with the specific identicator",
                404
            );
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse(
                "The specified URL cannot be found",
                403
            );
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('Unauthenticated', 401);
        }

        if ($exception instanceof AuthorizationException) {
            $this->errorResponse('Authorize', 403);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(
                "The specified method {$request->method()} for the request is invalid",
                403
            );
        }

        // if ($exception instanceof TypeError) {
        //     return $this->errorResponse(
        //         "Type error",
        //         405
        //     );
        // }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpexted Exception. Try later', 500);
    }
}
