<?php

use App\Http\Controllers\Api\v1\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/test', [CompanyController::class, 'add1']);
    Route::get('/company/{edrpou}/versions', [CompanyController::class, 'getCompanyVersions']);
    Route::post('/company', [CompanyController::class, 'add']);
});


