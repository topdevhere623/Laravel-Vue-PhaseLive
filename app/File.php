<?php

namespace App;

use Storage;

/**
 * Class File
 *
 * Represents a referable single file in storage
 *
 * @package App
 */
class File extends PhaseModel
{
    protected $fillable = ['asset_id', 'size', 'path', 'mime'];

    //    protected $with = ['asset'];

    protected $appends = ['url'];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function getUrlAttribute()
    {
        return $this->tempUrl(5);
    }

    public function scopeSize($query, $size)
    {
        return $query->where('size', $size);
    }

    public function tempUrl($minutes)
    {
        return Storage::temporaryUrl(
            $this->path,
            now()->addMinutes($minutes),
            ['ResponseContentDisposition' => 'attachment;']
        );
    }
}
