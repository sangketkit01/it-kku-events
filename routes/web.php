<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Group;

Route::get('/', [UserController::class, 'index'])->name('index');

Route::get('/sign_in', [UserController::class, "sign_in"])->name('sign_in');
Route::post('/sign_in/check', [UserController::class, 'sign_in_check'])->name('sign_in_check');
Route::get('sign_out', [UserController::class, 'sign_out'])->name('sign_out');

Route::get('/vote/{event}', [UserController::class, "vote"])->name('vote');
Route::get('/vote/{event}/{id}/check', [UserController::class, "vote_check"])->name('vote_check');
Route::get('/vote/{event}/list', [UserController::class, "vote_list"])->name('vote_list');
Route::get('/vote/{event}/detail/{id}', [UserController::class, "vote_detail"])->name('vote_detail');

Route::get("/check", [UserController::class, "check"])->name('check');
Route::post('/it/check/{email}', [UserController::class, "it_check"])->name('it_check');
Route::get('/again',[UserController::class,'again'],'again')->name('again');

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);



