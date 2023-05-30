<?php

namespace App\Core;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Core\ApiResponse;

abstract class BaseResponse implements Responsable
{
    use ApiResponse;
    
    /** @var String|array $message */
    protected $message = [];

    /** @var array $data */
    protected $data = [];

    /** @var int $code */
    protected $code = Response::HTTP_OK;

    /** @var boolean $status */
    protected $status = true;

    /**
     * The authentication response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        $rs = [
            'status'      => $this->status,
            'code'        => $this->code,
            'message'     => $this->message,
        ];

        if ($this->status) {
            $rs['data'] = $this->data;
        }

        return response()->json($rs, $this->code);
    }

    /**
     * @param int $code
     * @return BaseResponse
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param array $data
     * @return BaseResponse
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param String|array $message
     * @return BaseResponse
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param boolean $status
     * @return BaseResponse
     */
    public function setStatus(bool $status)
    {
        $this->status = $status;

        return $this;
    }
}
