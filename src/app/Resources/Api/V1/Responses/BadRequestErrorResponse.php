<?php

namespace App\Resources\Api\V1\Responses;

use Symfony\Component\HttpFoundation\Response;

class BadRequestErrorResponse extends ErrorResponse
{
    /**
     * @param array<int, mixed>|string $error
     * @param array<string, string> $headers
     * */
    public function __construct(array|string $error, array $headers = [], int $options = 0)
    {
        parent::__construct(
            $error,
            Response::HTTP_BAD_REQUEST,
            $headers,
            $options,
        );
    }
}
