<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Services\DepositService;
use Illuminate\Http\Request;

class DepositController extends BaseController
{
    public function __construct(Deposit $model, DepositService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
