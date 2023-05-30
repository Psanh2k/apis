<?php

namespace App\Http\Responses\Exceptions;

use App\Core\BaseResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Throwable;

class BadRequestResponse extends BaseResponse
{
    /**
     * ErrorExceptionResponse constructor.
     *
     * @param Throwable $e
     */
    public function __construct(Throwable $e)
    {
        $this->code = Response::HTTP_BAD_REQUEST;
        $this->status = false;
        $this->message = $e->getMessage();
    }
}
