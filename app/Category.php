<?php

namespace App;

/**
 * Class Category
 *
 * A news article category
 *
 * @package App
 */
class Category extends PhaseModel
{
    public function news()
    {
    	return $this->belongsToMany('App\News');
    }
}
