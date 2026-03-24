<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success($data = [], string $message = "Opération réussie", int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ], $code);
    }
    protected function error(string $message = "Erreur", $errors = [], int $code = 422): JsonResponse
    {
        return response()->json([
            'success' => false,
            'errors'  => $errors,
            'message' => $message,
        ], $code);
    }
}