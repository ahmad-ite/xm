<?php

namespace App\Helpers;

use App\Models\Company;
use App\Traits\ThirdPartyTrait;


class Helper
{
    use ThirdPartyTrait;

    /**
     * sync companies in DB
     */
    static function syncCompanies()
    {
        $oldCompanies = Company::all()->keyBy('symbol');
        $data = self::companiesList();

        $allinterests = [];
        foreach ($data as $item) { // $interests array contains input data
            if (isset($oldCompanies[$item['Symbol']])) {
                continue;
            }
            $company = [];
            $company['symbol'] = $item['Symbol'];
            $company['name'] = $item['Company Name'];
            $allinterests[] = $company;
        }
        Company::insert($allinterests);
    }
}
