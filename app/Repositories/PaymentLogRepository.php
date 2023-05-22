<?php

namespace App\Repositories;

use App\Interfaces\PaymentLogInterface;
use App\Models\PaymentLog;

class PaymentLogRepository implements PaymentLogInterface
{
    public function createPaymentLog($data)
    {
        return PaymentLog::create($data);
    }
}
