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
        ->with('getRandomGenre', $getRandomGenre->toArray());
    }

    public function matchingResultPage(Request $request)
    {
        // input要素をjsonに変換
        $selectedGenres = json_decode($request->input('selectGenre'), true);
        // データセットの初期化
        $targetKeyWord = [];

        foreach ($selectedGenres as $genre) {
            // ジャンルの回答で「YES」のみ抽出
            if ($answer = $genre['answer'] === config('const.GENRE.MATCHING.ANSWER.YES')) {
                $targetKeyWord[] = ($genre['question']);
            }
        }
        // 検索用に整形
        $serachKeyWord = implode("|", $targetKeyWord);
dd($serachKeyWord);
    }
}
