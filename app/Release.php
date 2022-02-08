<?php

namespace App;

use App\Traits\Image;
use App\Traits\Likeable;
use App\Traits\Shareable;
use App\Traits\Reportable;
use App\Phase\ReleaseClass;
use App\Traits\Commentable;
use App\Phase\Chart\ScoreGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class Release
 *
 * A selection of grouped tracks all release at the same time. Can be classed as an 'album' or a 'single' etc...
 *
 * @package App
 */
class Release extends PhaseModel
{
    use Shareable, SoftDeletes, Image, Likeable, Commentable, Reportable, SearchableTrait, HasSlug;

    protected $fillable = ['name', 'description', 'status', 'price', 'class', 'release_date', 'featured', 'uploaded_by', 'royalty_fee'];

    protected $with = ['image'];

    protected $appends = [
        'is_liked',
        'is_shared',
        'is_recent'
    ];

    protected $dates = [
        'release_date',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    protected $searchable = [
        'columns' => [
            'releases.name' => 10,
            'users.name' => 1,
        ],
        'joins' => [
            'users' => ['users.id', 'releases.uploaded_by']
        ]
    ];

    public function user_carts()
    {
        return $this->morphToMany('App\User', 'taggable')
            ->withPivot('download_format')
            ->withTimestamps();
    }

    public function uploader()
    {
        return $this->belongsTo('App\User', 'uploaded_by');
    }

    public function tracks()
    {
        return $this->hasMany('App\Track', 'release_id');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'release_track_genres');
    }

    public function orders()
    {
        return $this->morphToMany('App\Order', 'orderable')->withPivot('format', 'price');
    }

    public function setStatusAttribute($status)
    {
        $allowed = ['pending', 'live', 'offline'];
        if (in_array($status, $allowed)) {
            $this->attributes['status'] = $status;
        } else {
            $this->attributes['status'] = 'offline';
        }
    }

    public function setClassAttribute($key)
    {
        if (ReleaseClass::valid($key)) {
            $this->attributes['class'] = $key;
        }
    }

    public function scopeFeatured($query)
    {
        //    return $query->where('featured', 1);
        return $query->whereHas('featuredDates', function ($query) {
            $query->whereDate('featured_date', now()->startOfDay());
        })->get();
    }

    public function scopeStatusPending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopeStatusLive($query)
    {
        return $query
            ->where('status', 'live')
            ->where('frozen_at', null);
        //            ->with('image');
    }
    public function scopeStatusOffline($query)
    {
        return $query->where('status', 'offline');
    }
    public function scopeReleased($query)
    {
        return $query
            ->where('release_date', '<=', startOfToday())
            ->where('status', 'live')
            ->where('frozen_at', null);
    }
    public function scopeUnreleased($query)
    {
        return $query->where('release_date', '>', startOfToday());
    }

    public function price($format = 'mp3')
    {
        switch ($format) {
            case 'mp3':
                return $this->price;
            case 'wav':
                return $this->price + (setting('wav_fee') * count($this->tracks));
            default:
                return null;
        }
    }

    public function approve()
    {
        $this->status = 'live';
        $this->save();
    }

    public function takeOffline()
    {
        $this->status = 'offline';
        $this->save();
    }

    public function makeLive()
    {
        $this->status = 'live';
        $this->save();
    }

    public function freeze()
    {
        //        $this->status = 'frozen';
        $this->frozen_at = now();
        $this->save();
    }

    public function unfreeze()
    {
        $this->frozen_at = null;
        $this->save();
    }

    public function featuredDates()
    {
        return $this->hasMany('App\FeaturedReleaseDates', 'release_id');
    }

    public function isFeatured()
    {
        return $this->featuredDates()->count() ? true : false;
    }

    public function getScoreAttribute()
    {
        return ScoreGenerator::generate($this);
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

    public function getUploaderNameAttribute()
    {
        return $this->uploader->name;
    }

    public function getIsRecentAttribute()
    {
        return $this->created_at->diffInDays() < 7;
    }

    /**
     * Return the royalty fee in a human friendly format
     */
    public function getRoyaltyFeeAttribute()
    {
        return $this->attributes['royalty_fee'] * 100;
    }

    /**
     * Set the human friendly royalty fee in a computer friendly format
     *
     * @param   int  $fee
     */
    public function setRoyaltyFeeAttribute(int $fee)
    {
        $this->attributes['royalty_fee'] = $fee / 100;
        return $this->save();
    }
}
