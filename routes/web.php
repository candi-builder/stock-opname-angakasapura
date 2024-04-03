<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;


// Main Page Route
Route::get('/', [Analytics::class, 'index'])->name('dashboard');

//user
Route::get('/user/list', [auth::class, 'index'])->name("get-list-user");
Route::get('/user/tambah-user', [auth::class, 'formDaftarUser'])->name("add-new-user");
Route::post('/user/register', [auth::class, 'register'])->name("register");
Route::get('/user/login', [auth::class, 'formLogin'])->name("login");
Route::post('/user/process-login', [auth::class, 'processLogin'])->name("process-login");
Route::get('/user/forgot-password', [auth::class, 'forgotPW'])->name("forgot-password");
Route::get('/user/change-password', [auth::class, 'formChangePassword'])->name("change-password");
Route::post('/user/process-changepw', [auth::class, 'changePw'])->name("process-changepw");
Route::delete('/user/delete/{id}', [auth::class, 'deleteUser'])->name("delete-user");
Route::post('/user/reset-pw/{id}', [auth::class, 'resetPw'])->name("reset-pw");

//master-data
Route::get('/item/list', [MasterDataController::class, 'index'])->name("get-list-item");
Route::get('/item/add', [MasterDataController::class, 'formAdd'])->name("add-item");
Route::post('/item/process-add', [MasterDataController::class, 'processAdd'])->name("process-add-item");
Route::get('/item/edit/{id}', [MasterDataController::class, 'formEdit'])->name("edit-item");
Route::post('/item/process-edit', [MasterDataController::class, 'processEdit'])->name("process-edit-item");
Route::delete('/item/delete/{id}', [MasterDataController::class, 'processDelete'])->name("delete-item");

// regions
Route::get('/region/list', [RegionController::class, 'index'])->name("get-list-region"); 
Route::post('/region/process-add', [RegionController::class, 'processAdd'])->name("process-add-region"); 
Route::get('/region/edit/{id}', [RegionController::class, 'formEdit'])->name("edit-region");
Route::post('/region/process-edit', [RegionController::class, 'processEdit'])->name("process-edit-region"); 
Route::delete('/region/delete/{id}', [RegionController::class, 'processDelete'])->name("delete-region");

// station
Route::get('/station/list', [StationController::class, 'index'])->name("get-list-station");
Route::post('station/process-add', [StationController::class,"processAdd"])->name("process-add-station");
Route::get('/station/edit/{id}', [StationController::class, 'formEdit'])->name("edit-station");
Route::post('/station/process-edit', [StationController::class, 'processEdit'])->name("process-edit-station"); 
Route::delete('/station/delete/{id}', [StationController::class, 'processDelete'])->name("delete-station");

// uom
Route::get('/uom/list', [UomController::class, 'index'])->name("get-list-uom");
Route::post('/uom/process-add', [UomController::class, 'processAdd'])->name("process-add-uom");
Route::get('/uom/edit/{id}', [UomController::class, 'formEdit'])->name("edit-uom");
Route::post('/uom/process-edit', [UomController::class, 'processEdit'])->name("process-edit-uom");
Route::delete('/uom/delete/{id}', [UomController::class, 'processDelete'])->name("delete-uom");