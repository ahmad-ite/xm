<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Events\SendMail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class CompanySubmitTest extends TestCase
{
    use DatabaseMigrations;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:refresh --env=testing');
    }

    /**
     * test index request.
     *
     * @return void
     */
    public function test_a_index_request()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * test Servers list
     */
    public function testFetchData()
    {

        //fake SendMail Event
        Event::fake([
            SendMail::class
        ]);

        $data = [];
        $data['symbol'] = 'AMRN';
        $data['email'] = 'ahmad@gmail.com';
        $data['start_date'] = '09/01/2022';
        $data['end_date'] = '09/30/2022';


        //add company
        Company::create(['symbol' => $data['symbol'], 'name' => 'test']);

        $response = $this->post('/fetchData', $data);
        Event::assertDispatched(SendMail::class);
        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->has('data')
        );
    }

    public function testFetchDataInvalidInput()
    {

        $data = [];
        $data['symbol'] = 'AMRN';
        $data['email'] = 'ahmad@gmail.com';
        $data['start_date'] = '09/01/2022';
        $data['end_date'] = '09/30/2022';
        $response = $this->post('/fetchData', $data);
        $response->assertStatus(302);
    }
}
