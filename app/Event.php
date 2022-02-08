<?php

namespace App;

use App\Traits\Shareable;

use App\Phase\ImageManager;

/**
 * Class Event
 *
 * An Event is a user created Event e.g. concert / gig / show
 *
 * @package App
 */
class Event extends PhaseModel
{
    use Shareable;

    protected $guarded = [];

    protected $with = ['user', 'image'];

    protected $appends = [
        'is_shared',
        // 'shares_count',
        'is_recent'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function image()
    {
        return $this->belongsTo('App\Asset');
    }

    public function saveImage($file)
    {
        $manager = ImageManager::resource($file)
            ->directory('event_images')
            ->altText('Event Image')
            ->storeMedium()
            ->storeThumb();

        $this->image_id = $manager->asset->id;
        $this->save();

        return $this->image;
    }

    public function scopeDateNotNull($query)
    {
        // return $query->where('date', '<>', '');
        return $query->whereNotNull('date');
    }

    public function getIsRecentAttribute()
    {
        return $this->created_at->diffInDays() < 7;
    }
}
