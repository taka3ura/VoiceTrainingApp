<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\UserController;
use App\Models\Reply;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

Route::controller(PostController::class)->middleware(['auth'])->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/posts/create', 'create')->name('create');
    Route::get('/posts/{post}', 'show')->name('show');
    Route::post('/posts', 'store')->name('store');
    Route::get('/posts/{post}/edit', 'edit');
    Route::put('/posts/{post}', 'update');
    Route::delete('/posts/{post}', 'delete');
});

Route::middleware('auth')->group(function () {
    // いいね/いいね解除のトグル機能（POSTリクエストでいいねを切り替える）
    Route::post('/posts/{post}/like', [LikeController::class, 'likePost'])->name('posts.like');
});

Route::controller(ReplyController::class)->middleware(['auth'])->group(function () {
    Route::post('posts/{post}/replies', 'store')->name('posts.replies.store');
    Route::delete('posts/{post}/replies/{reply}', 'destroy')->name('posts.replies.destroy');
});

require __DIR__ . '/auth.php';
