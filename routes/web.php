<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;


// Main Page Route
Route::get('/', [Analytics::class, 'index'])->name('dashboard');


Route::get('/user/login', [auth::class, 'formLogin'])->name("login");
Route::post('/user/process-login', [auth::class, 'processLogin'])->name("process-login");
Route::get('/user/forgot-password', [auth::class, 'forgotPW'])->name("forgot-password");





Route::middleware('checkLogin')->group(function () {
  //user

  Route::get('/user/list', [auth::class, 'index'])->name("get-list-user");
  Route::get('/user/tambah-user', [auth::class, 'formDaftarUser'])->name("add-new-user");
  Route::post('/user/register', [auth::class, 'register'])->name("register");
  Route::get('/user/change-password', [auth::class, 'formChangePassword'])->name("change-password");
  Route::post('/user/process-changepw', [auth::class, 'changePw'])->name("process-changepw");
  Route::delete('/user/delete/{id}', [auth::class, 'deleteUser'])->name("delete-user");
  Route::post('/user/reset-pw/{id}', [auth::class, 'resetPw'])->name("reset-pw");
  Route::get('/user/logout', [auth::class, 'logout'])->name("logout");

  //master-data
  Route::get('/item/list', [MasterDataController::class, 'index'])->name("get-list-item");
  Route::get('/item/add', [MasterDataController::class, 'formAdd'])->name("add-item");
  Route::post('/item/process-add', [MasterDataController::class, 'processAdd'])->name("process-add-item");
  Route::get('/item/edit/{id}', [MasterDataController::class, 'formEdit'])->name("edit-item");
  Route::post('/item/process-edit', [MasterDataController::class, 'processEdit'])->name("process-edit-item");
  Route::delete('/item/delete/{id}', [MasterDataController::class, 'processDelete'])->name("delete-item");
  //report
  Route::get('/report/list', [ReportController::class, 'index'])->name("get-list-report");
  Route::get('/report/admin', [ReportController::class, 'showReportAdmin'])->name("get-list-report-admin");
  Route::get('/report/add', [ReportController::class, 'formAdd'])->name("add-report");
  Route::post('/report/process-add', [ReportController::class, 'processAdd'])->name("process-add-report");
  Route::delete('/report/delete/{id}', [ReportController::class, 'processDelete'])->name("delete-report");

  //stock
  Route::get('/report/stock/today', [ReportController::class, 'showHistoriStockToday'])->name("stock-today");
  Route::get('/report/stock/items', [ReportController::class, 'showStockPerItem'])->name("stock-items");
  Route::get('/report/stock/monthly', [ReportController::class, 'showHistoriStockMonthly'])->name("stock-monthly");
  Route::get('/report/stock/annual', [ReportController::class, 'showHistoriStockAnnual'])->name("stock-annual");
  Route::post('/filterData', [ReportController::class, 'filterData'])->name("filter-data-stock");
  Route::get('/stock/detail/today/{id}/{tanggal}/{jumlah}', [ReportController::class, 'detailReportToday'])->name("detail-stock-today");
});