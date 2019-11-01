<?php

namespace App;

use NeoEloquent;
use Vinelab\NeoEloquent\Eloquent\Edges\Finder;

class Ip extends NeoEloquent
{
	protected $label = 'Ip';

	protected $guarded = [];
	public $timestamps = false;

	protected $fillable = ['ip_name','ip_definition'];

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
	    return $this->belongsToMany('App\Ip', 'RELATION');
	}

	public function whichRelation()
	{
	    return $this->morphMany('App\Relation','TO');
	}

    public function hosts()
    {
        return $this->morphMany('App\Relation','TO', 'RELATION');
    }


    public static function ipFakerCreate()
    {
        //$fakeIP = factory(Ip::class, 10)->create();
        $fakeIP = factory(Ip::class, 1000)->make();
        return $fakeIP;
        // Использование модели в тестах...
    }

}

?>
