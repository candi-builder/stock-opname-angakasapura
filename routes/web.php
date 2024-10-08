<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\BatasanStockStationController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MaterialGroupController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Models\BatasanStockStation;

// Main Page Route



Route::get('/user/login', [auth::class, 'formLogin'])->name("login");
Route::post('/user/process-login', [auth::class, 'processLogin'])->name("process-login");
Route::get('/user/forgot-password', [auth::class, 'forgotPW'])->name("forgot-password");

Route::middleware('checkLogin')->group(function () {
  //user
  Route::get('/', [Analytics::class, 'index'])->name('dashboard');
  Route::get('/user/list', [auth::class, 'index'])->name("get-list-user");
  Route::get('/user/tambah-user', [auth::class, 'formDaftarUser'])->name("add-new-user");
  Route::post('/user/register', [auth::class, 'register'])->name("register");
  Route::get('/user/change-password', [auth::class, 'formChangePassword'])->name("change-password");
  Route::post('/user/process-changepw', [auth::class, 'changePw'])->name("process-changepw");
  Route::delete('/user/delete/{id}', [auth::class, 'deleteUser'])->name("delete-user");
  Route::post('/user/reset-pw/{id}', [auth::class, 'resetPw'])->name("reset-pw");
  Route::get('/user/logout', [auth::class, 'logout'])->name("logout");
  //   Route::get('/user/list', [auth::class, 'search'])->name("get-list-user");

  //master-data
  Route::get('/item/list', [MasterDataController::class, 'index'])->name("get-list-item");
  Route::get('/item/add', [MasterDataController::class, 'formAdd'])->name("add-item");
  Route::post('/item/process-add', [MasterDataController::class, 'processAdd'])->name("process-add-item");
  Route::get('/item/edit/{id}', [MasterDataController::class, 'formEdit'])->name("edit-item");
  Route::post('/item/process-edit', [MasterDataController::class, 'processEdit'])->name("process-edit-item");
  Route::delete('/item/delete/{id}', [MasterDataController::class, 'processDelete'])->name("delete-item");
  Route::get('/item/list', [MasterDataController::class, 'search'])->name("get-list-item");

  //report
  Route::get('/report/list', [ReportController::class, 'index'])->name("get-list-report");
  Route::get('/report/admin', [ReportController::class, 'showReportAdmin'])->name("get-list-report-admin");
  Route::get('/report/add', [ReportController::class, 'formAdd'])->name("add-report");
  Route::post('/report/process-add', [ReportController::class, 'processAdd'])->name("process-add-report");
  Route::delete('/report/delete/{id}', [ReportController::class, 'processDelete'])->name("delete-report");
  //   Route::get('/report/list', [ReportController::class, 'search'])->name("get-list-report");

  //stock
  Route::get('/report/stock/today', [ReportController::class, 'showHistoriStockToday'])->name("stock-today");
  Route::get('/report/stock/items', [ReportController::class, 'showStockPerItem'])->name("stock-items");
  Route::get('/report/stock/monthly', [ReportController::class, 'showHistoriStockMonthly'])->name("stock-monthly");
  Route::get('/report/stock/monthly/export_excel', [ReportController::class, 'monthlyExportExcel'])->name("stock-monthly-export-excel");
  Route::get('/report/stock/detail/monthly/export_excel/{id}', [ReportController::class, 'detailMonthlyExportExcel'])->name("stock-detail-monthly-export-excel");
  Route::get('/report/stock/annual', [ReportController::class, 'showHistoriStockAnnual'])->name("stock-annual");
  Route::post('/filterData', [ReportController::class, 'filterData'])->name("filter-data-stock");
  Route::get('/stock/detail/today/{id}/{tanggal}/{jumlah}', [ReportController::class, 'detailReport'])->name("detail-stock-today");
  //   Route::get('/report/stock/today', [ReportController::class, 'search'])->name("stock-today");

  // regions
  Route::get('/region/list', [RegionController::class, 'index'])->name("get-list-region");
  Route::post('/region/process-add', [RegionController::class, 'processAdd'])->name("process-add-region");
  Route::get('/region/edit/{id}', [RegionController::class, 'formEdit'])->name("edit-region");
  Route::post('/region/process-edit', [RegionController::class, 'processEdit'])->name("process-edit-region");
  Route::delete('/region/delete/{id}', [RegionController::class, 'processDelete'])->name("delete-region");
  Route::get('region/list', [RegionController::class, 'search'])->name('get-list-region');

  // station
  Route::get('/station/list', [StationController::class, 'index'])->name("get-list-station");
  Route::post('station/process-add', [StationController::class, "processAdd"])->name("process-add-station");
  Route::get('/station/edit/{id}', [StationController::class, 'formEdit'])->name("edit-station");
  Route::post('/station/process-edit', [StationController::class, 'processEdit'])->name("process-edit-station");
  Route::delete('/station/delete/{id}', [StationController::class, 'processDelete'])->name("delete-station");
  Route::get('/station/list', [StationController::class, 'search'])->name("get-list-station");

  // uom
  Route::get('/uom/list', [UomController::class, 'index'])->name("get-list-uom");
  Route::post('/uom/process-add', [UomController::class, 'processAdd'])->name("process-add-uom");
  Route::get('/uom/edit/{id}', [UomController::class, 'formEdit'])->name("edit-uom");
  Route::post('/uom/process-edit', [UomController::class, 'processEdit'])->name("process-edit-uom");
  Route::delete('/uom/delete/{id}', [UomController::class, 'processDelete'])->name("delete-uom");
  Route::get('/uom/list', [UomController::class, 'search'])->name('get-list-uom');

  // material-goup
  Route::get('/material-group/list', [MaterialGroupController::class, 'index'])->name('get-list-material-group');
  Route::post('/material-group/process-add', [MaterialGroupController::class, 'processAdd'])->name('process-add-material-group');
  Route::get('/material-group/edit/{id}', [MaterialGroupController::class, 'formEdit'])->name('edit-material-group');
  Route::post('/material-group/process-edit', [MaterialGroupController::class, 'processEdit'])->name('process-edit-material-group');
  Route::delete('/material-group/delete/{id}', [MaterialGroupController::class, 'processDelete'])->name('delete-material-group');
  Route::get('/material-group/list', [MaterialGroupController::class, 'search'])->name('get-list-material-group');

  // batasan-stock
  Route::get('/batasan-stock', [BatasanStockStationController::class, 'index'])->name("list-batasan-stock-station");
  Route::get('/batasan-stock/form-add-batasan-stock', [BatasanStockStationController::class, 'formAddBatasanStock'])->name("add-report-batasan-stock-station");
  Route::post('/batasan-stock/process-add-batasan-stock', [BatasanStockStationController::class, 'processAddBatasanStock'])->name("process-add-batasan-stock-station");
  Route::get('/batasan-stock/form-edit-batasan-stock/{id}', [BatasanStockStationController::class, 'formEditBatasanStock'])->name('form-edit-batasan-stock-station');
  Route::post('/batasan-stock/process-edit-batasan-stock', [BatasanStockStationController::class, 'processEditBatasanStock'])->name('process-edit-batasan-stock-station');
  Route::delete('/batasan-stock/delete/{id}', [BatasanStockStationController::class, 'processDelete'])->name('process-delete-batasan-stock-station');
});
