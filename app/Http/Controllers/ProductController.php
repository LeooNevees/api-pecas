<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function __construct(Product $model, ProductService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
