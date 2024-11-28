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
        $data = Recommend::where('delete_flg', 0)
        ->orderBy('created_at', 'desc')
        ->get();

        return $data;
    }

    public static function getRecommendDetail($title)
    {
        $targetData = Recommend::where('delete_flg', 0)
        ->where('title', $title)
        ->first();

        $targetData = $targetData;
        $targetData->view_count = $targetData->view_count + 1;
        $targetData->updated_at = now();
        $targetData->save();

        return $targetData;
    }
}
