<?php

namespace App\Jobs;

use App\Track;
use Illuminate\Bus\Queueable;
use App\Phase\AudioTranscoder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTrackUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $track;

    /**
     * Create a new job instance.
     *
     * @param Track $track
     * @param $file
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    /**
     * Execute the job.
     *
     * @param AudioTranscoder $transcoder
     *
     * @return void
     * @throws \getid3_exception
     */
    public function handle(AudioTranscoder $transcoder)
    {
        $transcoder->setTrack($this->track);
        $transcoder->transcodePreview();
        $transcoder->transcodeStreamable();
    }
}
