<?php

namespace App;

use NeoEloquent;

class Host extends NeoEloquent
{
	protected $label = 'Host';

	protected $guarded = [];
	public $timestamps = false;

	protected $fillable = ['host_name','host_definition'];

	public function author()
    {
        return $this->belongsTo('App\User', 'CREATED');
    }

	public function relationship($morph=null)
	{
	    return $this->hyperMorph($morph, 'App\Relation', 'RELATION', 'TO');
	}

	public function object()
	{
	    return $this->belongsToMany('App\Host', 'RELATION');
	}

	public function whichRelation()
	{
	    return $this->morphMany('App\Relation','TO');
	}


}

?>
