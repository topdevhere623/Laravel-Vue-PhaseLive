<?php

namespace App;

/**
 * Class Asset
 *
 * An asset represents a group of the same / similar / related files. E.g. if a user uploads an avatar, we will create
 * multiple files at different resolutions. These files will each have individual file models associated with them but
 * are considered a single asset.
 *
 * Another example is videos. A video will have an original file, a transcoded playlist file and a thumbnail file but
 * these files are all considered a single asset.
 *
 * @package App
 */
class Asset extends PhaseModel
{
    protected $fillable = ['alt'];

    protected $with = [
//        'files',
//        'medium_file'
    ];

    protected $appends = [
        'mimeType',
        'files'
    ];

    public function track()
    {
        return $this->hasOne('App\Track');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function getMimeTypeAttribute()
    {
        return $this->files()->first()['mime'];
    }

    public function getFilesAttribute()
    {
        return $this->files()->get()->keyBy('size');
    }

    public function mediumFile()
    {
        return $this->belongsTo(File::class);
    }

    public function scopeMediumFileSize($query)
    {
        $query->addSelect(['medium_file_id' => File::select('id')
                ->whereColumn('asset_id', 'assets.id')
                ->where('size', 'medium')
                ->latest()
                ->take(1)
            ])->with('mediumFile');
    }

    public function scopeFileBySize($query, $size)
    {
        return $this->files()
                    ->where('size', $size)
                    ->first();
    }
}
