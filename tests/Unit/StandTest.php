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
}
