<?php

namespace App;

use App\Event;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidEventException;

class Stand extends Model
{
	protected $guarded = ['event_id', 'is_booked'];
	
	/**
	 * the booting method of the model
	 */
	protected static function boot()
	{
		parent::boot();
		static::creating(function($stand){
			$event = Event::find($stand->event_id);
			if (!$event) {
				throw new InvalidEventException('A Stand requires a valid Event.');
			}
		});
	}

    /**
	 * a stand belongs to a event
	 * @return [type] [description]
	 */
	public function event()
	{
		return $this->belongsTo('App\Event');
	}
}
