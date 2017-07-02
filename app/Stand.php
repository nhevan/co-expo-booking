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

	/**
	 * it has one owner company
	 * @return [type] [description]
	 */
	public function company()
	{
		return $this->hasOne('App\Company');
	}
	/**
	 * it can assign a company to itself and changes it is_booked status
	 * @param  array  $company_attributes [description]
	 * @return [type]                     [description]
	 */
	public function assignCompany($company_attributes = [])
	{
		$this->company()->create($company_attributes);
		$this->is_booked = true;
		return $this->save();
	}
}
