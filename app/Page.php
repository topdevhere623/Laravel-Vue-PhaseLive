<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * A top level router-view view which will get sent to Vue and is navigable to using the Vue Router
 *
 * Class Page
 * @package App
 */
class Page extends PhaseModel
{
    use SoftDeletes, SearchableTrait;

    protected $fillable = ['title', 'path', 'name', 'user_id', 'parent_id', 'component_id'];

    protected $searchable = [
        'columns' => [
            'title' => 10,
            'path' => 5,
            'name' => 10,
        ],
    ];

	public function parent()
	{
		return $this->belongsTo('App\Page', 'parent_id');
	}

	public function children()
	{
		return $this->hasMany('App\Page', 'parent_id');
	}

    public function metas($key = null)
    {
        $query = $this->morphMany('App\Meta','metable');

        if ( ! is_null($key))
        {
            $query = $query->where('key', $key)->first();
        }

        return $query;
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function component()
    {
    	return $this->belongsTo('App\Component');
    }

    public function scopeIsParent($query)
    {
    	return $query->where('parent_id', null);
    }
}
