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

    public function __construct()
    {
        $this->apiId = config('const.API_ID');
        $this->affiliateId = config('const.AFFILIATE_ID');
        $this->getCountVideo = config('const.API.PARAMETER.SEARCH.GET_COUNT_VIDEO');
        $this->getCountGoods = config('const.API.PARAMETER.SEARCH.GET_COUNT_GOODS');
        $this->apiPram = config('const.API.PARAMETER.SEARCH.GENRE');
    }

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

    public function topPage(Request $request)
    {
        if ($request->currentPage) {
            $currentPage = $request->currentPage+10;
        } else {
            $currentPage = 1;
        }
        $targetUrlToRanking = $this->getApiDataToRanking($currentPage);


        return view('page.topPage')
        ->with('targetUrlToRanking', $targetUrlToRanking)
        ->with('currentPage', $currentPage);
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

    public function getApiDataToRanking($currentPage)
    {
        $targetUrlToRanking = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&floor=videoa&hits=10&sort=rank&offset={$currentPage}&output=json";

        $response = Http::get($targetUrlToRanking);

        if ($response->ok()) {
            return $response->json();
        }

        return array();

    }

    public function matchingResultApi(Request $request)
    {

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

        $searchKeyWords = $this->apiPram['APIGOODSSEARCHPARAM'] . implode($this->apiPram['APIGOODSSEARCHPARAM'], $targetName);
        //ジャンルでの結果取得用API
        $targetUrlToMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&floor=videoa&hits={$this->getCountVideo}&sort=match&keyword={$searchKeyWords}&output=json";
        //マッチングどの高いグッズの取得用API
        $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=match&keyword={$searchKeyWords}&mono_stock=stock|reserve|reserve_empty|mono&output=json";

        $response = Http::get($targetUrlToMatching);
        $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

        if ($response->ok() || $getGoodMatchingData) {
            Log::info("マッチング結果正常取得",['マッチング項目' => $searchKeyWords]);
            return view('page.matchingResult')
            ->with('response', $response)
            ->with('getGoodMatchingData', $getGoodMatchingData);
        }

        return view("errors.500");
    }

    public function searchResultPageGenre(Request $request)
    {
        $checkedGenreGenres = $request['checked_genre'];

        if (!$checkedGenreGenres) {
            return view('page.searchResult')
            ->with('response', '');
        }

        $targetName = [];
        foreach ($checkedGenreGenres as $genre) {
            $targetName[] = $genre;
        }

        $targetCheckedGenre = $this->apiPram['APIGOODSSEARCHPARAM'] . implode($this->apiPram['APIGOODSSEARCHPARAM'], $targetName);
        $target = 'genre';

        try {
            //ジャンルでの結果取得用API
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&floor=videoa&hits={$this->getCountVideo}&sort=match&keyword={$targetCheckedGenre}&output=json";
            //マッチングどの高いグッズの取得用API
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=match&keyword={$targetCheckedGenre}&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $response = Http::get($itemList);
            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

            if (empty($getGoodMatchingData['result']['items'])) {
                $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

                $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            }

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("ジャンル検索正常終了",["検索値"=>$targetName]);
                return view('page.searchResult')
                ->with('genre', $targetName)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData)
                ->with('id', 'searchGenre')
                ->with('name', $targetCheckedGenre)
                ->with('target', $target);
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

        $name = str_replace('／','/', $name);
        $target = 'actress';

        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&article={$target}&article_id={$id}&keyword={$name}&floor=videoa&hits={$this->getCountVideo}&sort=rank&output=json";
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            $response = Http::get($itemList);

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("女優検索正常終了",["検索値"=>$name]);
                return view('page.searchResult')
                ->with('keyword', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData)
                ->with('id', $id)
                ->with('name', $name)
                ->with('target', $target);
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

        $name = str_replace('／','/', $name);
        $target = 'maker';

        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&article=maker&article_id={$id}&keyword={$name}&floor=videoa&hits={$this->getCountVideo}&sort={$target}&output=json";
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            $response = Http::get($itemList);

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("メーカー検索正常終了",["検索値"=>$name]);
                return view('page.searchResult')
                ->with('keyword', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData)
                ->with('id', $id)
                ->with('name', $name)
                ->with('target', $target);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("メーカー検索で例外エラー", [$th]);
            return view("errors.500");
        }
    }

    public function searchResultPageSeries($id, $name)
    {
        if (!$id) {
            Log::error("シリーズ検索でidが送られていない");
            return redirect('error.404');
        }

        $name = str_replace('／','/', $name);
        $target = 'series';
        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&article={$target}&article_id={$id}&keyword={$name}&floor=videoa&hits={$this->getCountVideo}&sort=rank&output=json";
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            $response = Http::get($itemList);

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("シリーズ検索正常終了",["検索値"=>$name]);
                return view('page.searchResult')
                ->with('keyword', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData)
                ->with('id', $id)
                ->with('name', $name)
                ->with('target', $target);
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

        $target = 'keyword';

        try {
            $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&keyword={$keyword}&floor=videoa&hits={$this->getCountVideo}&sort=rank&output=json";
            //マッチングどの高いグッズの取得用API
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=match&keyword={$keyword}&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $response = Http::get($itemList);
            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

            if (empty($getGoodMatchingData['result']['items'])) {
                $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

                $getGoodMatchingData = Http::get($targetUrlToGoodMatching);
            }

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("フリーワード検索正常終了",["検索値"=>$keyword]);
                return view('page.searchResult')
                ->with('keyword', $keyword)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData)
                ->with('id', 'searchkeyword')
                ->with('name', $keyword)
                ->with('target', $target);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("キーワード検索で例外エラー", [$th]);
            return view('errors.500');
        }
    }

    public function searchResultSortPage($target, $id, $name, $sort)
    {
        if (!$target || !$id || !$name || !$sort) {
            Log::error("並び替えでパラメータ不正",
                [
                    'ターゲット' => $target,
                    'ターゲットID' => $id,
                    'ターゲット名' => $name,
                    'ソート順' => $sort
                ]);
            return view('errors.404');
        }
        $genre = null;
        try {
            if ($target == 'maker') {
                $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&article={$target}&article_id={$id}&keyword={$name}&floor=videoa&hits={$this->getCountVideo}&sort={$sort}&output=json";
            }
            if ($target == 'series') {
                $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&article={$target}&article_id={$id}&keyword={$name}&floor=videoa&{$this->getCountVideo}&sort={$sort}&output=json";
            }
            if ($target == 'genre') {
                $searchName = $name;
                $genre = explode("|", $name);
                // 配列に直した時に先頭が置換文字で不要なため先頭の配列削除
                $genreDelete = array_shift($genre);
                $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&floor=videoa&hits={$this->getCountVideo}&sort=match&keyword={$searchName}&sort={$sort}&output=json";
            }

            if ($target == 'actress') {
                $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&article={$target}&article_id={$id}&keyword={$name}&floor=videoa&hits={$this->getCountVideo}&sort={$sort}&output=json";
            }
            if ($target == 'keyword') {
                $itemList = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=digital&keyword={$name}&floor=videoa&hits={$this->getCountVideo}&sort={$sort}&output=json";
            }
            //マッチングどの高いグッズの取得用API
            $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$this->apiId}&affiliate_id={$this->affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=match&k&mono_stock=stock|reserve|reserve_empty|mono&output=json";

            $response = Http::get($itemList);
            $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

            if (empty($getGoodMatchingData['result']['items'])) {
                $targetUrlToGoodMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=mono&floor=goods&hits={$this->getCountGoods}&sort=rank&mono_stock=stock|reserve|reserve_empty|mono&output=json";

                $getGoodMatchingData = Http::get($targetUrlToGoodMatching);

            }

            if ($response->ok() || $getGoodMatchingData->ok()) {
                Log::info("並び替え検索の正常終了",["検索値"=>$name]);
                return view('page.searchResult')
                ->with('genre', $genre)
                ->with('keyword', $name)
                ->with('response', $response)
                ->with('getGoodMatchingData', $getGoodMatchingData)
                ->with('id', $id)
                ->with('name', $name)
                ->with('target', $target);
            }

            return array();

        } catch (\Throwable $th) {
            Log::error("キーワード検索で例外エラー", [$th]);
            return view('errors.500');
        }
    }
}
