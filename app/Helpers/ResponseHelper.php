<?php
declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    static function success(string $message , mixed $data = null, int $code = 200): JsonResponse
    {        
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ], $code);
    }
    static function fail(string $message , mixed $data = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ], $code);
    }
}
