<?php

namespace App;

use App\Jobs\SendEventSummaryEmails;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	/**
	 * the booting method of the model
	 */
	protected static function boot()
	{
		parent::boot();

		static::deleting(function($event){
			$event->stands->each->delete();
		});

		static::created(function($event){
        	$job = (new SendEventSummaryEmails($event))
        		   ->onQueue('event_summary')
        		   ->delay($event->end_date);
        		   
        	dispatch($job);
        });
	}

	/**
	 * A event has many stands
	 * @return [type] [description]
	 */
    public function stands()
    {
    	return $this->hasMany('App\Stand');
    }

    public function addStand($stand_attributes = [])
    {
    	$this->stands()->create($stand_attributes);
    }
}
