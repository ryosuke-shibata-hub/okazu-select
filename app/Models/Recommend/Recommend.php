<?php

namespace App\Models\Recommend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    use HasFactory;
    protected $table = "recommend";

    protected $fillable = [
        'view_count',
    ];

    public static function getRecommendList()
    {
        $data = Recommend::where('created_at', '<', date("Y/m/d H:i:s"))
        ->where('delete_flg', 0)
        ->orderBy('created_at', 'desc')
        ->get();

        return $data;
    }

    public static function getRecommendDetail($content_id)
    {
        $targetData = Recommend::where('delete_flg', 0)
        ->where('content_id', $content_id)
        ->first();

        $targetData = $targetData;
        $targetData->view_count = $targetData->view_count + 1;
        $targetData->updated_at = now();
        $targetData->save();

        return $targetData;
    }
}
