<?php

namespace App\Phase;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Asset;
use App\File;

/**
 * Class for managing images. Used to easily resize and save an uploaded image file to storage and database.
 *
 * Class ImageManager
 * @package App\Phase
 */
class ImageManager
{
    private $resource, $directory, $altText;
    private $square = false;
    private $visibility = 'public';

    public $asset;

    /**
     * Static method to return new instance of class given a file object
     *
     * @param  \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile  $resource
     * @return ImageManager
     */
    public static function resource($resource)
    {
        return new self($resource);
    }

    /**
     * ImageManager constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Set whether or not images saved after this method is called should
     * be resized and cropped to be square
     *
     * @param  bool  $square
     * @return $this
     */
    public function square($square = true)
    {
        $this->square = $square;

        return $this;
    }

    /**
     * Set storage directory to store the file in
     *
     * @param $directory
     * @return $this
     */
    public function directory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Set alt text for the image
     *
     * @param $text
     * @return $this
     */
    public function altText($text)
    {
        $this->altText = $text;

        return $this;
    }

    /**
     * Set the visibilty for the uploaded file e.g. 'public'
     *
     * @param $visibility
     * @return $this
     */
    public function visibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Store the file at a given size
     *
     * @param $name
     * @param $size
     * @return $this
     */
    public function store($image, $size)
    {
        $localName = Str::random(32);
        Storage::disk('local')->put("temp/$localName", $image->__toString());
        $path = Storage::putFile(
            $this->directory,
            new HttpFile(storage_path("app/temp/{$localName}")),
            $this->visibility);
        Storage::disk('local')->delete("temp/$localName");
        $this->createFileModel($size, $path);

        return $this;
    }

    /**
     * Store the original file
     *
     * @return $this
     */
    public function storeOriginal()
    {
        $path = Storage::putFile($this->directory, $this->resource, $this->visibility);
        $this->createFileModel('original', $path);

        return $this;
    }

    /**
     * Store the image at a large size
     *
     * @return $this
     */
    public function storeLarge()
    {
        $image = $this->resize('550');
        $this->store($image, 'large');

        return $this;
    }

    /**
     * Store the image at a medium size
     *
     * @return $this
     */
    public function storeMedium()
    {
        $image = $this->resize('350');
        $this->store($image, 'medium');

        return $this;
    }

    /**
     * Store the image at a thumbnail size
     *
     * @return $this
     */
    public function storeThumb()
    {
        $image = $this->resize('100');
        $this->store($image, 'thumb');

        return $this;
    }

    /**
     * Create an asset in the database which the files will belong to
     */
    private function createAssetModel()
    {
        if (!$this->asset) {
            $this->asset = Asset::create([
                'alt' => $this->altText,
            ]);
        }
    }

    /**
     * Create a file model for the stored file
     *
     * @param $size
     * @param $path
     */
    private function createFileModel($size, $path)
    {
        $this->createAssetModel();
        File::create([
            'asset_id' => $this->asset->id,
            'size' => $size,
            'path' => $path,
            'mime' => Storage::mimeType($path),
        ]);
    }

    /**
     * Decide whether or not to resize the image as a square or rectangle
     *
     * @param $size
     * @return mixed
     */
    private function resize($size)
    {
        if ($this->square) {
            return $this->resizeSquare($size)->encode();
        } else {
            return $this->resizeRect($size)->encode();
        }
    }

    /**
     * Resize and crop an image to be square
     *
     * @param $size
     * @return mixed
     */
    private function resizeSquare($size)
    {
        return Image::make($this->resource)
            ->fit($size);
    }

    /**
     * Resize an image preserving its aspect ratio. Resized images will not have a width or height greater than $size
     *
     * @param $size
     * @return mixed
     */
    private function resizeRect($size)
    {
        $image = Image::make($this->resource);
        if ($image->width() > $image->height()) { //landscape
            $image->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $image->resize(null, $size, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        return $image;
    }
}
