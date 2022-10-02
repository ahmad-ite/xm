<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ThirdPartyTrait
{

    public function companiesList()
    {

        $response = Http::get(config('const.datahub')['url']);
        if ($response->failed()) {
            return [];
        }
        return $response->json();
    }

    public function companyHistoricalData($symbol, $region = 'US')
    {

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => config('const.rapidapi')['X-RapidAPI-Key'] ,
            'X-RapidAPI-Host' => config('const.rapidapi')['X-RapidAPI-Host']
        ])->get(config('const.rapidapi')['url'].'get-historical-data', [
            'symbol' => $symbol,
            'region' => $region,
        ]);

        if ($response->failed()) {
            return null;
        }
        return $response->json();
    }
}
