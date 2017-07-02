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
     * it lists events in the proper format
     */
    public function it_lists_events_in_the_proper_format()
    {
    	$event = factory('App\Event', 5)->create();
    	$response = $this->getJson('/api/events')->json();
    	
        $this->assertEquals($event->pluck('name')->all(), array_column($response ,'name'));
        $this->assertEquals($event->pluck('short_address')->all(), array_column($response ,'short_address'));
        $this->assertEquals($event->pluck('latitude')->all(), array_column($response ,'latitude'));
        $this->assertEquals($event->pluck('longitude')->all(), array_column($response ,'longitude'));
    }
}
