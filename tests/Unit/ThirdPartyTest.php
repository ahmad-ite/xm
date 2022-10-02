<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Traits\ThirdPartyTrait;


class ThirdPartyTest extends TestCase

{
    use ThirdPartyTrait;

    /**
     * test Companies List Call
     */
    public function testCompaniesList()
    {
        $data = $this->companiesList();

        // $this->assertEquals($res, 1024 * 2);

        $this->assertGreaterThan(0, count((array)$data));
        $this->assertArrayHasKey('Symbol', (array)$data[0]);
        $this->assertArrayHasKey('Company Name', (array)$data[0]);
    }

    /**
     * test company Historical Data
     */
    public function testCompanyHistoricalData()
    {
        $data = $this->companyHistoricalData('AMRN');


        $this->assertArrayHasKey('prices', $data);
        $this->assertArrayHasKey('isPending', $data);
        $this->assertArrayHasKey('firstTradeDate', $data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('timeZone', $data);
        $this->assertGreaterThan(
            0,
            count($data['prices'])
        );
        $this->assertArrayHasKey('date', $data['prices'][0]);
        $this->assertArrayHasKey('open', $data['prices'][0]);
        $this->assertArrayHasKey('high', $data['prices'][0]);
        $this->assertArrayHasKey('low', $data['prices'][0]);
        $this->assertArrayHasKey('close', $data['prices'][0]);
        $this->assertArrayHasKey('volume', $data['prices'][0]);
        $this->assertArrayHasKey('adjclose', $data['prices'][0]);
    }


    /**
     * test company Historical Data Nout Found
     */
    public function testCompanyHistoricalDataNotFound()
    {
        $data = $this->companyHistoricalData('not-found');
        $this->assertEquals($data, null);
    }
}
