<?php

use App\Http\Controllers\BackupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\InvoiceListController;
use App\Http\Controllers\api\AdminsController;
use App\Http\Controllers\api\ConfigsController;
use App\Http\Controllers\api\InvoiceLogsController;
use App\Http\Controllers\api\ProductListController;
use App\Http\Controllers\api\SettingsController;
use App\Http\Controllers\api\UsersController;

Route::middleware(['auth:api'])->group(function () {
  // Route::apiResource('invoice-logs', InvoiceLogsController::class);
  Route::get('/user-names', [AdminsController::class, 'listUserNames']);
  Route::delete('/users/remove-expired', [AdminsController::class, 'removeExpiredUsers']);
  Route::apiResource('admins', AdminsController::class);
  Route::get('/admins', [AdminsController::class, 'index']);
  Route::delete('/admins/{id}', [AdminsController::class, 'destroy']);

  Route::apiResource('configs', ConfigsController::class);
  Route::get('/backups', [BackupController::class, 'list']);
  Route::get('/configs', [ConfigsController::class, 'index']);
  Route::post('/configs', [ConfigsController::class, 'create']);
  Route::delete('/configs/{id}', [ConfigsController::class, 'destroy']);

});
Route::get('/', [SettingsController::class, 'main']);
Route::get('/settings', [SettingsController::class, 'index']);
Route::post('/user/login', [UsersController::class, 'login']);


Route::middleware(['auth:usrapi'])->group(function () {
  Route::get('/user', [UsersController::class, 'user']);
  Route::get('/user/configs', [UsersController::class, 'configs']);
  Route::get('/user/settings', [UsersController::class, 'settings']);
  Route::get('/user/logout', [UsersController::class, 'logout']);
});


