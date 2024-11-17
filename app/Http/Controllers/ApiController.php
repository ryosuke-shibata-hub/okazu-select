<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Api\ActressModel;
use App\Models\Api\MakerModel;
use App\Models\Api\SeriesModel;

use Log;
class ApiController extends Controller
{
    public function getSampleTargetData($id)
    {
        Log::alert("message",[$id]);
        try {
            $apiId = config('const.API_ID');
            $affiliateId = config('const.AFFILIATE_ID');

            $apiUrl = "https://api.dmm.com/affiliate/v3/ItemList?api_id=${apiId}&affiliate_id=${affiliateId}&site=FANZA&service=digital&floor=videoa&cid=${id}&output=json";

            Log::debug("requestURL", [$apiUrl]);
            $response = Http::get($apiUrl);  // LaravelのHTTPクライアントでAPIを呼び出す

            return $response->json();
        } catch (\Throwable $th) {
            Log::error("message", [$th]);
        }
    }

    public function getActressesByGroup($id)
    {
        $getActressList = ActressModel::getActressTarget($id);

        return $getActressList;
    }

    public function getMakerByGroup($id)
    {
        $getMakerList = MakerModel::getMakerTarget($id);

        return $getMakerList;
    }

    public function getSeriesByGroup($id)
    {
        $getSeriesList = SeriesModel::getSeriesTarget($id);

        return $getSeriesList;
    }

}
