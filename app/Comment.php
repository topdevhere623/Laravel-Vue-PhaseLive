<?php

namespace App;

use App\Traits\Reportable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * Class Comment
 *
 * A polymorphic comment which can be attached to any commentable
 *
 * @package App
 */
class Comment extends PhaseModel
{
    use SoftDeletes, Reportable, SearchableTrait;

    protected $searchable = [
        'columns' => [
            'comments.body' => 30,
            'users.name' => 20,
            'users.first_name' => 10,
            'users.last_name' => 10,
        ],
        'joins' => [
            'users' => ['users.id', 'comments.user_id']
        ]
    ];

    protected $fillable = ['body', 'user_id'];

    protected $with = ['user'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
