<?php

namespace App\Helpers;

class ResponseHelper
{
    public function successResponse($success, $message, $data)
    {
        return response()->json([
            'data' => [
                'success' => $success,
                'message' => $message,
                'data' => $data
            ]
        ]);
    }

    public function errorResponse($success, $message, $errorCode)
    {
        return response()->json([
            'data' => [
                'error' => [
                    'success' => $success,
                    'message' => $message
                ]
            ]
        ], $errorCode);
    }
}