<?php

namespace App\Responses;

class ServerResponse
{
    public const INTERNAL_SERVER_ERROR = [
        'success' => false,
        'code' => '500',
        'message' => 'Internal Server Error',
    ];
    public const SUCCESS_RESPONSE = [
        'success' => false,
        'code' => '200',
        'message' => 'Successfully',
    ];

    public const UNAUTHORIZED = [
        'success' => false,
        'code' => '401',
        'message' => 'Unauthorized',
    ];

    public const FORBIDDEN = [
        'success' => false,
        'code' => '403100001',
        'message' => 'Forbidden',
    ];

    public const NOT_FOUND = [
        'success' => false,
        'code' => '404',
        'message' => 'Not Found',
    ];

    public const METHOD_NOT_ALLOWED = [
        'success' => false,
        'code' => '405',
        'message' => 'Method Not Allowed',
    ];

    public const UNPROCESSABLE_ENTITY = [
        'success' => false,
        'code' => '422',
        'message' => 'Unprocessable Entity',
    ];

    public const TOO_MANY_REQUESTS = [
        'success' => false,
        'code' => '429',
        'message' => 'Too Many Requests',
    ];

    public const VALIDATION = [
        'success' => false,
        'code' => '400',
        'message' => 'Request input is not valid',
    ];
}
