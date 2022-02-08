<?php

namespace App\Traits;

//ini_set('memory_limit', '512M');

use Illuminate\Support\Str;
use App\Jobs\ProcessCoverUpload;
use Illuminate\Support\Facades\Storage;

trait Image
{
    public function saveCoverImage($file, $name = null)
    {
        $altText = !is_null($name) ? $name . ' Cover Image' : 'Cover Image';

        $localName = Str::random(32);
        $path = Storage::disk('public')->put("temp/$localName", $file);

        ProcessCoverUpload::dispatch($this, $path, $altText);

        return $this->image;
    }

//    public function image()
//    {
//        return $this->hasOne('App\Asset', 'id', 'image_id');
//    }

    public function image()
    {
        return $this->hasOne('App\Asset', 'id', 'image_id');
//            ->mediumFileSize();
    }
}
