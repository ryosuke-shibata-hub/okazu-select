<?php

namespace App\Http\Controllers\Recommend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Recommend\Recommend;

use Log;

class RecommendController extends Controller
{
    public function recommendList()
    {
        $recommendList = Recommend::getRecommendList();

        return view('page.recommend_list')
        ->with('recommendList', $recommendList);
    }

    public function recommendDetail($title)
    {
        if (!$title) {
            Log::error("記事の詳細で対象のパラメータが送られていない");
            return redirect('error.404');
        }

        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');

        try {
            $targetCollection = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&keyword={$title}&floor=videoa&hits=50&sort=rank&output=json";

            $response = Http::get($targetCollection);

            foreach ($response['result']['items'] as $result) {
                foreach ($result['iteminfo']['actress'] as $actress) {
                   $actressTargetId = $actress['id'];
                }
            }

            $targeActressUrl = "https://api.dmm.com/affiliate/v3/ActressSearch?api_id={$apiId}&affiliate_id={$affiliateId}&actress_id={$actressTargetId}&output=json";
            Log::alert("message",[$targeActressUrl]);

            $responseActressData = Http::get($targeActressUrl);

            $recommendDetail = Recommend::getRecommendDetail($title);

            // if ($response->ok() || $getGoodMatchingData->ok()) {
            if ($response->ok()) {
                Log::info("対象記事の作品情報の取得正常終了",["検索値"=>$title]);
                return view('page.recommend_detail')
                ->with('response', $response)
                ->with('recommendDetail', $recommendDetail)
                ->with('responseActressData', $responseActressData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("おすすめ記事の詳細で例外エラー", [$th]);
            return view("errors.500");
        }
    }
}
