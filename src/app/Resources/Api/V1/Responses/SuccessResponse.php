<?php

namespace App\Resources\Api\V1\Responses;

use Illuminate\Http\JsonResponse;

class SuccessResponse extends JsonResponse
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $headers
     * */
    public function __construct(
        string $message,
        array $data = [],
        int $status = 200,
        array $headers = [],
        int $options = 0,
    ) {
        parent::__construct(
            [
                'status' => 'success',
                'message' => phrase($message),
                'content' => $data,
            ],
            $status,
            $headers,
            $options,
        );
    }
}
