<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Log;
use DB;

class ActressModel extends Model
{
    use HasFactory;
    protected $table = "actress";

    protected $fillable = [
        'actress_id',
        'actress_name',
        'actress_ruby',
        'actress_bust',
        'actress_cup',
        'actress_waist',
        'actress_hip',
        'actress_height',
        'actress_birthday',
        'actress_blood_type',
        'actress_hobby',
        'actress_prefectures',
        'imageURL',
        'digital',
        'monthly_premium',
        'mono',
        'delete_flg',
    ];

    public static function checkUniqueActress($actressData) {

        $data = ActressModel::where('actress_id', $actressData['id'])
        ->first();

        return $data;
    }

    public static function createNewActress($actressData)
    {
        ActressModel::create([
            'actress_id' => $actressData['id'],
            'actress_name' => $actressData['name'],
            'actress_ruby' => $actressData['ruby'],
            'actress_bust' => $actressData['bust'] ?? '',
            'actress_cup' => $actressData['cup'] ?? '',
            'actress_waist' => $actressData['waist'] ?? '',
            'actress_hip' => $actressData['hip'] ?? '',
            'actress_height' => $actressData['height'] ?? '',
            'actress_birthday' => $actressData['birthday'] ?? '',
            'actress_blood_type' => $actressData['blood_type'] ?? '',
            'actress_hobby' => $actressData['hobby'] ?? '',
            'actress_prefectures' => $actressData['prefectures'] ?? '',
            'imageURL' => $actressData['imageURL']['large'] ?? '',
            'digital' => $actressData['listURL']['digital'] ?? '',
            'monthly_premium' => $actressData['listURL']['monthly_premium'] ?? '',
            'mono' => $actressData['listURL']['mono'] ?? '',
            'delete_flg' => config('const.ACTRESS.FLG.DELETE_FLG.ACTIVE'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function getAllActress()
    {
        return $data = ActressModel::where('delete_flg' ,config('const.ACTRESS.FLG.DELETE_FLG.ACTIVE'))
        ->orderBy(DB::raw("CONVERT(actress_ruby USING utf8) COLLATE utf8_unicode_ci"))
        ->get();
    }

    public static function getActressTarget($id)
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
            return ActressModel::where(function ($query) use ($targetNames) {
                foreach ($targetNames as $name) {
                    $query->orWhere('actress_ruby', 'LIKE', $name . '%');
                }
            })
            ->where('delete_flg', config('const.ACTRESS.FLG.DELETE_FLG.ACTIVE'))
            ->orderBy('actress_ruby', 'asc')
            ->get();
        }

        return [];
    }
}
