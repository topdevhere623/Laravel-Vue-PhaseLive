<?php

namespace App;

use App\Traits\Commentable;
use App\Traits\Likeable;
use App\Traits\Reportable;
use App\Traits\Shareable;
use App\User;

/**
 * A user created 'post'. Like a 'status update'
 *
 * Class Post
 * @package App
 */
class Post extends PhaseModel
{
    use Shareable;
    use Likeable;
    use Commentable;
    use Reportable;

    protected $fillable = ['user_id', 'target_id', 'body', 'asset_id'];

    protected $with = [
        'user',
        'attachment'
    ];

    protected $appends = [
        'is_liked',
        'is_shared',
        'is_recent'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function attachment()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

    public function scopeBy($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeTargetedAt($query, User $user)
    {
        return $query->where('target_id', $user->id);
    }

    public function scopeBodyNotNull($query)
    {
        return $query->where('body', '<>', '');
    }

    public function getIsRecentAttribute()
    {
        return $this->created_at->diffInDays() < 7;
    }
}
