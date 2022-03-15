<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockController extends BaseController
{
    public function __construct(Stock $model, StockService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
