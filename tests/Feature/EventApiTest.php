<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * it lists upcoming events in the proper format
     */
    public function it_lists_upcoming_events_in_the_proper_format()
    {
    	$event = factory('App\Event', 5)->create(['start_date' => Carbon::now()->addDays(2)]);
        $passed_events = factory('App\Event', 2)->create(['start_date' => Carbon::now()->addDays(-2)]);

    	$response = $this->getJson('/api/events')->json();

        $this->assertEquals($event->pluck('name')->all(), array_column($response ,'name'));
        $this->assertEquals($event->pluck('short_address')->all(), array_column($response ,'short_address'));
        $this->assertEquals($event->pluck('latitude')->all(), array_column($response ,'latitude'));
        $this->assertEquals($event->pluck('longitude')->all(), array_column($response ,'longitude'));
    }

    /**
     * @test
     * it fetches details of a event along with its stand details
     */
    public function it_fetches_details_of_a_event_along_with_its_stand_details()
    {
        $event = factory('App\Event')->create();
        $stands = factory('App\Stand', 5)->create(['event_id' => $event->id]);

        $response = $this->getJson("/api/events/{$event->id}")->json();

        $this->assertEquals($event->name, $response['name']);
        $this->assertCount(5, $response['stands']);
    }
    /**
     * @test
     * it fetches associated company details while fetching stands
     */
    public function it_fetches_associated_company_details_while_fetching_stands()
    {
        $event = factory('App\Event')->create();
        $stand = factory('App\Stand')->create(['event_id' => $event->id]);
        $company = factory('App\Company')->make()->toArray();

        $stand->assignCompany($company);

        $response = $this->getJson("/api/events/{$event->id}");
        $response->assertSee($company['name']);
    }
    /**
     * @test
     * it fetches marketing documents while fetching companies
     */
    public function it_fetches_marketing_documents_while_fetching_companies()
    {
        $event = factory('App\Event')->create();
        $stand = factory('App\Stand')->create(['event_id' => $event->id]);
        $company = factory('App\Company')->create(['stand_id' => $stand->id]);
        $document = factory('App\Document')->create(['company_id' => $company->id]);
        
        $response = $this->getJson("/api/events/{$event->id}");
        $response->assertSee($document['name']);
    }
}
