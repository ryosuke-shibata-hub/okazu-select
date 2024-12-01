<?php

namespace App\Http\Controllers\Recommend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Recommend\Recommend;

use Log;
use DB;

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
                   $actressTargetName = $actress['name'];
                }
            }

            $targeActressUrl = "https://api.dmm.com/affiliate/v3/ActressSearch?api_id={$apiId}&affiliate_id={$affiliateId}&actress_id={$actressTargetId}&output=json";

            //マッチングどの高いグッズの取得用API
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=match&keyword={$actressTargetName}&mono_stock=stock|reserve|reserve_empty|mono&output=json";


            $responseActressData = Http::get($targeActressUrl);
            $responseGoodsData = Http::get($targetUrlToGoodMatching);
// dd($responseGoodsData['result']['result_count']);
            DB::beginTransaction();

            $recommendDetail = Recommend::getRecommendDetail($title);

            DB::commit();

            if ($response->ok()) {
                Log::info("対象記事の作品情報の取得正常終了",["検索値"=>$title]);
                return view('page.recommend_detail')
                ->with('response', $response)
                ->with('recommendDetail', $recommendDetail)
                ->with('responseActressData', $responseActressData)
                ->with('responseGoodsData', $responseGoodsData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("おすすめ記事の詳細で例外エラー", [$th]);
            return view("errors.500");
        }
    }
}
