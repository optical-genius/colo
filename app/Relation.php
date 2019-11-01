<?php

namespace App;

use NeoEloquent;

class Relation extends NeoEloquent
{
	protected $label = 'Relation';

	protected $guarded = [];
	public $timestamps = false;

	protected $fillable = ['relation_name','relation_description'];

	public function subject()
	{
        return $this->morphMany('App\Host','TO');
    }

    public function object()
    {
        return $this->morphMany('App\Host','RELATION');
    }

}

?>
