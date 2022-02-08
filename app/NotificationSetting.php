<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Stores users preferences on the emails they receive from the application
 *
 * Class NotificationSetting
 * @package App
 */
class NotificationSetting extends Model
{
    protected $guarded = [];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
