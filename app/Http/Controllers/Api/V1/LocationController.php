<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Events\LocationServices;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $locationServices;
    public function __construct(LocationServices $locationServices)
    {
        $this->locationServices = $locationServices;
    }
    public function index(Request $request)
    {
        return $this->locationServices->getLocation();
    }
}
