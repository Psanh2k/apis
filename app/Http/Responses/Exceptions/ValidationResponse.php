<?php

namespace App\Http\Responses\Exceptions;

use App\Core\BaseResponse;
use Illuminate\Http\Response;
use Throwable;

class ValidationResponse extends BaseResponse
{
    /**
     * ErrorExceptionResponse constructor.
     * @param Throwable $e
     */
    public function __construct(Throwable $e)
    {
        $this->code       = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->status     = false;

        collect($e->errors())->each(function ($val, $key) {
            $this->message[$key] = $val[0];
        });
    }
}
