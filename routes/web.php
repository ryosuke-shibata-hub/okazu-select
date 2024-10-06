<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ApiController;

//サイトの紹介&年齢確認
Route::get('/', [MainController::class, 'welcomePage'])->name('welcomePage');
//サイトトップ（人気ランキングページ）
Route::get('/top', [MainController::class, 'topPage'])->name('topPage');
// サンプル画像の取得用ルート
Route::get('/get-sample-img/{id}', [ApiController::class, 'getSampleImg'])->name('getSampleImg');


require __DIR__.'/auth.php';
