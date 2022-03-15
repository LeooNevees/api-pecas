<?php

namespace App\Http\Controllers;

use App\Models\UnitOfMeasurement;
use App\Services\UnitOfMeasurementService;
use Illuminate\Http\Request;

class UnitOfMeasurementController extends BaseController
{
    public function __construct(UnitOfMeasurement $model, UnitOfMeasurementService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
