<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WorshipPlaceController;
use App\Http\Controllers\ActivityTemplateController;
use App\Http\Controllers\ParameterActivityTemplateController;
use App\Http\Controllers\DetailWorshipTemplateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'index']);

Route::resource('/worship-place', WorshipPlaceController::class);
Route::resource('/worship-place/{id_worship_place}/activity', DetailWorshipTemplateController::class);
Route::resource('/activity-template', ActivityTemplateController::class);
Route::resource('/activity-template/{id_activity_template}/parameter', ParameterActivityTemplateController::class);

