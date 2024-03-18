<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Api\CareerController;
use App\Http\Controllers\Api\CaseStudyController;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\LeadController as ApiLeadController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\ServicesController;
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

// Route::middleware('auth:sanctum')->group(function () {
Route::controller(ApiLeadController::class)->group(function () {
    Route::group(["prefix" => "leads"], function ()
    {
        Route::post('create', 'create');
    });
}); 

Route::controller(CareerController::class)->group(function () {
    Route::group(["prefix" => "careers"], function ()
    {
        Route::get('/', 'index');
        Route::post('apply/{opening_id}', 'apply');
    });
});

Route::controller(ServicesController::class)->group(function () {
    Route::group(["prefix" => "services"], function ()
    {
        Route::get('/', 'index');
    });
});

Route::controller(BrandsController::class)->group(function () {
    Route::group(["prefix" => "brands"], function ()
    {
        Route::get('/', 'index');
    });
});

Route::controller(ProjectsController::class)->group(function () {
    Route::group(["prefix" => "projects"], function ()
    {
        Route::get('/', 'index');
        Route::get('/featured', 'featured');
    });
});

Route::controller(CaseStudyController::class)->group(function () {
    Route::group(["prefix" => "case-study"], function ()
    {
        Route::get('/', 'index');
        Route::get('/featured', 'featured');
    });
});

Route::controller(PublicationController::class)->group(function () {
    Route::group(["prefix" => "publications"], function ()
    {
        Route::get('/', 'index');
        Route::get('/{slug}', 'show');

    });
});
