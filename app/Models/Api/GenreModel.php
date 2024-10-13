<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenreModel extends Model
{
    use HasFactory;

    protected $table = "genre";

    protected $fillable = [
        'genre_id',
        'floor_id',
        'genre_name',
        'genre_name_ruby',
        'list_url',
    ];

    public static function checkUniqueGenre($genreData) {

        $data = GenreModel::where('genre_id', $genreData['genre_id'])
        ->first();

        return $data;
    }

    public static function createNewGenre($genreData, $getDataFloor)
    {
        GenreModel::create([
            'genre_id' => $genreData['genre_id'],
            'floor_id' => $getDataFloor,
            'genre_name' => $genreData['name'],
            'genre_name_ruby' => $genreData['ruby'],
            'list_url' => $genreData['list_url']??'',
            'delete_flg' => config('const.GENRE.FLG.DELETE_FLG.ACTIVE'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function getRandomGenre()
    {
        return GenreModel::where('delete_flg', config('const.GENRE.FLG.DELETE_FLG.ACTIVE'))
        ->where('floor_id', config('const.GENRE.FLOOR_CODE.videoa'))
        ->inRandomOrder()
        ->take(5)
        ->get();
    }

    public static function getGenreId($genre)
    {
        return $data = GenreModel::select(
            'genre_id',
        )
        ->where('genre_id', $genre)
        ->where('delete_flg', config('const.GENRE.FLG.DELETE_FLG.ACTIVE'))
        ->first();
    }
}
