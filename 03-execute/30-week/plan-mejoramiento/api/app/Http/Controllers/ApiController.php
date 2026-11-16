<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    protected function error(string $code, string $message, int $status, array $details = []): JsonResponse
    {
        return response()->json(compact('code', 'message', 'details'), $status);
    }
}
