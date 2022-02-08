<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Subscription;

/**
 * Class RenewSubscriptionsToday
 *
 * Job to renew all subscriptions that expire tonight at midnight.
 *
 * This task runs daily and will collect all subscriptions that expire at the next midnight (midnight tonight). It will
 * then attempt to renew each subscription.
 *
 * @package App\Jobs
 */
class RenewSubscriptionsToday implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // _tb TODO: Discuss concerns of task timing out if there are a large number of subscriptions to renew.

        // Renew everything due for renewal at midnight
        $subscriptions = Subscription::where('ends_at', startOfToday())->where('renew', true)->get();

        foreach ($subscriptions as $subscription) {
            $subscription->renewSubscription();
        }
    }
}
