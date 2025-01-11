<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GetApiDataController;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\AgeVerification;
use App\Http\Controllers\Recommend\RecommendController;

//年齢確認情報をsessionへ保存する
Route::post('/confirm-age', function () {
    Session::put('age_verified', true); // セッションに情報を保存
    return redirect('/top'); // トップページにリダイレクト
})->name('age_verified');
//サイトの紹介&年齢確認
Route::get('/', [MainController::class, 'welcomePage'])
->name('welcomePage');
// お知らせ一覧
Route::get('/infomation', [MainController::class, 'infomationPage'])
->name('infomationPage');
// お知らせ詳細
Route::get('/infomation/{id}', [MainController::class, 'infomationDetailPage'])
->name('infomationDetailPage');

Route::middleware(AgeVerification::class)->group(function () {
    //サイトトップ（人気ランキングページ）
    Route::get('/top', [MainController::class, 'topPage'])
    ->name('topPage');
    //おすすめページ
    Route::get('/recommendation', [RecommendController::class, 'recommendList'])
    ->name('recommendList');
    //おすすめの記事詳細
    Route::get('/recommend/detail/{title}', [RecommendController::class, 'recommendDetail'])
    ->name('recommendDetail');
    // マッチングページ
    Route::get('/matching', [MainController::class, 'matchingPage'])
    ->name('matchingPage');
    // サンプルボタン押下時に、ターゲットのIDからそのデータの詳細を取得
    Route::get('/get-sample-data-detail/{id}', [ApiController::class, 'getSampleTargetData'])
    ->name('getSampleTargetData');
    //五十音から女優名を取得
    Route::get('/get/api/actresses/{id}', [ApiController::class, 'getActressesByGroup'])
    ->name('getActressesByGroup');
    //五十音からメーカーを取得
    Route::get('/get/api/maker/{id}', [ApiController::class, 'getMakerByGroup'])
    ->name('getMakerByGroup');
    //五十音からシリーズを取得
    Route::get('/get/api/series/{id}', [ApiController::class, 'getSeriesByGroup'])
    ->name('getSeriesByGroup');
    // マッチングの結果表示
    Route::get('/result', [MainController::class, 'matchingResultApi'])
    ->name('matchingResultApi');
    //検索画面
    Route::get('/search', [MainController::class, 'searchPage'])
    ->name('searchPage');
    //ジャンル検索結果画面
    Route::get('/search/result/genre',  [MainController::class, 'searchResultPageGenre'])
    ->name('searchResultPageGenre');
    //女優検索結果画面
    Route::get('/search/result/actress/detail/{id}/{name}',  [MainController::class, 'searchResultPageActress'])
    ->name('searchResultPageActress');
    //メーカー検索結果画面
    Route::get('/search/result/maker/detail/{id}/{name}',  [MainController::class, 'searchResultPageMaker'])
    ->name('searchResultPageMaker');
    //シリーズ検索結果画面
    Route::get('/search/result/series/detail/{id}/{name}',  [MainController::class, 'searchResultPageSeries'])
    ->name('searchResultPageSeries');
    //キーワード検索
    Route::get('/search/result/free-word/',  [MainController::class, 'searchResultPageFreeWord'])
    ->name('searchResultPageFreeWord');
    //並び替え
    Route::get('/search/result/{target}/{id}/{name}/{sort}', [MainController::class, 'searchResultSortPage'])
    ->name('searchResultSortPage');
});


//ヘルプページ
Route::get('/help' , [MainController::class, 'helpPage'])->name('helpPage');

//ジャンルをAPIから取得してDBに直接保存するルート
// Route::get('/get/api/data/genre', [GetApiDataController::class, 'getAllApiData'])->name('getAllApiData');

// require __DIR__.'/auth.php';
