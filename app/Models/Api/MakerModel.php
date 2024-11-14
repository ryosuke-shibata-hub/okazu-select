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

    public static function getMakerTarget($id)
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
            return MakerModel::where(function ($query) use ($targetNames) {
                foreach ($targetNames as $name) {
                    $query->orWhere('maker_name_ruby', 'LIKE', $name . '%');
                }
            })
            ->where('delete_flg', config('const.MAKER.FLG.DELETE_FLG.ACTIVE'))
            ->orderBy('maker_name_ruby', 'asc')
            ->get();
        }

        return [];
    }
}