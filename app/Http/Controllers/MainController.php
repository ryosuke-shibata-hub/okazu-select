<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Api\GenreModel;
use App\Models\Api\ActressModel;

use Log;
class MainController extends Controller
{

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

        foreach ($selectedGenres as $genre) {
            // ジャンルの回答で「YES」のみ抽出
            if ($answer = $genre['answer'] === config('const.GENRE.MATCHING.ANSWER.YES')) {
                $targetId[] = $genre['question'];
            }
        }

        if (empty($targetId)) {
            $getRandomGenre = GenreModel::getRandomGenre();

            return view('page.matching')
            ->with('getRandomGenre', $getRandomGenre)
            ->with('error', 'マッチするジャンルが見つかりませんでした。');
        }
        $searchKeyWord = $apiPram['APISEARCHPARAM'] . implode($apiPram['APISEARCHPARAM'], $targetId);

        $targetUrlToMatching = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$apiId}&affiliate_id={$affiliateId}&site=FANZA&service=digital&floor=videoa&hits=10&sort=match&article=genre{$searchKeyWord}&output=json";

        $getMatchingData = Http::get($targetUrlToMatching);

        if ($getMatchingData->ok()) {
            return view('page.matchingResult')
            ->with('getMatchingData', $getMatchingData);
        }

        return view("page.error.404");
    }


    public function welcomePage()
    {
        return view('page.welcomePage');
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
        // $actressData = ActressModel::getAllActress();

        // $groupedActresses = $actressData->groupBy(function($item) {
        //     $firstChar = mb_substr($item->actress_ruby, 0, 1);

        //     if (preg_match('/[あ-お]/u', $firstChar)) {
        //         return 'あ行';
        //     } elseif (preg_match('/[か-こ]/u', $firstChar)) {
        //         return 'か行';
        //     } elseif (preg_match('/[さ-そ]/u', $firstChar)) {
        //         return 'さ行';
        //     } elseif (preg_match('/[た-と]/u', $firstChar)) {
        //         return 'た行';
        //     } elseif (preg_match('/[な-の]/u', $firstChar)) {
        //         return 'な行';
        //     } elseif (preg_match('/[は-ほ]/u', $firstChar)) {
        //         return 'は行';
        //     } elseif (preg_match('/[ま-も]/u', $firstChar)) {
        //         return 'ま行';
        //     } elseif (preg_match('/[や-よ]/u', $firstChar)) {
        //         return 'や行';
        //     } elseif (preg_match('/[ら-ろ]/u', $firstChar)) {
        //         return 'ら行';
        //     } elseif (preg_match('/[わ-ん]/u', $firstChar)) {
        //         return 'わ行';
        //     }

        //     // 他の行も追加...
        //     return 'その他';
        // });

        return view('page.search')
        ->with('genreData', $genreData)
        ->with('actressGojuon', $actressGojuon);
    }
}
