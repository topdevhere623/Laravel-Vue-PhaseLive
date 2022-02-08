<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Action
 *
 * This model represents a database saved event. E.g. when a user updates an avatar, or uploads a new release, that
 * event is saved as an 'Action'
 *
 * @package App
 */
class Action extends PhaseModel
{
    protected $guarded = [];

    protected $appends = ['item'];

    protected $with = ['user'];

    const USER_CREATED_EVENT = 'user_created_event';
    const USER_CREATED_MERCH = 'user_created_merch';
    const USER_FOLLOWED_USER = 'user_followed_user';
    const USER_PLACED_ORDER = 'user_placed_order';
    const USER_POSTED_STATUS_UPDATE = 'user_posted_status_update';
    const USER_SUBMITTED_REPORT = 'user_submitted_report';
    const USER_SHARED_ITEM = 'user_shared_item';
    const USER_AVATAR_UPDATED = 'user_avatar_updated';
    const USER_UPLOADED_RELEASE = 'user_uploaded_release';
    const USER_UPLOADED_VIDEO = 'user_uploaded_video';
    const USER_LIKED_ITEM = 'user_liked_item';

    static $aliases = [
        'App\Events\User\CreatedEvent' => self::USER_CREATED_EVENT,
        'App\Events\User\CreatedMerch' => self::USER_CREATED_MERCH,
        'App\Events\User\FollowedUser' => self::USER_FOLLOWED_USER,
        'App\Events\User\LikedItem' => self::USER_LIKED_ITEM,
        'App\Events\User\PlacedOrder' => self::USER_PLACED_ORDER,
        'App\Events\User\PostedStatusUpdate' => self::USER_POSTED_STATUS_UPDATE,
        'App\Events\User\ReportSubmitted' => self::USER_SUBMITTED_REPORT,
        'App\Events\User\SharedItem' => self::USER_SHARED_ITEM,
        'App\Events\User\UpdatedAvatar' => self::USER_AVATAR_UPDATED,
        'App\Events\User\UploadedRelease' => self::USER_UPLOADED_RELEASE,
        'App\Events\User\UploadedVideo' => self::USER_UPLOADED_VIDEO,
    ];

    public function setEventTypeAttribute($eventClass)
    {
        $className = get_class($eventClass);
        $this->attributes['event_type'] = self::$aliases[$className];
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function scopeForUser($query, $userID)
    {
        return $query->where('created_by', $userID);
    }

    public function scopePublic($query, $public = true)
    {
        return $query->where('public', $public);
    }

    public function getItemAttribute()
    {
        return morphToModel($this->item_type, $this->item_id);
    }
}
