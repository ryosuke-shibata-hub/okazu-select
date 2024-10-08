<?php

return [

    "REDIRECT" => "https://www.google.com/?hl=ja",
    "API_ID" => env('FANZA_API_ID'),
    "AFFILIATE_ID" => env('FANZA_AFFILIATE_ID'),
    "GENRE" => [
        "FLG" => [
            "DELETE_FLG" => [
                "ACTIVE" => 0, //有効
                "DISABLED" => 1 //無効
            ],
        ],
        "FLOOR_CODE" => [
            "videoa" => 43, //ビデオ
            "videoc" => 44, //素人
            "nikkatsu" => 45, //成人映画
            "anime" => 46, //アニメ動画
        ],
    ],
    "FLOOR" => [
        "FLG" => [
            "DELETE_FLG" => [
                "ACTIVE" => 0, //有効
                "DISABLED" => 1 //無効
            ],
        ],
    ],
];
