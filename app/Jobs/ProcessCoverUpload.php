<?php

namespace App\Jobs;

use App\Phase\ImageHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessCoverUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;

    protected $path;

    protected $altText;

    /**
     * Create a new job instance.
     *
     * @param $model
     * @param $path
     * @param $altText
     */
    public function __construct($model, $path, $altText)
    {
        $this->model = $model;
        $this->path = $path;
        $this->altText = $altText;
    }

    /**
     * Execute the job.
     *
     * @param ImageHandler $handler
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(ImageHandler $handler)
    {
        $handler->filePath('public/' . $this->path)
            ->directory('covers')
            ->square()
            ->visibility('public')
            ->altText($this->altText)
            ->original()
            ->large()
            ->medium()
            ->thumb()
            ->removeLocalFile('public/' . $this->path);

        $this->model->image_id = $handler->asset->id;
        $this->model->save();
    }
}
