<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GetApiDataController;

//サイトの紹介&年齢確認
Route::get('/', [MainController::class, 'welcomePage'])->name('welcomePage');
//サイトトップ（人気ランキングページ）
Route::get('/top', [MainController::class, 'topPage'])->name('topPage');
// マッチングページ
Route::get('/matching', [MainController::class, 'matchingPage'])->name('matchingPage');
// サンプルボタン押下時に、ターゲットのIDからそのデータの詳細を取得
Route::get('/get-sample-data-detail/{id}', [ApiController::class, 'getSampleTargetData'])->name('getSampleTargetData');
// マッチングの結果表示
Route::get('/result', [MainController::class, 'matchingResultApi'])->name('matchingResultApi');

//サイトの紹介&年齢確認
Route::get('/get/api/data/genre', [GetApiDataController::class, 'getAllApiData'])->name('getAllApiData');

require __DIR__.'/auth.php';
