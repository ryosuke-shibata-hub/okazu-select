<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GetApiDataController;

//サイトの紹介&年齢確認
Route::get('/', [MainController::class, 'welcomePage'])
->name('welcomePage');
//サイトトップ（人気ランキングページ）
Route::get('/top', [MainController::class, 'topPage'])
->name('topPage');
// マッチングページ
Route::get('/matching', [MainController::class, 'matchingPage'])
->name('matchingPage');
// サンプルボタン押下時に、ターゲットのIDからそのデータの詳細を取得
Route::get('/get-sample-data-detail/{id}', [ApiController::class, 'getSampleTargetData'])
->name('getSampleTargetData');
//五十音から女優名を取得
Route::get('/get/api/actresses/{id}', [ApiController::class, 'getActressesByGroup'])
->name('getActressesByGroup');
// マッチングの結果表示
Route::get('/result', [MainController::class, 'matchingResultApi'])
->name('matchingResultApi');
//検索画面
Route::get('/search', [MainController::class, 'searchPage'])
->name('searchPage');
//ジャンル検索結果画面
Route::get('/search/result/genre/{id}/{name}',  [MainController::class, 'searchResultPageGenre'])
->name('searchResultPageGenre');
//女優検索結果画面
Route::get('/search/result/actress/detail/{id}/{name}',  [MainController::class, 'searchResultPageActress'])
->name('searchResultPageActress');
//女優検索結果画面
Route::get('/search/result/free-word/',  [MainController::class, 'searchResultPageFreeWord'])
->name('searchResultPageFreeWord');
//ヘルプページ
Route::get('/help' , [MainController::class, 'helpPage'])->name('helpPage');

//ジャンルをAPIから取得してDBに直接保存するルート
Route::get('/get/api/data/genre', [GetApiDataController::class, 'getAllApiData'])->name('getAllApiData');

require __DIR__.'/auth.php';
