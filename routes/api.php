<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NavController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);

Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1');

Route::get('/site-settings', [SiteSettingsController::class, 'show']);
Route::get('/nav', [NavController::class, 'index']);
