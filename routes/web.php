<?php

use Inertia\Inertia;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CloakingController;
use App\Http\Controllers\JustOrangeController;
use App\Http\Controllers\TokenGeneratorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', action: [JustOrangeController::class , 'index']);
Route::get('/request-token/{type}',[TokenGeneratorController::class,'requestToken'])->middleware('auth');

Route::get('/token-generator' , [TokenGeneratorController::class,'index'])->middleware('auth');