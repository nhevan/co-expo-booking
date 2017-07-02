<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = ['stand_id'];
    protected $with = ['documents'];

    /**
     * the booting method of the model
     */
    protected static function boot()
	{
		parent::boot();
	
		static::deleting(function($company){
			$company->documents->each->delete();
		});
	}

    /**
	 * a company belongs to a stand
	 * @return [type] [description]
	 */
    public function stand()
    {
    	return $this->belongsTo('App\Stand');
    }

    /**
     * a company has many marketing documents
     * @return [type] [description]
     */
    public function documents()
    {
    	return $this->hasMany('App\Document');
    }
}
