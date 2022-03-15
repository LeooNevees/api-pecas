<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\Request;

class BranchController extends BaseController
{
    public function __construct(Branch $model, BranchService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
