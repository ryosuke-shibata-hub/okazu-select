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
}