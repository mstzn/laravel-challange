<?php

namespace App\Http\Traits;

trait ApiResponseTrait
{
    public function createResponse(bool $status, array $data = [], $message = ''): array
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => is_array($message) ? reset($message) : $message
        ];
    }
}
