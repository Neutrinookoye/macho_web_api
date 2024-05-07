<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PublicationController;

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

    Route::controller(AdminController::class)->group(function () {
        Route::group(["prefix" => "admin"], function ()
        {
            Route::get('/index', 'index')->name('admin.users.admins');
            Route::post('create-admin', 'createAdmin')->name('admin.admins.create');
            Route::put('edit-admin/{user_id}', 'updateAdmin')->name('admin.admins.edit');
            // Route::delete('delete-admin/{user_id}', 'deleteAdmin')->name('admin.admins.delete');
        });
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::group(["prefix" => "permissions"], function ()
        {
            Route::get('/', 'index')->name('admin.permissions.index');
            Route::post('create', 'createPermission')->name('admin.permissions.create');
            Route::put('edit/{permission_id}', 'updatePermission')->name('admin.permissions.edit');
            // Route::put('delete-permission', 'deletePermission')->name('admin.permissions.delete');
        });
    });
    
    Route::controller(RoleController::class)->group(function () {
        Route::group(["prefix" => "roles"], function ()
        {
            Route::get('/', 'index')->name('admin.roles.index');
            Route::post('create', 'createRole')->name('admin.roles.create');
            Route::put('edit/{role_id}', 'updateRole')->name('admin.roles.edit');
            // Route::put('delete-role', 'deleteRole')->name('admin.roles.delete');
        });
    });

    Route::controller(LeadController::class)->group(function () {
        Route::group(["prefix" => "leads"], function ()
        {
            Route::get('/', 'index')->name('admin.lead.index');
            Route::get('export-leads', 'exportLead')->name('admin.leads.export');
        });
    });

    Route::controller(CareerController::class)->group(function () {
        Route::group(["prefix" => "careers"], function ()
        {
            Route::get('/', 'index')->name('admin.career.index');
            Route::match(['GET', 'POST'], 'create-opening', 'createOpening')->name('admin.career.create');
            Route::get('show-applications/{opening_id}', 'showApplication')->name('admin.career.show');
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

    Route::controller(PublicationController::class)->group(function () {
        Route::group(["prefix" => "publications"], function ()
        {
            Route::get('/', 'index')->name('admin.publication.index');
            Route::match(['GET', 'POST'], 'create', 'createPublication')->name('admin.publication.create');
            Route::match(['GET', 'PATCH'], 'edit/{publication_id}', 'editPublication')->name('admin.publication.edit');
        });
    });

    Route::controller(BrandController::class)->group(function () {
        Route::group(["prefix" => "brands"], function ()
        {
            Route::get('/', 'index')->name('admin.brand.index');
            Route::post('create', 'createBrand')->name('admin.brand.create');
            Route::put('edit/{brand_id}', 'editBrand')->name('admin.brand.edit');
        });
    });

    Route::controller(ServiceController::class)->group(function () {
        Route::group(["prefix" => "services"], function ()
        {
            Route::get('/', 'index')->name('admin.service.index');
            Route::post('create', 'createService')->name('admin.service.create');
            Route::put('edit/{service_id}', 'editService')->name('admin.service.edit');
        });
    });

    Route::controller(ProjectController::class)->group(function () {
        Route::group(["prefix" => "projects"], function ()
        {
            Route::get('/', 'index')->name('admin.project.index');
            Route::match(['GET', 'POST'], 'create', 'createProject')->name('admin.project.create');
            Route::match(['GET', 'PATCH'], 'edit/{project_id}', 'editProject')->name('admin.project.edit');
            Route::get('remove-project-image/{project_id}/{image_id}', 'removeImage')->name('admin.project.remove.image');
        });
    });

    Route::controller(CaseStudyController::class)->group(function () {
        Route::group(["prefix" => "case-studies"], function ()
        {
            Route::get('/', 'index')->name('admin.case.studies.index');
            Route::match(['GET', 'POST'], 'create', 'createCaseStudy')->name('admin.case.studies.create');
            Route::match(['GET', 'PATCH'], 'edit/{casestudies_id}', 'editCaseStudy')->name('admin.case.studies.edit');
            // Route::get('remove-project-image/{project_id}/{image_id}', 'removeImage')->name('admin.project.remove.image');
        });
    });
    
});

