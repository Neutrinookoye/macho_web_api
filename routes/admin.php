<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TestimonialController;

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


Route::group(['middleware' => 'admin_auth'], function()
{
    Route::get('dashboard', [AccountController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(EventController::class)->group(function () {
        Route::group(["prefix" => "events"], function ()
        {
            Route::get('/', 'index')->name('admin.event.index');
            Route::match(['GET', 'POST'], 'create', 'createEvent')->name('admin.event.create');
            Route::match(['GET', 'PATCH'], 'edit/{event_id}', 'editEvent')->name('admin.event.edit');
            Route::get('remove-event-image/{event_id}/{image_id}', 'removeImage')->name('admin.event.remove.image');
        });
    });

    Route::controller(BlogController::class)->group(function () {
        Route::group(["prefix" => "blogs"], function ()
        {
            Route::get('/', 'index')->name('admin.blog.index');
            Route::match(['GET', 'POST'], 'create', 'createBlog')->name('admin.blog.create');
            Route::match(['GET', 'PATCH'], 'edit/{blog_id}', 'editBlog')->name('admin.blog.edit');
        });
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::group(["prefix" => "categories"], function ()
        {
            Route::get('/', 'index')->name('admin.category.index');
            Route::post('create', 'createCategory')->name('admin.category.create');
            Route::put('edit/{category_id}', 'editCategory')->name('admin.category.edit');
        });
    });

    Route::controller(TeamController::class)->group(function () {
        Route::group(["prefix" => "teams"], function ()
        {
            Route::get('/', 'index')->name('admin.team.index');
            Route::post('create', 'createTeam')->name('admin.team.create');
            Route::put('edit/{team_id}', 'editTeam')->name('admin.team.edit');
        });
    });

    Route::controller(TestimonialController::class)->group(function () {
        Route::group(["prefix" => "testimonials"], function ()
        {
            Route::get('/', 'index')->name('admin.testimonial.index');
            Route::post('create', 'createTestimonial')->name('admin.testimonial.create');
            Route::put('edit/{testimonial_id}', 'editTestimonial')->name('admin.testimonial.edit');
        });
    });

    Route::controller(AchievementController::class)->group(function () {
        Route::group(["prefix" => "achievements"], function ()
        {
            Route::get('/', 'index')->name('admin.achievement.index');
            Route::post('create', 'createAchievement')->name('admin.achievement.create');
            Route::put('edit/{achievement_id}', 'editAchievement')->name('admin.achievement.edit');
        });
    });

    Route::controller(GalleryController::class)->group(function () {
        Route::group(["prefix" => "galleries"], function () {
            Route::get('', 'index')->name('admin.gallery.index');
            Route::match(['GET', 'POST'], 'create-gallery', 'createGallery')->name('admin.gallery.create');
            Route::match(['GET', 'POST'], 'edit/{gallery_id}', 'editGallery')->name('admin.gallery.edit');
            Route::get('remove-gallery-image/{gallery_id}/{image_id}', 'removeImage')->name('admin.gallery.remove.image');
            // Route::get('delete/{gallery_id}', 'deleteGallery')->name('admin.gallery.delete');
            Route::get('delete-file/{file_id}', 'deleteGalleryFile')->name('admin.gallery.delete.file');
            Route::get('mark-file-preview/{file_id}', 'markGalleryFileAsPreview')->name('admin.gallery.file.preview');
        });
    });
});

