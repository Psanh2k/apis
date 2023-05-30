<?php


namespace App\Http\Responses\Exceptions;

use App\Core\BaseResponse;
use Illuminate\Http\Response;

class NotFoundResponse extends BaseResponse
{
    protected $message    = '';
    protected $status     = false;
    protected $code = Response::HTTP_NOT_FOUND;
}
