<?php

namespace App\Responses;

class CheckinResponse
{
    public const CHECKIN_SUCCESS = [
        'success' => true,
        'code' => 200200001,
        'message' => 'checkin success',
    ];

    public const CHECKIN_FAILED = [
        'success' => false,
        'code' => 400200001,
        'message' => 'checkin failed',
    ];

}
