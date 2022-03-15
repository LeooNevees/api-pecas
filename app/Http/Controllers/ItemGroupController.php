<?php

namespace App\Http\Controllers;

use App\Models\ItemGroup;
use App\Services\ItemGroupService;
use Illuminate\Http\Request;

class ItemGroupController extends BaseController
{
    public function __construct(ItemGroup $model, ItemGroupService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
