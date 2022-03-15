<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;

class UserController extends BaseController
{
    public function __construct(User $model, UserService $service) {
        $this->model = $model;
        $this->service = $service;
    }
}
