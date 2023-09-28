<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SertifikatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(BerandaController::class)->group(function(){
    Route::get('/beranda','beranda')->middleware('guest');
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::controller(PortfolioController::class)->group(function(){
        Route::post('/portofolio','storePortfolio');
        Route::get('/portofolio','getPortfolio');
        Route::delete('/portofolio','deletePortFolio');
    });
    
    Route::controller(SertifikatController::class)->group(function(){
        Route::post('/sertifikat','storeSertifikat');
    });
    
    Route::controller(LoginController::class)->group(function(){
        Route::post('/login','login')->middleware('guest');
        Route::post('/registrasi','registrasi')->middleware('guest');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'me');
    });
});

// Route::middleware('api')->prefix('auth')->group(function(){
// });

