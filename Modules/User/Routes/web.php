<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth'])->prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
    Route::get('/listing', [Modules\User\Http\Controllers\User\UserController::class, 'index'])->name('user.listing');
    Route::get('/ajaxListing', [Modules\User\Http\Controllers\User\UserController::class, 'ajaxListing'])->name('user.ajaxListing');
    Route::get('/create', [Modules\User\Http\Controllers\User\UserController::class, 'create'])->name('user.create');
    Route::post('/register', [Modules\User\Http\Controllers\User\UserController::class, 'store'])->name('user.register');
    Route::get('/view', [Modules\User\Http\Controllers\User\UserController::class, 'show'])->name('user.view');
    Route::get('/edit', [Modules\User\Http\Controllers\User\UserController::class, 'edit'])->name('user.edit');
    Route::post('/update', [Modules\User\Http\Controllers\User\UserController::class, 'update'])->name('user.update');


    Route::get('/roles', [Modules\User\Http\Controllers\User\RoleController::class, 'index'])->name('role.listing');
    Route::get('/createRole', [Modules\User\Http\Controllers\User\RoleController::class, 'create'])->name('create.role');
    Route::post('/storeRole', [Modules\User\Http\Controllers\User\RoleController::class, 'store'])->name('role.store');
    Route::get('/edit/role/{id}', [Modules\User\Http\Controllers\User\RoleController::class, 'edit']);
    Route::post('/update/role/{id}', [Modules\User\Http\Controllers\User\RoleController::class, 'update']);
    Route::post('/roles/{role}/permission', [Modules\User\Http\Controllers\User\RoleController::class, 'givePermission'])->name('admin.roles.permissions');
    Route::post('/admin/roles/{role}/{permission}', [Modules\User\Http\Controllers\User\RoleController::class, 'revokePermission']);


    Route::get('/permission', [Modules\User\Http\Controllers\User\PermissionController::class, 'index'])->name('permission.listing');
    Route::get('/createPermission', [Modules\User\Http\Controllers\User\PermissionController::class, 'create'])->name('create.permission');
    Route::post('/storePermission', [Modules\User\Http\Controllers\User\PermissionController::class, 'store'])->name('permission.store');
    Route::get('/edit/permission/{id}', [Modules\User\Http\Controllers\User\PermissionController::class, 'edit']);
    Route::post('/update/permission/{id}', [Modules\User\Http\Controllers\User\PermissionController::class, 'update']);
    Route::post('/permissions/{permission}/role', [Modules\User\Http\Controllers\User\PermissionController::class, 'giveRole'])->name('admin.permissions.roles');
    Route::post('/admin/permissions/{permission}/{role}', [Modules\User\Http\Controllers\User\PermissionController::class, 'revokeRole']);


    






});
