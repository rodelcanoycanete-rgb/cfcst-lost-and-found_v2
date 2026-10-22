<?php

use App\Http\Controllers\Api\ItemApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Internal RESTful API for Item Record Management
Route::apiResource('items', ItemApiController::class);