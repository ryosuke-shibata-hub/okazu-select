<?php

return [

    "REDIRECT" => "https://www.google.com/?hl=ja",
    "API_ID" => env('FANZA_API_ID'),
    "AFFILIATE_ID" => env('FANZA_AFFILIATE_ID'),
    "API" => [
        "PARAMETER" => [
            "SEARCH" => [
                "GENRE" => [
                    "APISEARCHPARAM" => "&article_id[0]=",
                    "APIGOODSSEARCHPARAM" => "|",
                ],
                "GET_COUNT_VIDEO" => 100,
                "GET_COUNT_GOODS" => 18,
            ],
        ],
        "MATCHING" => [
            "GET_COUNT" => 100,
        ],
    ],
    "SEARCH_PARAM" => [
        "GOJUON" => [
            'あ行','か行','さ行','た行','な行','は行','ま行','や行','ら行','わ行','その他'
        ],
    ],
    "ACTRESS" => [
        "FLG" => [
            "DELETE_FLG" => [
                "ACTIVE" => 0, //有効
                "DISABLED" => 1 //無効
            ],
        ],
    ],
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
        "MATCHING" => [
            "ANSWER" => [
                "YES" => "YES",
                "NO" => "NO",
            ],
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
    "MAKER" => [
        "FLG" => [
            "DELETE_FLG" => [
                "ACTIVE" => 0, //有効
                "DISABLED" => 1 //無効
            ],
        ],
    ],
    "SERIES" => [
        "FLG" => [
            "DELETE_FLG" => [
                "ACTIVE" => 0, //有効
                "DISABLED" => 1 //無効
            ],
        ],
    ],
    'INFOMATION' => [
        "FLG" => [
            "DELETE_FLG" => [
                "ACTIVE" => 0, //有効
                "DISABLED" => 1 //無効
            ],
        ],
    ]
];
