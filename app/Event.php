<?php

namespace App;

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
