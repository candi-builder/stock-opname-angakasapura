<?php

use App\Http\Controllers\auth;
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
Route::post('/user/delete/{id}', [auth::class, 'register'])->name("delete-user");
Route::post('/user/reset-pw/{id}', [auth::class, 'resetPw'])->name("reset-pw");
