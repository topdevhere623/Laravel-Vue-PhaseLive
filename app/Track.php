<?php

namespace App;

use App\Phase\MusicKey;
use App\Traits\Likeable;
use App\Traits\Shareable;
use App\Traits\Reportable;
use App\Traits\Commentable;
use App\Phase\AudioTranscoder;
use App\Jobs\ProcessTrackUpload;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class Track
 *
 * A single musical track. (a 'song')
 *
 * @package App
 */
class Track extends PhaseModel
{
    use Shareable, Likeable, Commentable, Reportable, SearchableTrait, SoftDeletes, HasSlug;

    protected $fillable = ['name', 'length', 'bpm', 'key', 'price', 'image'];

    protected $with = [
        'preview',
    ];

    protected $appends = [
        'is_liked',
        'is_shared',
        'is_recent'
    ];

    protected $searchable = [
        'columns' => [
            'tracks.name' => 10,
            'releases.name' => 5,
            //            'users.name' => 1
        ],
        'joins' => [
            'releases' => ['tracks.release_id', 'releases.id'],
            //            'users' => ['users.id', 'tracks.uploaded_by']
        ]
    ];

    protected $dates = ['deleted_at'];

    //    public function image()
    //    {
    //    	return $this->hasOne('App\Asset', 'id', 'image_id');
    //    }

    public function user_carts()
    {
        return $this->morphToMany('App\User', 'cartable')
            ->withPivot('download_format')
            ->withTimestamps();
    }

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function preview()
    {
        return $this->belongsTo('App\Asset');
    }

    public function streamable()
    {
        return $this->belongsTo('App\Asset');
    }

    public function release()
    {
        return $this->belongsTo('App\Release')->with('uploader');
    }

    public function artist()
    {
        return $this->belongsTo('App\User', 'uploaded_by');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'release_track_genres');
    }

    public function orders()
    {
        return $this->morphToMany('App\Order', 'orderable')->withPivot('format', 'price');
    }

    public function downloads()
    {
        return $this->hasMany('App\Download');
    }

    public function playlists()
    {
        return $this->belongsToMany('App\Playlist');
    }

    public function setKeyAttribute($key)
    {
        if (MusicKey::valid($key)) {
            $this->attributes['key'] = $key;
        }
    }

    public function price($format = 'mp3')
    {
        switch ($format) {
            case 'mp3':
                return $this->price;
            case 'wav':
                return $this->price + setting('wav_fee');
            default:
                return null;
        }
    }

    public function saveTrackFile($file, $format)
    {
        $asset = Asset::create([
            'alt' => 'Original Track'
        ]);
        $this->asset_id = $asset->id;
        $this->save();

        $id3 = new \getID3();
        $trackData = $id3->analyze($file, $file->getSize(), $file->getClientOriginalName());
        $fileFormat = $trackData['fileformat'];
        $fileRandom = Str::random(40);
        $localPath = Storage::disk('public')->putFileAs('temp/tracks', $file,  $fileRandom . '.' . $fileFormat);
        $path = Storage::putFileAs('tracks', $file, $fileRandom . '.' . $fileFormat, 'private');

        $this->length = floor($trackData['playtime_seconds']);
        $this->save();

        $fileModel = File::create([
            'asset_id' => $asset->id,
            'size' => $trackData['fileformat'],
            'path' => $path,
            'mime' => Storage::mimeType($path),
        ]);

        Storage::disk('local')->delete($localPath);

        ProcessTrackUpload::dispatch($this);
    }

    public function scopeNameNotNull($query)
    {
        return $query->where('name', '<>', '');
    }

    public function approved()
    {
        return $this->status === 'approved';
    }

    public function approve()
    {
        $this->status = 'approved';
        $this->save();
    }

    public function freeze()
    {
        $this->frozen_at = now();
        $this->save();
    }

    public function unFreeze()
    {
        $this->frozen_at = null;
        $this->save();
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

    public function getIsRecentAttribute()
    {
        return $this->created_at->diffInDays() < 7;
    }
}
