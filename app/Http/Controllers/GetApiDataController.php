<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Api\GenreModel;
use App\Models\Api\FloorModel;

use Log;
use DB;

class GetApiDataController extends Controller
{
    public function getAllApiData()
    {
        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');

        //ジャンル検索/取得用
        $targeGenreUrl = "https://api.dmm.com/affiliate/v3/GenreSearch?api_id={$apiId}&affiliate_id={$affiliateId}&floor_id=43&hits=500&offset=1&output=json";
        // フロア検索/取得用
        $targeFloorUrl = "https://api.dmm.com/affiliate/v3/FloorList?api_id={$apiId}&affiliate_id={$affiliateId}&output=json";


        $responseGenreData = Http::get($targeGenreUrl);
        $responseFloorData = Http::get($targeFloorUrl);

        Log::info("ジャンル取得結果",[$responseGenreData]);
        Log::info("フロア取得結果",[$responseFloorData]);

        //ジャンルに紐づいているフロアIDを設定
        $getDataGenreFloor = $responseGenreData['result']['floor_id'];

        try {

            DB::beginTransaction();

            foreach ($responseGenreData['result']['genre'] as $genreData) {
                $getUniqueGenre = GenreModel::checkUniqueGenre($genreData);
                //すでに登録されているジャンルはスキップする
                if (!$getUniqueGenre) {
                    GenreModel::createNewGenre($genreData, $getDataGenreFloor);
                }
            }


            foreach ($responseFloorData['result']['site'] as $siteData) {
                foreach ($siteData['service'] as $serviceData) {
                    foreach ($serviceData['floor'] as $floorData) {
                        $floorRecordData = [
                            'site_name' => $siteData['name'],
                            'site_code' => $siteData['code'],
                            'service_name' => $serviceData['name'],
                            'service_code' => $serviceData['code'],
                            'floor_id' => $floorData['id'],
                            'floor_name' => $floorData['name'],
                            'floor_code' => $floorData['code'],
                        ];

                        $checkUniqueFloor = FloorModel::checkUniqueFloor($floorRecordData['floor_id']);
                        //すでに登録されているジャンルはスキップする
                        if (!$checkUniqueFloor) {
                            FloorModel::createNewFloor($floorRecordData);
                        }
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            Log::error("API取得・保存エラー",[$th]);
            return redirect('/top');
        }

    }
}
