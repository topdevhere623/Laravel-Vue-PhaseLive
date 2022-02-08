<?php

namespace App;

use Carbon\Carbon;
use App\Traits\Image;
use App\Traits\Likeable;
use App\Traits\Shareable;
use App\Traits\Commentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * Class News
 *
 * A news article
 *
 * @package App
 */
class News extends PhaseModel
{
    use Shareable, SoftDeletes, Likeable, Commentable, Image, SearchableTrait;

    protected $fillable = ['title', 'content', 'path', 'user_id', 'published_at'];

    protected $with = [

        // 'image',
        // 'categories',
        // 'user'

    ];

    protected $appends = [

        // 'comments_count',
        'is_liked',
        // 'likes_count',
        'is_shared',
        // 'shares_count',
        'is_recent'

    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $searchable = [
        'columns' => [
            'news.title' => 30,
            'news.path' => 20,
            'news.content' => 10,
            'news.created_at' => 10,
            'users.name' => 5,
            'users.first_name' => 1,
            'users.last_name' => 1,
        ],
        'joins' => [
            'users' => ['users.id', 'news.user_id'],
        ]
    ];

    public function image()
    {
        return $this->hasOne('App\Asset', 'id', 'image_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '!=', null);
    }

    public function scopeDrafts($query)
    {
        return $query->where('published_at', null)
            ->orWhere('published_at', '>', Carbon::now());
    }

    public function publishPost()
    {
        $this->published_at = Carbon::now();
        $this->save();
    }

    public function isDraft()
    {
        if ($this->published_at === null || $this->published_at->gt(Carbon::now())) {
            return true;
        }

        return false;
    }

    public function getIsRecentAttribute()
    {
        return ($this->published_at === null) ? false : $this->published_at->diffInDays() < 7;
    }
}
