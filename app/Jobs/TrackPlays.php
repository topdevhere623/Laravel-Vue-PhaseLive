<?php

namespace App\Jobs;

use App\User;
use App\Track;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackPlays implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Track
     */
    protected $track;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param Track $track
     * @param User $user
     */
    public function __construct(Track $track, User $user)
    {
        $this->track = $track;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->plays()->attach($this->track->id);
    }
}
