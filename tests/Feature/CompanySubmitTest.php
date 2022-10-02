<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;

use App\Models\Company;
use Illuminate\Support\Facades\Artisan;

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
     * A basic test example.
     *
     * @return void
     */
    public function test_a_basic_request()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * test Servers list
     */
    public function testFetchData()
    {



        // $this->customResponse = $this->getMockBuilder(ThirdPartyTrait::class)->getMockForTrait();
        $customResponse = $this->getMockBuilder('App\Traits\ThirdPartyTrait')->getMockForTrait();

        // $response = $customResponse->notFound();
        $data = [];
        $data['symbol'] = 'AMRN';
        $data['email'] = 'ahmad@gmail.com';
        $data['start_date'] = '09/01/2022';
        $data['end_date'] = '09/30/2022';

        Company::create(['symbol' => $data['symbol'], 'name' => 'test']);

        $response = $this->post('/fetchData', $data);

        // print_r(  json_decode(json_encode($response),1));
        $response->assertStatus(200);

        // print_r([$response]);
        // $response->assertJson(
        //     fn (AssertableJson $json) =>
        //     $json->where('message', 'Success')->where('success', true)
        //         ->has('data')
        // );
    }


    // public function testServersList()
    // {
    //     Server::factory()->count(2)->create();
    //     $response = $this->get('/api/servers/list?page=1&
    //     limit=5&min_storage=0&max_storage=2048&hdd_type=SATA&location=AmsterdamAMS-01');
    //     $response->assertStatus(200);
    //     $response->assertJson(
    //         fn (AssertableJson $json) =>
    //         $json->where('message', 'Success')->where('success', true)
    //             ->has('data')
    //     );
    // }


    /**
     * test Servers Location
     */
    // public function testServersLocations()
    // {
    //     Server::factory()->count(2)->create();
    //     $response = $this->get('/api/servers/locations');
    //     $response->assertStatus(200);
    //     $response->assertJson(
    //         fn (AssertableJson $json) =>
    //         $json->where('message', 'Success')->where('success', true)
    //             ->has('data')
    //     );
    // }
}
