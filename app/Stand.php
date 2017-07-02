<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    /**
	 * a stand belongs to a event
	 * @return [type] [description]
	 */
	public function event()
	{
		return $this->belongsTo('App\Event');
	}
}
