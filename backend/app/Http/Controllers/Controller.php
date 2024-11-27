<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data, int $code = 200): JsonResponse {
        return response()->json($data, $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, int $code = 404): JsonResponse {
        return response()->json(['error' => $message], $code);
    }
}
