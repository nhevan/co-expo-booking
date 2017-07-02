<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
	 * a document has a owner company
	 * @return [type] [description]
	 */
    public function owner()
    {
    	return $this->belongsTo('App\Company', 'company_id');
    }
}
