<?php

namespace App\Repositories;
use App\Interfaces\CheckinInterface;
use App\Models\CheckIn;

class CheckinRepository implements CheckinInterface
{
    public function checkin($data)
    {
        return CheckIn::create($data);
    }
}
