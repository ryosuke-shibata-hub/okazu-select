<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Api\GenreModel;
use App\Models\Api\ActressModel;
use App\Models\Infomation;
use Log;
class MainController extends Controller
{

    public function welcomePage()
    {
        return view('page.welcomePage');
    }

    public function infomationPage()
    {
        $infomation = Infomation::getAllInfomation();

        return view('page.infomation')
        ->with('infomation', $infomation);
    }

    public function infomationDetailPage($id)
    {
        $targetInfomation = Infomation::getInfomationDetail($id);

        return view('page.infomationDetailPage')
        ->with('targetInfomation', $targetInfomation);
    }

    public function topPage()
    {

        $targetUrlToRanking = $this->getApiDataToRanking();

        return view('page.topPage')
        ->with('targetUrlToRanking', $targetUrlToRanking);
    }

    public function matchingPage()
    {

        $getRandomGenre = GenreModel::getRandomGenre();

        return view('page.matching')
        ->with('error', '')
        ->with('getRandomGenre', $getRandomGenre->toArray());
    }

    public function searchPage()
    {
        $genreData = GenreModel::getAllGenre();
        $Gojuon = config('const.SEARCH_PARAM.GOJUON');

        return view('page.search')
        ->with('genreData', $genreData)
        ->with('Gojuon', $Gojuon);
    }

    public function helpPage()
    {
        return view('page.help');
    }

    public function getApiDataToRanking()
    {
        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');
        $targetUrlToRanking = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&floor=videoa&hits=10&sort=rank&output=json";

        $response = Http::get($targetUrlToRanking);

        if ($response->ok()) {
            return $response->json();
        }

        return array();

    }

    public function matchingResultApi(Request $request)
    {

        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');
        $getCount = config('const.API.MATCHING.GET_COUNT');

        $apiPram = config('const.API.PARAMETER.SEARCH.GENRE');
        // input要素をjsonに変換
        $selectedGenres = json_decode($request->input('selectGenre'), true);
        // データセットの初期化
        $targetKeyWord = [];
        $targetId = [];
        $targetName = [];

        foreach ($selectedGenres as $genre) {
            // ジャンルの回答で「YES」のみ抽出
            if ($answer = $genre['answer'] === config('const.GENRE.MATCHING.ANSWER.YES')) {
                $targetId[] = $genre['question'];
                $targetName[] = $genre['genre_name'];
            }
        }

        $searchKeyWords = $apiPram['APIGOODSSEARCHPARAM'] . implode($apiPram['APIGOODSSEARCHPARAM'], $targetName);
        //ジャンルでの結果取得用API
        $targetUrlToMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&floor=videoa&hits={$getCount}&sort=match&keyword={$searchKeyWords}&output=json";
        //マッチングどの高いグッズの取得用API
        $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=match&keyword={$searchKeyWords}&mono_stock=stock|reserve|reserve_empty|mono&output=json";

        $getMatchingData = Http::get($targetUrlToMatching);
        $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

        if ($getMatchingData->ok() || $getGoodMatchingData) {
            return view('page.matchingResult')
            ->with('getMatchingData', $getMatchingData)
            ->with('getGoodMatchingData', $getGoodMatchingData);
        }

        return view("errors.500");
    }

    public function searchResultPageGenre($id, $name)
    {
        if (!$id) {
            Log::error("ジャンル検索でidが送られていない");
            return redirect('errors.404');
        }

        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');

        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&keyword={$name}&article=genre&article_id={$id}&&floor=videoa&hits=50&sort=rank&output=json";

            //マッチングどの高いグッズの取得用API
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=match&keyword={$name}&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $response = Http::get($itemList);
            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

            if (empty($getGoodMatchingData['result']['items'])) {
                $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

                $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            }

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("ジャンル検索正常終了",["検索値"=>$name]);
                return view('page.searchResultGenre')
                ->with('name', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("ジャンルからの検索で例外エラー", [$th]);
            return view("errors.500");
        }
    }

    public function searchResultPageActress($id, $name)
    {
        if (!$id) {
            Log::error("女優検索でidが送られていない");
            return redirect('error.404');
        }

        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');

        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&article=actress&article_id={$id}&keyword={$name}&floor=videoa&hits=50&sort=rank&output=json";
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            $response = Http::get($itemList);

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("女優検索正常終了",["検索値"=>$name]);
                return view('page.searchResultActress')
                ->with('name', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("女優検索で例外エラー", [$th]);
            return view("errors.500");
        }
    }

    public function searchResultPageMaker($id, $name)
    {
        if (!$id) {
            Log::error("メーカー検索でidが送られていない");
            return redirect('error.404');
        }

        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');

        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&article=maker&article_id={$id}&keyword={$name}&floor=videoa&hits=50&sort=rank&output=json";
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";
            Log::debug("message",[$itemList]);

            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            $response = Http::get($itemList);

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("メーカー検索正常終了",["検索値"=>$name]);
                return view('page.searchResultMaker')
                ->with('name', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("メーカー検索で例外エラー", [$th]);
            return view("errors.500");
        }
    }

    public function searchResultPageFreeWord(Request $request)
    {

        $keyword = $request->searchKeyword;
        if (!$keyword) {
            Log::error("キーワード検索でキーワードを受け取っていない");
            return view('errors.404');
        }

        $apiId = config('const.API_ID');
        $affiliateId = config('const.AFFILIATE_ID');

        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&keyword={$keyword}&floor=videoa&hits=50&sort=rank&output=json";
            //マッチングどの高いグッズの取得用API
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=match&keyword={$keyword}&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $response = Http::get($itemList);
            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

            if (empty($getGoodMatchingData['result']['items'])) {
                $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

                $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            }

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("キーワード検索正常終了",["検索値"=>$keyword]);
                return view('page.searchResultKeyWord')
                ->with('keyword', $keyword)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("キーワード検索で例外エラー", [$th]);
            return view('errors.500');
        }
    }
}