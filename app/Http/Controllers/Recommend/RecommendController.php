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

    public function __construct()
    {
        $this->apiId = config('const.API_ID');
        $this->affiliateId = config('const.AFFILIATE_ID');
        $this->getCountVideo = config('const.API.PARAMETER.SEARCH.GET_COUNT_VIDEO');
        $this->getCountGoods = config('const.API.PARAMETER.SEARCH.GET_COUNT_GOODS');
        $this->apiPram = config('const.API.PARAMETER.SEARCH.GENRE');
    }

    public function recommendList()
    {
        $recommendList = Recommend::getRecommendList();

        return view('page.recommend_list')
        ->with('recommendList', $recommendList);
    }

    public function recommendDetail($content_id)
    {

        if (!$content_id) {
            Log::error("記事の詳細で対象のパラメータが送られていない");
            return redirect('error.404');
        }

        try {
            $targetCollection = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&cid={$content_id}&floor=videoa&hits=1&sort=rank&output=json";

            $response = Http::get($targetCollection);

            foreach ($response['result']['items'] as $result) {
                if (isset($result['iteminfo']['actress'])) {

                    foreach ($result['iteminfo']['actress'] as $actress) {
                        $actressTargetId = $actress['id'];
                        $actressTargetName = $actress['name'];
                    }
                } else {

                        $actressTargetId = "";
                        $actressTargetName = "";
                }
            }

            $targeActressUrl = "https://api.dmm.com/affiliate/v3/ActressSearch?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&actress_id={$actressTargetId}&output=json";

            //マッチングどの高いグッズの取得用API
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=match&keyword={$actressTargetName}&mono_stock=stock|reserve|reserve_empty|mono&output=json";


            $responseActressData = Http::get($targeActressUrl);
            $responseGoodsData = Http::get($targetUrlToGoodMatching);

            DB::beginTransaction();

            $recommendDetail = Recommend::getRecommendDetail($content_id);

            DB::commit();

            if ($response->ok()) {
                Log::info("対象記事の作品情報の取得正常終了",["検索値"=>$content_id]);
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
