<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Log;
class ApiController extends Controller
{
    public function getSampleTargetData($id)
    {
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
}
