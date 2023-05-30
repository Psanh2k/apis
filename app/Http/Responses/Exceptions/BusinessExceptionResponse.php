<?php

namespace App\Http\Responses\Exceptions;

use App\Exceptions\BusinessException;
use App\Core\BaseResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusinessExceptionResponse extends BaseResponse
{
    protected $errorField = null;

    /**
     * NotFoundResponse constructor.
     *
     * @param BusinessException $e
     */
    public function __construct(BusinessException $e)
    {
        $message = $e->getMessage();

        if ($e->getCode() == Response::HTTP_UNAUTHORIZED) {
            $message = 'Unauthenticated.';
        }

        $this->errorField = $e->getErrorField();
        $this->message    = $message;
        $this->errors     = ['message' => $e->getMessage()];
        $this->statusCode = $e->getCode();
    }

    /**
     * The authentication response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        $data = ['message' => $this->message];

        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        if ($this->errorField) {
            $data['errors'] = [array_merge($data['errors'], [
                'name' => $this->errorField
            ])];
        }

        return response()->json($data, $this->statusCode);
    }
}
