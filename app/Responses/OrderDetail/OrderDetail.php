<?php

namespace App\Responses\OrderDetail;

class OrderDetail
{
    public const CHECKIN_SUCCESS = [
        'success' => true,
        'code' => 200,
        'message' => 'successfully',
    ];

    public const CHECKIN_FAILED = [
        'success' => false,
        'code' => 500,
        'message' => 'checkin failed',
    ];

    public const GET_ORDER_NOT_FOUND = [
        'success' => false,
        'code' => 500,
        'message' => 'data not found',
    ];

    public const GET_ORDER_SUCCESS = [
        'success' => true,
        'code' => 200,
        'message' => 'successfully',
    ];

    public const GET_ORDER_FAILED = [
        'success' => false,
        'code' => 400200001,
        'message' => 'checkin failed',
    ];
}
