<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegionController;

// Region
Route::get('/region/list', [RegionController::class, 'index'])->name("get-list-region"); // index
Route::get('/region/add', [RegionController::class, 'formAdd'])->name("add-region"); // halaman create
Route::post('/region/process-add', [RegionController::class, 'processAdd'])->name("process-add-region"); // store
Route::get('/region/edit/{id}', [RegionController::class, 'formEdit'])->name("edit-region"); //  halaman edit
Route::post('/region/process-edit', [RegionController::class, 'processEdit'])->name("process-edit-region"); // update
Route::delete('/region/delete/{id}', [RegionController::class, 'processDelete'])->name("delete-region"); // hapus
