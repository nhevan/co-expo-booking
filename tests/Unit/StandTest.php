<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * it belongs to a event
     */
    public function it_belongs_to_a_event()
    {
    	$event = factory('App\Event')->create();
    	$stand = factory('App\Stand')->create(['event_id' => $event->id]);
    	$this->assertInstanceOf(BelongsTo::class, $stand->event());
    	$this->assertInstanceOf('App\Event', $stand->event);
    }

    /**
     * @test
     * it throws InvalidEventException if no valid event id is given
     */
    public function it_throws_InvalidEventException_if_no_valid_event_id_is_given()
    {
        $this->expectException('App\Exceptions\InvalidEventException');
        $stand = factory('App\Stand')->create(['event_id' => 5]);
    }
}
