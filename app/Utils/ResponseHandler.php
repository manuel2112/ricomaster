<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class ResponseHandler
{
    public static function success($data = null, $message = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], 200);
    }

    public static function error($message, $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $message,
        ], $code);
    }
}
