<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ApiController;

//サイトの紹介&年齢確認
Route::get('/', [MainController::class, 'welcomePage'])->name('welcomePage');
//サイトトップ（人気ランキングページ）
Route::get('/top', [MainController::class, 'topPage'])->name('topPage');
// サンプルボタン押下時に、ターゲットのIDからそのデータの詳細を取得
Route::get('/get-sample-data-detail/{id}', [ApiController::class, 'getSampleTargetData'])->name('getSampleTargetData');


require __DIR__.'/auth.php';
