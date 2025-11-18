<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::apiResource('members', MemberController::class);
Route::apiResource('books', BookController::class);

