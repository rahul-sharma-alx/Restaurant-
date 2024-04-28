<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/upload', [UploadController::class, 'create'])->name('upload.create');
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');
Route::post('/upload{id}', [UploadController::class, 'update'])->name('upload.update');

Route::get('/food/list', [UploadController::class, 'show'])->middleware(['auth', 'verified'])->name('food.list');
Route::get('/food/trash', [UploadController::class, 'trash'])->name('move.trash');
Route::get('search_food',[UploadController::class, 'search'])->name('search_food');
Route::get('edit/{id}', [UploadController::class, 'edit']);
Route::delete('food/{id}', [UploadController::class, 'destroy']);
Route::get('short/{t}',[UploadController::class, 'short']);


require __DIR__.'/auth.php';
