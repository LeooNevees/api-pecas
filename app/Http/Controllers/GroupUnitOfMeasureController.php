<?php

namespace App\Http\Controllers;

use App\Models\GroupUnitOfMeasure;
use App\Services\GroupUnitOfMeasureService;

class GroupUnitOfMeasureController extends BaseController
{
    public function __construct(GroupUnitOfMeasure $model, GroupUnitOfMeasureService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
