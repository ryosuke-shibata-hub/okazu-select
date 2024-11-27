<?php

namespace App\Models\Recommend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    use HasFactory;
    protected $table = "recommend";

    public static function getRecommendList()
    {
        $data = Recommend::where('delete_flg', 0)
        ->orderBy('created_at', 'desc')
        ->get();

        return $data;
    }

    public static function getRecommendDetail($title)
    {
        $data = Recommend::where('delete_flg', 0)
        ->where('title', $title)
        ->first();

        return $data;
    }
}
