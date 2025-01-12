<?php

use App\Http\Controllers\LargeExcelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/export-large-excel-1', [LargeExcelController::class, 'exportLargeExcel']);
Route::get('/download-large-excel-1', [LargeExcelController::class, 'downloadLargeExcel']);
