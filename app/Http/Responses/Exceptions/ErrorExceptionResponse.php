<?php

namespace App\Http\Responses\Exceptions;

use App\Core\BaseResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Throwable;

class ErrorExceptionResponse extends BaseResponse
{
    /**
     * ErrorExceptionResponse constructor.
     *
     * @param Throwable $e
     */
    public function __construct(Throwable $e)
    {
        $this->code = Response::HTTP_INTERNAL_SERVER_ERROR;
        $this->status = false;
        $this->message = $e->getMessage();
    }
}
