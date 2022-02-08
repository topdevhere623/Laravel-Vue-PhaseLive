<?php

namespace App\Phase;

use App\File;
use App\Asset;
use Illuminate\Support\Str;
use Illuminate\Http\File as HttpFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageHandler
{
    public $asset;

    protected $path;

    protected $altText;

    protected $directory;

    protected $square = false;

    protected $visibility = 'public';

    public function filePath($file)
    {
        $this->path = $file;

        return $this;
    }

    public function directory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    public function square()
    {
        $this->square = true;

        return $this;
    }

    public function visibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function altText($text)
    {
        $this->altText = $text;

        return $this;
    }

    public function thumb()
    {
        $image = $this->resize('100');
        $this->save($image, 'thumb');

        return $this;
    }

    public function medium()
    {
        $image = $this->resize('350');
        $this->save($image, 'medium');

        return $this;
    }

    public function large()
    {
        $image = $this->resize('550');
        $this->save($image, 'large');

        return $this;
    }

    public function original()
    {
        $path = Storage::putFile(
            $this->directory,
            new HttpFile(storage_path("app/$this->path")),
            $this->visibility
        );

        $this->createAssetModel();
        $this->createFileModel($path, 'original');

        return $this;
    }

    public function removeLocalFile($file)
    {
        Storage::disk('local')->delete($file);
    }

    protected function resize(string $width, $height = null)
    {
        if ($this->square) {
            return Image::make(storage_path("app/$this->path"))
                ->orientate()
                ->fit($width)
                ->encode();
        }
        $height = $height ?? $width;

        return Image::make(storage_path("app/$this->path"))
            ->orientate()
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode();
    }

    protected function save($image, string $size)
    {
        $name = Str::random(32);
        Storage::disk('local')->put("temp/$name", $image->__toString());
        $path = Storage::putFile(
            $this->directory,
            new HttpFile(storage_path("app/temp/{$name}")),
            $this->visibility
        );
        Storage::disk('local')->delete("temp/$name");

        $this->createFileModel($path, $size);
    }

    protected function createFileModel($path, $size)
    {
        File::create([
            'asset_id' => $this->asset->id,
            'size' => $size,
            'path' => $path,
            'mime' => Storage::mimeType($path),
        ]);
    }

    protected function createAssetModel()
    {
        $this->asset = Asset::create([
            'alt' => $this->altText
        ]);
    }
}