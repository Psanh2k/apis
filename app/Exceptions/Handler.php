<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $responsesNamespace = 'App\Http\Responses\Exceptions';

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
    }

    protected $exceptionMapping = [
        'Illuminate\Validation\ValidationException'                         => 'ValidationResponse',
        'ErrorException'                                                    => 'ErrorExceptionResponse',
        'Error'                                                             => 'ErrorExceptionResponse',
        'Exception'                                                         => 'ErrorExceptionResponse',
        'App\Exceptions\BusinessException'                                  => 'BusinessExceptionResponse',
        'Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException'  => 'AccessDeniedHttpResponse',
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'      => 'NotFoundResponse',
        'Symfony\Component\HttpKernel\Exception\BadRequestHttpException'    => 'BadRequestResponse'
    ];

    public function render($request, Throwable $e)
    {
        if ($this->shouldRenderExceptionToJson($e)) {
            return $this->renderJsonExceptions($e);
        }

        // if ($e instanceof QueryException) {
        //     Log::channel('api')->error("Update Basic Information at". now() .  " : " . $e->getMessage());
        //     return $this->errorResponse(__('messages.fail_api'), Response::HTTP_INTERNAL_SERVER_ERROR);
        // }

        // if ($e instanceof MethodNotAllowedHttpException) {
        //     return $this->errorResponse('Method Not Allowed',Response::HTTP_METHOD_NOT_ALLOWED);
        // }

        // if ($e instanceof ThrottleRequestsException) {
        //     return $this->errorResponse(__('messages.to_many_request'),Response::HTTP_TOO_MANY_REQUESTS);
        // }

        return parent::render($request, $e);
    }

    protected function shouldRenderExceptionToJson(Throwable $exception)
    {
        if (! request()->expectsJson()) {
            return false; // this return used for blade
        }

        return ! is_null($this->getResponse($exception));
    }

    protected function getResponse(Throwable $exception)
    {
        return $this->jsonExceptions()->get(get_class($exception));
    }

    protected function jsonExceptions()
    {
        return collect($this->exceptionMapping);
    }

        /**
     * Render an exception to a JSON response.
     *
     * @param  Throwable  $exception
     * @return JsonResponse
     */
    protected function renderJsonExceptions(Throwable $exception)
    {
        $response = $this->responsesNamespace . '\\' . $this->getResponse($exception);

        return new $response($exception);
    }
}
