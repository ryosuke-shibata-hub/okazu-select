<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Api\GenreModel;

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
}
