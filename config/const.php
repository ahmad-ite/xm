<?php

return [

 
    'rapidapi' => [
        'url'=>'https://yh-finance.p.rapidapi.com/stock/v3/',
        'X-RapidAPI-Key'=>env('X_RapidAPI_Key', 'XXXXXXXXXXXXXXXXXXXXXXXXXXX'),
        'X-RapidAPI-Host'=>'yh-finance.p.rapidapi.com',
    ],
    'datahub' => [
        'url'=>'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json',
    ]

    
    ];
