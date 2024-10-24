<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakerModel extends Model
{
    use HasFactory;

    protected $table = "maker";

    protected $fillable = [
        'maker_id',
        'site_name',
        'site_code',
        'service_name',
        'service_code',
        'floor_id',
        'floor_name',
        'floor_code',
        'maker_name',
        'maker_name_ruby',
        'list_url',
        'delete_flg',
    ];

    public static function checkUniqueMaker($makerRecordData) {

        $data = MakerModel::where('maker_id', $makerRecordData)
        ->first();

        return $data;
    }

    public static function createNewMaker($makerRecordData)
    {
        MakerModel::create([
            'maker_id' => $makerRecordData['maker_id'],
            'site_name' => $makerRecordData['site_name'],
            'site_code' => $makerRecordData['site_code'],
            'service_name' => $makerRecordData['service_name'],
            'service_code' => $makerRecordData['service_code'],
            'floor_id' => $makerRecordData['floor_id'],
            'floor_name' => $makerRecordData['floor_name'],
            'floor_code' => $makerRecordData['floor_code'],
            'maker_name' => $makerRecordData['maker_name'],
            'maker_name_ruby' => $makerRecordData['maker_name_ruby'],
            'list_url' => $makerRecordData['list_url'],
            'delete_flg' => config('const.MAKER.FLG.DELETE_FLG.ACTIVE'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
