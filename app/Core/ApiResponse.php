<?php

namespace App\Core;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ApiResponser
 *
 * @package App\Traits
 */
trait ApiResponse
{
    /**
     * @param string|array $message
     * @param array|object $data
     * @param int          $code
     * @param bool         $status
     *
     * @return JsonResponse
     */
    protected function baseResponse(bool $status, int $code, string|array $message, array|object $data = []): JsonResponse
    {
        $rs = [
            'status'      => $status,
            'code'        => $code,
            'message'     => $message,
        ];

        if ($status) {
            $rs['data'] = $data;
        }

        return response()->json($rs, $code);
    }

    /**
     * @param string $message
     * @param array|object  $data
     *
     * @return JsonResponse
     */
    protected function successResponse(string $message, array|object $data): JsonResponse
    {
        return $this->baseResponse(
            true,
            Response::HTTP_OK,
            $message,
            $data,
        );
    }

    /**
     * @param array|string $message
     * @param array        $data
     *
     * @return JsonResponse
     */
    protected function errorResponse(array|string $message, int $code): JsonResponse
    {
        return $this->baseResponse(
            false,
            $code,
            $message,
        );
    }

    /**
     * @param string $message
     * @param array|object  $data
     *
     * @return JsonResponse
     */
    protected function emptyDataResponse(string $message, array|object $data): JsonResponse
    {
        return $this->baseResponse(
            false,
            Response::HTTP_OK,
            $message,
            $data,
        );
    }
}
