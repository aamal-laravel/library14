<?php

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;

function apiSuccess(string $message = null, mixed $data = null, int $code = 200): JsonResponse
{
    $message =   $message ?? __('library.success');
    return ResponseHelper::success($message, $data, $code);
}
function apiFail(string $message =null, mixed $data = null, int $code = 400): JsonResponse
{
    $message =   $message ?? __('library.failed');
    return ResponseHelper::fail($message, $data, $code);
}
