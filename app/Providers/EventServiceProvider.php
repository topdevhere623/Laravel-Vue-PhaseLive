<?php

namespace App\Providers;

use App\Events\SettleFeaturedDateOrderEvent;
use App\Listeners\PayFeaturedDateOrderListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Subscription
        'App\Events\Subscription\Cancelled' => [
            'App\Listeners\Subscription\SendUserCancelledNotification',
        ],
        'App\Events\Subscription\Created' => [
            'App\Listeners\Subscription\SendUserCreatedNotification',
        ],
        'App\Events\Subscription\PaymentSucceeded' => [
            'App\Listeners\Subscription\SendUserPaymentSuccessNotification',
        ],
        'App\Events\Subscription\PaymentFailed' => [
            'App\Listeners\Subscription\SendUserPaymentFailureNotification',
        ],
        'App\Events\Subscription\Restarted' => [
            'App\Listeners\Subscription\SendUserRestartedNotification',
        ],
        'App\Events\Subscription\Resumed' => [
            'App\Listeners\Subscription\SendUserResumedNotification',
        ],
        // User
        'App\Events\User\CreatedEvent' => [
            'App\Listeners\ActionRegisters\RegisterCreatedEventAction',
        ],
        'App\Events\User\CreatedMerch' => [
            'App\Listeners\ActionRegisters\RegisterCreatedMerchAction',
        ],
        'App\Events\User\FollowedUser' => [
            'App\Listeners\ActionRegisters\RegisterFollowedUserAction',
        ],
        'App\Events\User\LikedItem' => [
            'App\Listeners\ActionRegisters\RegisterLikedItemAction',
        ],
        'App\Events\User\PlacedOrder' => [
            'App\Listeners\ActionRegisters\RegisterPlacedOrderAction',
            'App\Listeners\SendOrderReceiptNotification', // To purchaser
            'App\Listeners\SendOrderReceivedNotification', // To admin
        ],
        'App\Events\User\PostedStatusUpdate' => [
            'App\Listeners\ActionRegisters\RegisterPostedStatusUpdateAction',
        ],
        'App\Events\User\ReportSubmitted' => [
            'App\Listeners\ActionRegisters\RegisterReportAction',
            'App\Listeners\SendNewReportNotification',
        ],
        'App\Events\User\SharedItem' => [
            'App\Listeners\ActionRegisters\RegisterSharedItemAction',
        ],
        'App\Events\User\UpdatedAvatar' => [
            'App\Listeners\ActionRegisters\RegisterAvatarUpdatedAction',
        ],
        'App\Events\User\UploadedRelease' => [
            'App\Listeners\ActionRegisters\RegisterUploadedReleaseAction',
        ],
        'App\Events\User\UploadedVideo' => [
            'App\Listeners\ActionRegisters\RegisterUploadedVideoAction',
        ],
        'App\Events\Register' => [
            'App\Listeners\NewAccountCreated',
            'App\Listeners\AdminNewAccountCreated'
        ],
        'App\Events\FreezeAccount' => [
            'App\Listeners\FreezeUser',
            'App\Listeners\FreezeUserContent'
        ],
        'App\Events\UnFreezeAccount' => [
            'App\Listeners\UnFreezeUser',
            'App\Listeners\UnFreezeUserContent'
        ],
        'App\Events\BanUserAccount' => [
            'App\Listeners\BanUser',
            'App\Listeners\RemoveUserContent'
        ],
        'Illuminate\Auth\Events\PasswordReset' => [
            'App\Listeners\PasswordChanged',
        ],
        'App\Events\User\EmailChanged' => [
            'App\Listeners\EmailChangedListener',
        ],
        SettleFeaturedDateOrderEvent::class => [
            PayFeaturedDateOrderListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
