<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    /**
     * @test
     * it may or may not have a associated company
     */
    public function it_may_or_may_not_have_a_associated_company()
    {
        $stand = factory('App\Stand')->create();
        $this->assertInstanceOf(HasOne::class, $stand->company());
        $this->assertEquals(0, $stand->company()->count());
        $company = factory('App\Company')->create(['stand_id' => $stand->id]);
        $this->assertEquals(1, $stand->company()->count());
        $this->assertNotEquals(0, $stand->company()->count());
    }

    /**
     * @test
     * it can assign a company to itself
     */
    public function it_can_assign_a_company_to_itself()
    {
        $stand = factory('App\Stand')->create();
        $company = factory('App\Company')->make()->toArray();
        $this->assertDatabaseMissing('companies', ['stand_id' => $stand->id]);
        $stand->assignCompany($company);
        $this->assertInstanceOf('App\Company', $stand->company);
        $this->assertDatabaseHas('companies', ['stand_id' => $stand->id]);
    }
    
    /**
     * @test
     * it changes is booked status when it assigns a company
     */
    public function it_changes_is_booked_status_when_it_assigns_a_company()
    {
        $stand = factory('App\Stand')->create();
        $company = factory('App\Company')->make()->toArray();
        $this->assertEquals(false, $stand->is_booked);
        $stand->assignCompany($company);
        $this->assertEquals(true, $stand->is_booked);
    }
}
