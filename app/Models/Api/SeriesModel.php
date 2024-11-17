<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriesModel extends Model
{
    use HasFactory;

    protected $table = "series";

    protected $fillable = [
        'series_id',
        'site_name',
        'site_code',
        'service_name',
        'service_code',
        'floor_id',
        'floor_name',
        'floor_code',
        'series_name',
        'series_name_ruby',
        'list_url',
        'delete_flg',
    ];

    public static function checkUniqueSeries($seriesDataRecordData) {

        $data = SeriesModel::where('series_id', $seriesDataRecordData)
        ->first();

        return $data;
    }

    public static function createNewSeries($seriesDataRecordData)
    {
        SeriesModel::create([
            'series_id' => $seriesDataRecordData['series_id'],
            'site_name' => $seriesDataRecordData['site_name'],
            'site_code' => $seriesDataRecordData['site_code'],
            'service_name' => $seriesDataRecordData['service_name'],
            'service_code' => $seriesDataRecordData['service_code'],
            'floor_id' => $seriesDataRecordData['floor_id'],
            'floor_name' => $seriesDataRecordData['floor_name'],
            'floor_code' => $seriesDataRecordData['floor_code'],
            'series_name' => $seriesDataRecordData['series_name'],
            'series_name_ruby' => $seriesDataRecordData['series_name_ruby'],
            'list_url' => $seriesDataRecordData['list_url'],
            'delete_flg' => config('const.SERIES.FLG.DELETE_FLG.ACTIVE'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function getSeriesTarget($id)
    {
        $nameRanges = [
            0 => ['あ', 'い', 'う', 'え', 'お'],  // あ行
            1 => ['か', 'き', 'く', 'け', 'こ'],  // か行
            2 => ['さ', 'し', 'す', 'せ', 'そ'],  // さ行
            3 => ['た', 'ち', 'つ', 'て', 'と'],  // た行
            4 => ['な', 'に', 'ぬ', 'ね', 'の'],  // な行
            5 => ['は', 'ひ', 'ふ', 'へ', 'ほ'],  // は行
            6 => ['ま', 'み', 'む', 'め', 'も'],  // ま行
            7 => ['や', 'ゆ', 'よ'],              // や行
            8 => ['ら', 'り', 'る', 'れ', 'ろ'],  // ら行
            9 => ['わ', 'を', 'ん'],              // わ行
            10 => ['その他']                      // その他（アルファベットや記号など）
        ];

        if (array_key_exists($id, $nameRanges)) {
            $targetNames = $nameRanges[$id];
            // 1つのSQLクエリで効率的にデータ取得
            return SeriesModel::where(function ($query) use ($targetNames) {
                foreach ($targetNames as $name) {
                    $query->orWhere('series_name_ruby', 'LIKE', $name . '%');
                }
            })
            ->where('delete_flg', config('const.SERIES.FLG.DELETE_FLG.ACTIVE'))
            ->orderBy('series_name_ruby', 'asc')
            ->get();
        }

        return [];
    }
}
