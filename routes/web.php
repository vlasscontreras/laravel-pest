<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\RepositoryController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('repositories', RepositoryController::class)->middleware('auth');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('{repository}', [PageController::class, 'repository'])->name('repository');
