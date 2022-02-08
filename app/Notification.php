<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public static function notifyFollowers($owner,$notification){
    	//check if owner have follower
    	if($owner->followers->isNotEmpty()){
    		//notify each of the followers of the new event
    		$owner->followers->each(function ($user, $key) use($notification) {
			    $user->notify($notification);
			});
    	}
    }

    public static function notifyUser($owner,$notification){
    	$owner->notify($notification);
    }
}
