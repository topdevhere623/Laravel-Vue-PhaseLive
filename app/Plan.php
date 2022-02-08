<?php

namespace App;

use App\Traits\Image;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Plan extends Model
{
	use Image, SearchableTrait;

    protected $fillable = ['title', 'price', 'subtitle', 'content', 'image_id'];

    protected $with = ['image', 'role'];

    protected $searchable = [
        'columns' => [
            'title' => 10
        ]
    ];

    public function role()
    {
        return $this->hasOne(config('permission.models.role'), 'id', 'role_id');
    }
}

