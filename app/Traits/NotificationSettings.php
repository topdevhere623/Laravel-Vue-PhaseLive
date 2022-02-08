<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\NotificationSetting;
use Spatie\Mailcoach\Models\Tag;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;

/**
 * Trait NotificationSettings
 *
 * Applied to classes that have notification settings associated with them
 *
 * @package App\Traits
 */
trait NotificationSettings
{
    public function notificationEnabled($notification)
    {
        return !!$this->notification_setting->$notification;
    }

    public function enableNotification($notification)
    {
        $this->notification_setting->$notification = true;
        $this->notification_setting->save();
    }

    public function disableNotification($notification)
    {
        $this->notification_setting->$notification = false;
        $this->notification_setting->save();
    }

    public function setNotificationSetting($notification, $value)
    {
        $this->notification_setting->$notification = $value;
        $this->notification_setting->save();

        $subscriber = Subscriber::createWithEmail($this->email);

        if (Str::startsWith($notification, 'phase_')) {
            $list = Str::title(str_replace('email', '', str_replace(['phase_', '_'], ' ', $notification)));
            $emailList = EmailList::firstOrCreate(['name' => $list]);
        }
        if (Str::startsWith($notification, 'phase_') && $value == 1) {
            $tag = Tag::firstOrCreate(
                ['name' => Str::title($this->roles()->first()->name), 'email_list_id' => $emailList->id]
            );

            if (! $emailList->isSubscribed($this->email)) {
                $subscriber->withAttributes([
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name
                ])
                    ->skipConfirmation()
                    ->syncTags([$tag->name])
                    ->subscribeTo($emailList);
            }
        } else if (Str::startsWith($notification, 'phase_') && $value == 0) {
            EmailList::where('name', $list)->first()->unsubscribe($this->email);
        }
    }

    public function syncNotificationSettings($settings)
    {
        $this->notification_setting->update($settings);
        $this->save();
    }
}
