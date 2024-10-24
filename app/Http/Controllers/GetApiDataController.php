<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Api\GenreModel;
use App\Models\Api\FloorModel;
use App\Models\Api\ActressModel;
use App\Models\Api\MakerModel;
use App\Models\Api\SeriesSearchModel;

use Log;
use DB;

class GetApiDataController extends Controller
{
    public function getAllApiData()
    {
        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');
        $offset = 37400;
        $limit = 100; // 1回あたりの最大取得件数
        $hasMoreData = true;
        //ジャンル検索/取得用
        // $targeGenreUrl = "https://api.dmm.com/affiliate/v3/GenreSearch?api_id={$apiId}&affiliate_id={$affiliateId}&floor_id=43&hits=500&offset=1&output=json";
        // フロア検索/取得用
        // $targeFloorUrl = "https://api.dmm.com/affiliate/v3/FloorList?api_id={$apiId}&affiliate_id={$affiliateId}&output=json";



        // $responseGenreData = Http::get($targeGenreUrl);
        // $responseFloorData = Http::get($targeFloorUrl);



        // Log::info("ジャンル取得結果",[$responseGenreData]);
        // Log::info("フロア取得結果",[$responseFloorData]);
        // Log::info("女優取得結果",[$responseActressData]);
        // Log::info("メーカー取得結果",[$responseMakerData]);

        //ジャンルに紐づいているフロアIDを設定
        // $getDataGenreFloor = $responseGenreData['result']['floor_id'];

        try {

            // DB::beginTransaction();

            // while ($hasMoreData == true) {
            //     Log::debug("女優データ保存中...",["検索位置before"=>$offset]);
            //     // 女優検索/取得用
            //     $targeActressUrl = "https://api.dmm.com/affiliate/v3/ActressSearch?api_id={$apiId}&affiliate_id={$affiliateId}&hits={$limit}&offset={$offset}&output=json";

            //     $responseActressData = Http::get($targeActressUrl);
            //     // Log::debug("取得女優データ",[$responseActressData]);
            //     if (empty($responseActressData['result'])) {
            //         Log::debug("女優データ保存完了");
            //         $hasMoreData = false;
            //         break;
            //         return redirect('/top');
            //     }

            //     // 女優データ保存ロジック
            //     foreach ($responseActressData['result']['actress'] as $actressData) {
            //         $getUniqueActress = ActressModel::checkUniqueActress($actressData);
            //         //すでに登録されているジャンルはスキップする
            //         if (!$getUniqueActress) {
            //             ActressModel::createNewActress($actressData);
            //         }
            //     }
            //     // 100件ずつ取得件数を増やしていく
            //     $offset += $limit;
            //     Log::debug("女優データ保存中...",["検索位置after"=>$offset]);
            //     sleep(1);
            // }

            // Log::debug("女優データ保存中...",["検索位置"=>$offset]);
            // ジャンルデータの保存ロジック
            // foreach ($responseGenreData['result']['genre'] as $genreData) {
            //     $getUniqueGenre = GenreModel::checkUniqueGenre($genreData);
            //     //すでに登録されているジャンルはスキップする
            //     if (!$getUniqueGenre) {
            //         GenreModel::createNewGenre($genreData, $getDataGenreFloor);
            //     }
            // }
            // フロアデータの保存ロジック
            // foreach ($responseFloorData['result']['site'] as $siteData) {
            //     foreach ($siteData['service'] as $serviceData) {
            //         foreach ($serviceData['floor'] as $floorData) {
            //             $floorRecordData = [
            //                 'site_name' => $siteData['name'],
            //                 'site_code' => $siteData['code'],
            //                 'service_name' => $serviceData['name'],
            //                 'service_code' => $serviceData['code'],
            //                 'floor_id' => $floorData['id'],
            //                 'floor_name' => $floorData['name'],
            //                 'floor_code' => $floorData['code'],
            //             ];

            //             $checkUniqueFloor = FloorModel::checkUniqueFloor($floorRecordData['floor_id']);
            //             //すでに登録されているジャンルはスキップする
            //             if (!$checkUniqueFloor) {
            //                 FloorModel::createNewFloor($floorRecordData);
            //             }
            //         }
            //     }

            //シリーズ取得・保存ロジック
            while ($hasMoreData == true) {
                Log::debug("シリーズデータ保存中...",["検索位置before"=>$offset]);
                // メーカー検索/取得用
                $targeSeriesUrl = "https://api.dmm.com/affiliate/v3/SeriesSearch?api_id={$apiId}&affiliate_id={$affiliateId}&floor_id=43&hits={$limit}&offset={$offset}&output=json";

                Log::info("リクエストURL",[$targeSeriesUrl]);
                $responseSeriesData = Http::get($targeSeriesUrl);
                // Log::debug("取得女優データ",[$responseActressData]);
                if (empty($responseSeriesData['result']['series'])) {
                    Log::debug("メーカーデータ保存完了");
                    $hasMoreData = false;
                    break;
                    return redirect('/top');
                }

                $siteData = $responseSeriesData['result'];
                Log::debug("message",[$siteData]);
                foreach ($siteData['series'] as $seriesData) {
                    Log::debug("message",[$seriesData]);
                    $seriesDataRecordData = [
                        'site_name' => $siteData['site_name'],
                        'site_code' => $siteData['site_code'],
                        'service_name' => $siteData['service_name'],
                        'service_code' => $siteData['service_code'],
                        'floor_id' => $siteData['floor_id'],
                        'floor_name' => $siteData['floor_name'],
                        'floor_code' => $siteData['floor_code'],
                        'series_id' => $seriesData['series_id'],
                        'series_name' => $seriesData['name'],
                        'series_name_ruby' => $seriesData['ruby'],
                        'list_url' => $seriesData['list_url'],
                    ];

                    $checkUniqueSiries = SeriesSearchModel::checkUniqueSeries($seriesDataRecordData['series_id']);
                    //すでに登録されているジャンルはスキップする
                    if (!$checkUniqueSiries) {
                        SeriesSearchModel::createNewSeries($seriesDataRecordData);
                    }
                }
                // 100件ずつ取得件数を増やしていく
                $offset += $limit;
                Log::debug("シリーズーデータ保存中...",["検索位置after"=>$offset]);
                sleep(1);
            }



            //メーカー取得・保存ロジック
            // while ($hasMoreData == true) {
            //     Log::debug("メーカーデータ保存中...",["検索位置before"=>$offset]);
            //     // メーカー検索/取得用
            //     $targeMakerUrl = "https://api.dmm.com/affiliate/v3/MakerSearch?api_id={$apiId}&affiliate_id={$affiliateId}&floor_id=43&hits={$limit}&offset={$offset}&output=json";

            //     Log::info("リクエストURL",[$targeMakerUrl]);
            //     $responseMakerData = Http::get($targeMakerUrl);
            //     // Log::debug("取得女優データ",[$responseActressData]);
            //     if (empty($responseMakerData['result']['maker'])) {
            //         Log::debug("メーカーデータ保存完了");
            //         $hasMoreData = false;
            //         break;
            //         return redirect('/top');
            //     }

            //     $siteData = $responseMakerData['result'];
            //     Log::debug("message",[$siteData]);
            //     foreach ($siteData['maker'] as $makerData) {
            //         Log::debug("message",[$makerData]);
            //         $makerRecordData = [
            //             'site_name' => $siteData['site_name'],
            //             'site_code' => $siteData['site_code'],
            //             'service_name' => $siteData['service_name'],
            //             'service_code' => $siteData['service_code'],
            //             'floor_id' => $siteData['floor_id'],
            //             'floor_name' => $siteData['floor_name'],
            //             'floor_code' => $siteData['floor_code'],
            //             'maker_id' => $makerData['maker_id'],
            //             'maker_name' => $makerData['name'],
            //             'maker_name_ruby' => $makerData['ruby'],
            //             'list_url' => $makerData['list_url'],
            //         ];

            //         $checkUniqueMaker = MakerModel::checkUniqueMaker($makerRecordData['maker_id']);
            //         //すでに登録されているジャンルはスキップする
            //         if (!$checkUniqueMaker) {
            //             MakerModel::createNewMaker($makerRecordData);
            //         }
            //     }
            //     // 100件ずつ取得件数を増やしていく
            //     $offset += $limit;
            //     Log::debug("メーカーデータ保存中...",["検索位置after"=>$offset]);
            //     sleep(1);
            // }

            // DB::commit();

            Log::debug("APIデータ取得正常終了");
            return redirect('/top');
        } catch (\Throwable $th) {
            Log::error("API取得・保存エラー",[$th]);
            return redirect('/top');
        }
    }
}
