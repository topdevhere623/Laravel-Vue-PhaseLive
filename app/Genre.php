<?php

namespace App;

use App\Traits\Image;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class Genre
 *
 * A musical genre used to group tracks / releases
 *
 * @package App
 */
class Genre extends PhaseModel
{
    use SoftDeletes, Image, SearchableTrait, HasSlug;

    protected $fillable = ['name', 'image_id'];

    protected $hidden = ['image_id'];

    protected $with = ['image'];

    protected $searchable = [
        'columns' => [
            'name' => 10
        ]
    ];

    public function releases()
    {
        return $this->belongsToMany('App\Release', 'release_track_genres', 'genre_id', 'release_id')
            ->latest();
    }

    public function tracks()
    {
        return $this->belongsToMany('App\Track', 'release_track_genres', 'genre_id', 'track_id');
    }

    public function samples()
    {
        return $this->belongsToMany('App\Release', 'release_track_genres', 'genre_id', 'release_id')
            ->where('class', 'sample')->latest('release_date');
    }

    public function scopeNameNotNull($query){
        return $query->where('name', '<>', '');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
