<?php

use App\Http\Controllers\ReadInboxController;
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
Route::get('/confirm-order' , [JustOrangeController::class,'confirmOrderIndex'])->name('confirm-order-index');
Route::get('/confirm-order/{id}', [JustOrangeController::class, 'confirmOrder'])->name('confirm-order');
Route::post('/confirm-order', [JustOrangeController::class, 'storeOrder'])->name('confirm-order.store');
Route::post('/request-token',[TokenGeneratorController::class,'requestToken'])->middleware('auth');

Route::get('/token-generator' , [TokenGeneratorController::class,'index'])->middleware('auth');

Route::get('/inbox/{pid}' , [ReadInboxController::class , 'index'])->middleware('auth');Route::get('/inbox/fetch/{pid}' , [ReadInboxController::class , 'fetchEmails'])->middleware('auth');
