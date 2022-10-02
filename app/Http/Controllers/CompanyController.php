<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Events\SendMail;
use App\Traits\ThirdPartyTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CompanySubmitRequest;

class CompanyController extends Controller
{
    use ThirdPartyTrait;
    public function index()
    {
        return view('index');
    }



    public function fetchData(CompanySubmitRequest $request)
    {

        // validate input 
        $inputData = $request->all();
        Validator::make($inputData, $request->rules(), $request->messages());

        //fetch Historical Data
        $result = $this->companyHistoricalData($inputData['symbol']);
        if (!$result) {
            return response('Invalid Server Error', 500)([
                'data' => null,

            ]);
        }


        //filter prices
        $startDate = strtotime($inputData['start_date']);
        $endDate = strtotime($inputData['end_date']);

        $prices = array_filter($result['prices'], function ($item) use ($startDate, $endDate) {
            return $item['date'] >= $startDate && $item['date'] <= $endDate;
        });

        $result['prices'] = array_values($prices);



        //Send Email by event 
        $emailData = Company::where('symbol', $inputData['symbol'])->first();

        $emailData['to'] = $inputData['email'];
        $emailData['start_date'] = $inputData['start_date'];
        $emailData['end_date'] = $inputData['end_date'];
        event(new SendMail($emailData));

        return response()->json([
            'data' => $result
        ]);
    }
}
