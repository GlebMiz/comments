<?php

use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
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

Route::get('/', [CommentsController::class, 'list'])->name('home');
Route::post('comments/add', [CommentsController::class, 'store'])->name('comment.add');
Route::get('/captha',[CaptchaController::class,'get'])->name('captha.get');
