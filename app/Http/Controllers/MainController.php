<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Api\GenreModel;
use App\Models\Api\ActressModel;
use App\Models\infomation;
use Log;
class MainController extends Controller
{

    public function welcomePage()
    {
        return view('page.welcomePage');
    }

    public function infomationPage()
    {
        $infomation = infomation::getAllInfomation();

        return view('page.infomation')
        ->with('infomation', $infomation);
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
        $actressGojuon = config('const.ACTRESS.SEARCH_NAME.GOJUON');

        return view('page.search')
        ->with('genreData', $genreData)
        ->with('actressGojuon', $actressGojuon);
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

        $searchKeyWord = $apiPram['APISEARCHPARAM'] . implode($apiPram['APISEARCHPARAM'], $targetId);
        $searchKeyWordGoods = $apiPram['APIGOODSSEARCHPARAM'] . implode($apiPram['APIGOODSSEARCHPARAM'], $targetName);

        //ジャンルでの結果取得用API
        $targetUrlToMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&floor=videoa&hits=10&sort=match&article=genre{$searchKeyWord}&output=json";
        //マッチングどの高いグッズの取得用API
        $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits=18&sort=match&keyword={$searchKeyWordGoods}&mono_stock=stock|reserve|reserve_empty|mono&output=json";

        $getMatchingData = Http::get($targetUrlToMatching);
        $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

        if ($getMatchingData->ok() || $getGoodMatchingData) {
            return view('page.matchingResult')
            ->with('getMatchingData', $getMatchingData)
            ->with('getGoodMatchingData', $getGoodMatchingData);
        }

        return view("page.error.404");
    }

    public function searchResultPageGenre($id, $name)
    {
        if (!$id) {
            return redirect('error.404');
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
                return view('page.searchResultGenre')
                ->with('name', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("message", [$th]);
            return redirect('500');
        }
    }

    public function searchResultPageActress($id, $name)
    {
        Log::debug("message",[$id, $name]);
        if (!$id) {
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
                return view('page.searchResultActress')
                ->with('name', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("message", [$th]);
            return redirect('500');
        }
    }

    public function searchResultPageFreeWord(Request $request)
    {

        $keyword = $request->searchKeyword;
        if (!$keyword) {
            return redirect('error.404');
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
                return view('page.searchResultKeyWord')
                ->with('keyword', $keyword)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("message", [$th]);
            return redirect('500');
        }
    }
}
