<?php

namespace App;

use App\Phase\ImageManager;

class Merch extends PhaseModel
{
    protected $guarded = [];

    protected $with = ['image'];

    protected $casts = [
        'links' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function image()
    {
        return $this->hasOne('App\Asset', 'id', 'image_id');
    }

    public function saveImage($file)
    {
        $manager = ImageManager::resource($file)
            ->directory('merch')
            ->altText('Product Image')
            ->square()
            ->storeOriginal()
            ->storeLarge()
            ->storeMedium()
            ->storeThumb();

        $this->image_id = $manager->asset->id;
        $this->save();

        return $this->image;
    }

    public function scopeNameNotNull($query){
        return $query->where('title', '<>', '');
    }

}
