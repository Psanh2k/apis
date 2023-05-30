<?php

namespace App\Http\Responses\Exceptions;

use App\Core\BaseResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Throwable;

class AccessDeniedHttpResponse extends BaseResponse
{
    /**
     * ErrorExceptionResponse constructor.
     *
     * @param Throwable $e
     */
    public function __construct(Throwable $e)
    {
        $this->code = Response::HTTP_FORBIDDEN;
        $this->status = false;
        $this->message = $e->getMessage();
    }
}
