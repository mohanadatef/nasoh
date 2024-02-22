<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Basic\Traits\ApiResponseTrait;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     * A list of the exception types that are except it
     * @note when not found url in api will back response 404 but in web response page 404
     * @note when authentication is required in api will response 401
     * @note when method isn't same type or not found it api will response 405
     * @note when model isn't found it api will response 400
     * @param $request
     * @param $e => exception
     * @return Application|ResponseFactory|JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     *
     */
    public function render($request, $e)
    {
        if ($e instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return $this->notFoundResponse("url not Found");
            }
        }

        if ($e instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return $this->unauthorizedResponse('login first');
            }
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->methodNotAllowed( $e->getMessage());
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->unKnowError( $e->getMessage());
        }

        return parent::render($request, $e);
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
