<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * it has many stands
     */
    public function it_has_many_stands()
    {
    	$event = factory('App\Event')->create();
    	$stand = factory('App\Stand')->create(['event_id' => $event->id]);
        $this->assertInstanceOf(HasMany::class, $event->stands());
        $this->assertInstanceOf('App\Stand', $event->stands->first());
    	$this->assertEquals($event->stands()->first()->id, $stand->id);
    	$this->assertDatabaseHas('events', ['id' => $event->id]);
    	$this->assertDatabaseHas('stands', ['id' => $stand->id, 'event_id' => $event->id]);
    }

    /**
     * @test
     * it deletes all its stands before deleting itself
     */
    public function it_deletes_all_its_stands_before_deleting_itself()
    {
        $event = factory('App\Event')->create();
        $stand = factory('App\Stand')->create(['event_id' => $event->id]);

        $this->assertDatabaseHas('stands', ['id' => $stand->id]);
        
        $event->delete();

        $this->assertDatabaseMissing('stands', ['id' => $stand->id]);
    }
}
