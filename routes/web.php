<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tweet\LikeController;

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

// Tweet
Route::get('/tweet', \App\Http\Controllers\Tweet\IndexController::class) // つぶやき一覧
    ->name('tweet.index');
Route::middleware('auth')->group(function () { // ログインしているユーザーのみアクセス可能
    Route::post('/tweet/create', \App\Http\Controllers\Tweet\CreateController::class) // つぶやき作成
        ->name('tweet.create');
    Route::get('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\IndexController::class) // つぶやき更新フォーム
        ->name('tweet.update.index')
        ->where('tweetId', '[0-9]+'); // つぶやきIDは数字のみ
    Route::put('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\PutController::class) // つぶやき更新
        ->name('tweet.update.put')
        ->where('tweetId', '[0-9]+'); // つぶやきIDは数字のみ
    Route::delete('/tweet/delaete/{tweetId}', \App\Http\Controllers\Tweet\DeleteController::class) // つぶやき削除
        ->name('tweet.delete')
        ->where('tweetId', '[0-9]+'); // つぶやきIDは数字のみ
    Route::post('/retweet/{originalTweetId}/create', \App\Http\Controllers\Tweet\RetweetCreateController::class) // リツイート
        ->name('retweet.create')
        ->where('originalTweetId', '[0-9]+'); // つぶやきIDは数字のみ

    Route::post('/tweet/{tweet}/like', [LikeController::class, 'store'])->name('tweet.like');
    Route::delete('/tweet/{tweet}/unlike', [LikeController::class, 'destroy'])->name('tweet.unlike');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
