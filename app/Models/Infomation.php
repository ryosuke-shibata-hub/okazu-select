<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infomation extends Model
{
    use HasFactory;
    protected $table = "infomations";

    protected $fillable = [
        'title',
        'detail',
        'category',
        'created_at',
    ];

    public static function getAllInfomation()
    {

        return Infomation::where('delete_flg', config('const.INFOMATION.FLG.DELETE_FLG.ACTIVE'))
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public static function getInfomationDetail($id)
    {
        return Infomation::where('id', $id)
        ->where('delete_flg', config('const.INFOMATION.FLG.DELETE_FLG.ACTIVE'))
        ->orderBy('created_at', 'desc')
        ->first();
    }
}
