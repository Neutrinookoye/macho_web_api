<?php

use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TestimonialController;
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

Route::middleware('throttle:api')->group(function () {

    Route::controller(EventController::class)->group(function () {
        Route::group(["prefix" => "events"], function ()
        {
            Route::get('/', 'index');
            Route::get('/featured-events', 'featured');
            Route::get('/{slug}', 'show');
        });
    });

    Route::controller(BlogController::class)->group(function () {
        Route::group(["prefix" => "blogs"], function ()
        {
            Route::get('/', 'index');
            Route::get('/featured-blogs', 'featured');
            Route::get('/{slug}', 'show');
        });
    });

    Route::controller(TeamController::class)->group(function () {
        Route::group(["prefix" => "team"], function ()
        {
            Route::get('/', 'index');
            Route::get('/{slug}', 'show');
        });
    });

    Route::controller(GalleryController::class)->group(function () {
        Route::group(["prefix" => "galleries"], function ()
        {
            Route::get('/', 'index');
            Route::get('/{slug}', 'show');
        });
    });

    Route::controller(TestimonialController::class)->group(function () {
        Route::group(["prefix" => "testimonials"], function ()
        {
            Route::get('/', 'index');
            Route::get('/{slug}', 'show');
        });
    });

    Route::controller(AchievementController::class)->group(function () {
        Route::group(["prefix" => "achievements"], function ()
        {
            Route::get('/', 'index');
            Route::get('/{slug}', 'show');
        });
    });
});

