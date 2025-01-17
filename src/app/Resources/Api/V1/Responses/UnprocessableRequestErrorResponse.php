<?php

namespace App\Resources\Api\V1\Responses;

use Symfony\Component\HttpFoundation\Response;

class UnprocessableRequestErrorResponse extends ErrorResponse
{
    /**
     * @param array<string, mixed>|string $error
     * @param array<string, string> $headers
     * */
    public function __construct(array|string $error, array $headers = [], int $options = 0)
    {
        parent::__construct(
            phrase($error),
            Response::HTTP_BAD_REQUEST,
            $headers,
            $options,
        );
    }
}
