<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StandReservationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * a company can reserve a stand
     */
    public function a_company_can_reserve_a_stand()
    {
        $stand = factory('App\Stand')->create();
    	$company = factory('App\Company')->make()->toArray();

        $this->post("/api/stands/{$stand->id}/reserve", $company);
        $this->assertDatabaseHas('companies', ['name' => $company['name'], 'stand_id' => $stand->id]);
    }

    /**
     * @test
     * it validates company name while reserving a stand
     */
    public function it_validates_company_name_while_reserving_a_stand()
    {
        $stand = factory('App\Stand')->create();
        $company = factory('App\Company')->make(['name' => null])->toArray();

        $this->withExceptionHandling()->post("/api/stands/{$stand->id}/reserve", $company)
             ->assertSessionHasErrors('name');
    }

    /**
     * @test
     * it validates company logo while reserving a stand
     */
    public function it_validates_company_logo_while_reserving_a_stand()
    {
        $stand = factory('App\Stand')->create();
        $company = factory('App\Company')->make(['logo' => null])->toArray();

        $response = $this->withExceptionHandling()->post("/api/stands/{$stand->id}/reserve", $company);
        
        $response->assertSessionHasErrors('logo');
    }
}