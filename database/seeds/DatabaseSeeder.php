<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->createEventOne();
    	$this->createEventTwo();
    }

    public function createEventOne()
    {
    	$start_date = Carbon::now()->addDays(10);
    	$end_date = Carbon::now()->addDays(13);
    	$event1 = factory('App\Event')->create(['start_date'=> $start_date, 'end_date'=> $end_date]);

    	$stand_1 = factory('App\Stand')->create([
    		'event_id' => $event1->id,
    		'breadth' => 103,
    		'length' => 150,
    		'x_cord' => 10,
    		'y_cord' => 10,
    		'is_booked' => 1
		]);
		$company = factory('App\Company')->create(['stand_id'=>$stand_1->id]);
		factory('App\Document')->create(['company_id'=>$company->id]);
		factory('App\Document')->create(['company_id'=>$company->id]);

		$stand_2 = factory('App\Stand')->create([
    		'event_id' => $event1->id,
    		'breadth' => 200,
    		'length' => 150,
    		'x_cord' => 140,
    		'y_cord' => 200
		]);

		$stand_3 = factory('App\Stand')->create([
    		'event_id' => $event1->id,
    		'breadth' => 60,
    		'length' => 80,
    		'x_cord' => 390,
    		'y_cord' => 142,
    		'is_booked' => 1
		]);
		$company2 = factory('App\Company')->create(['stand_id'=>$stand_3->id]);
		factory('App\Document')->create(['company_id'=>$company2->id]);
		factory('App\Document')->create(['company_id'=>$company2->id]);

		$stand_4 = factory('App\Stand')->create([
    		'event_id' => $event1->id,
    		'breadth' => 53,
    		'length' => 80,
    		'x_cord' => 455,
    		'y_cord' => 142
		]);
    }
    public function createEventTwo()
    {
    	$start_date = Carbon::now()->addDays(15);
    	$end_date = Carbon::now()->addDays(18);
    	$event2 = factory('App\Event')->create(['start_date'=> $start_date, 'end_date'=> $end_date]);

    	$stand_1 = factory('App\Stand')->create([
    		'event_id' => $event2->id,
    		'breadth' => 103,
    		'length' => 150,
    		'x_cord' => 10,
    		'y_cord' => 10
		]);

		$stand_2 = factory('App\Stand')->create([
    		'event_id' => $event2->id,
    		'breadth' => 200,
    		'length' => 150,
    		'x_cord' => 140,
    		'y_cord' => 200,
    		'is_booked' => 1
		]);
		$company = factory('App\Company')->create(['stand_id'=>$stand_2->id]);
		factory('App\Document')->create(['company_id'=>$company->id]);
		factory('App\Document')->create(['company_id'=>$company->id]);

		$stand_3 = factory('App\Stand')->create([
    		'event_id' => $event2->id,
    		'breadth' => 60,
    		'length' => 80,
    		'x_cord' => 390,
    		'y_cord' => 142,
    		'is_booked' => 1
		]);
		$company2 = factory('App\Company')->create(['stand_id'=>$stand_3->id]);
		factory('App\Document')->create(['company_id'=>$company2->id]);
		factory('App\Document')->create(['company_id'=>$company2->id]);

		$stand_4 = factory('App\Stand')->create([
    		'event_id' => $event2->id,
    		'breadth' => 53,
    		'length' => 80,
    		'x_cord' => 455,
    		'y_cord' => 142
		]);
    }
}
