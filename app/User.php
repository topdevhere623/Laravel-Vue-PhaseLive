<?php

namespace App;

use Carbon\Carbon;
use App\Traits\Liker;
use App\Traits\Follow;
use App\Traits\CanShare;
use App\Traits\Commenter;
use App\Phase\ImageManager;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Traits\Marketplace;
use App\Traits\NotificationSettings;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Events\User\UpdatedAvatar as UserUpdatedAvatar;
use Storage;

/**
 * Class User
 *
 * A site user
 *
 * @package App
 */
class User extends Authenticatable
{
    use Marketplace,
        Notifiable,
        NotificationSettings,
        HasRoles,
        SoftDeletes,
        Liker,
        Follow,
        Commenter,
        CanShare,
        SearchableTrait;

    protected $fillable = [
        'path',
        'name',
        'first_name',
        'last_name',
        'phone',
        'user_id',
        'email',
        'password',
        'bio',
        'social_web',
        'social_youtube',
        'social_twitter',
        'social_soundcloud',
        'social_facebook',
        'notification_setting_id',
    ];

    protected $hidden = [
        'stripe_id',
        'password',
        'remember_token',
    ];

    protected $appends = [
        'type',
        'account_type',
        // 'follower_count',
        'avatar',
        'banner',
        //        'all_permissions',
        'tracks_count_this_month',
        //        'is_on_trial',
        'account_verified',
        'interests',
        //        'plays',
        'is_recent',
        //        'stripe_account_id',
        //        'on_grace_period',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'trial_ends_at'
    ];

    protected $searchable = [
        'columns' => [
            'users.name' => 30,
            'users.first_name' => 20,
            'users.last_name' => 20,
            'users.email' => 10,
        ],
    ];

    public function featuredOrders(): HasMany
    {
        return $this->hasMany(FeaturedOrder::class);
    }

    //    protected $with = ['interests'];

    // Most models inherit this method from the PhaseModel class, but this class extends Authenticatable instead
    public function getTypeAttribute()
    {
        return Str::snake(class_basename($this));
    }

    public function scopeByPath($query, $path)
    {
        return $query->where('path', $path);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getAccountTypeAttribute()
    {
        if ($this->hasRole('pro')) {
            return 'pro';
        } elseif ($this->hasRole('artist')) {
            return 'artist';
        } else {
            return 'standard';
        }
    }

    //    public function getStripeAccountIdAttribute(): bool
    //    {
    //        return (bool) $this->stripe_id;
    //    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getPlaysAttribute()
    {
        return $this->plays()->get()->unique()->values()->take(10);
    }

    public function getIsOnTrialAttribute()
    {
        return $this->onTrial();
    }

    public function getAccountVerifiedAttribute()
    {
        if (!$account = $this->getAccount()) {
            return false;
        }

        return count($this->getAccount()->requirements->currently_due) < 1;
    }

    //    public function getOnGracePeriodAttribute()
    //    {
    //        return $this->subscription('default')->onGracePeriod();
    //    }

    public function plays()
    {
        return $this->belongsToMany(Track::class, 'user_play', 'user_id', 'track_id')
            ->withTimestamps();
    }

    public function cart_releases()
    {
        return $this->morphedByMany('App\Release', 'cartable')
            ->with('tracks.artist')
            ->withPivot('download_format')
            ->withTimestamps();
    }

    public function cart_tracks()
    {
        return $this->morphedByMany('App\Track', 'cartable')
            ->with('artist')
            ->withPivot('download_format')
            ->withTimestamps();
    }

    public function sales()
    {
        return $this->hasMany('App\OrderItem', 'seller_id');
    }

    public function getAvatarAttribute()
    {
        if ($this->avatar_id) {
            return $this->avatar()->first();
        } else {
            return Asset::find(2);
        }
    }

    public function getBannerAttribute()
    {
        if ($this->banner_id) {
            return $this->banner()->first();
        } else {
            return Asset::find(2);
        }
    }

    public function notification_setting()
    {
        return $this->hasOne('App\NotificationSetting');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function avatar()
    {
        return $this->belongsTo('App\Asset');
    }

    public function banner()
    {
        return $this->belongsTo('App\Asset', 'banner_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Page', 'user_id', 'id');
    }

    public function news_posts()
    {
        return $this->hasMany('App\News', 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'purchaser_id');
    }

    public function playlists()
    {
        return $this->hasMany('App\Playlist');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function actions()
    {
        return $this->hasMany('App\Action', 'created_by');
    }

    public function releases()
    {
        return $this->hasMany('App\Release', 'uploaded_by');
    }

    public function tracks()
    {
        return $this->hasMany('App\Track', 'uploaded_by');
    }

    public function getTracksCountThisMonthAttribute()
    {
        return $this->tracks()->whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])->count();
    }

    public function tracksCountThisMonth()
    {
        return $this->getTracksCountThisMonthAttribute();
    }

    public function shares()
    {
        return $this->hasMany('App\Share');
    }

    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    public function merch()
    {
        return $this->hasMany('App\Merch');
    }

    public function interests()
    {
        return $this->belongsToMany(Genre::class, 'user_interests');
    }

    public function getInterestsAttribute()
    {
        return $this->interests()->get();
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'user_genres');
    }

    /**
     * Update the users avatar
     *
     * @param $file
     *
     * @return mixed
     * @throws \Exception
     */
    public function newAvatar($file)
    {
        $manager = ImageManager::resource($file)
            ->directory('avatars')
            ->altText('User Avatar')
            ->square()
            ->storeMedium()
            ->storeThumb();

        $this->deleteAvatar();

        $this->avatar_id = $manager->asset->id;
        $this->save();

        event(new UserUpdatedAvatar($manager->asset));

        return $this->avatar;
    }

    /**
     * Update the users banner
     *
     * @param $file
     *
     * @return mixed
     * @throws \Exception
     */
    public function newProfileBanner($file)
    {
        $banner = ImageManager::resource($file)
            ->directory('users')
            ->altText('')
            ->storeLarge()
            ->storeMedium()
            ->storeThumb();

        $this->deleteBanner();

        $this->banner_id = $banner->asset->id;
        $this->save();

        // event(new UserUpdatedAvatar($manager->asset));

        return $this->avatar;
    }

    /**
     * Delete the users avatar and the associated Action & Asset
     *
     * @throws \Exception
     */
    public function deleteAvatar()
    {
        if ($this->avatar_id) {
            foreach ($this->avatar->files as $file) {
                Storage::delete($file->path);
                File::destroy($file->id);
            }
            Action::where('item_type', 'asset')
                ->where('item_id', $this->avatar->id)
                ->delete();

            // Asset::destroy($this->avatar->id);
        }
    }

    /**
     * Delete the users banner and the associated asset
     *
     * @throws \Exception
     */
    public function deleteBanner()
    {
        $banner_id = $this->banner_id;
        if ($banner_id) {
            foreach ($this->banner->files as $file) {
                Storage::delete($file->path);
                File::destroy($file->id);
            }

            $this->update(['banner_id' => null]);
            Asset::destroy($banner_id);
        }
    }

    public function threads()
    {
        return $this->belongsToMany('App\Thread', 'thread_users')->withPivot(['read_at'])->withTimestamps();
    }

    // public function scopeIsSender($query, $message)
    // {
    //     return $message->sender->is(auth()->user());
    // }

    public function freeze()
    {
        $this->status = 'frozen';
        $this->save();

        return $this;
    }

    public function unFreeze()
    {
        $this->status = 'active';
        $this->save();

        return $this;
    }

    public function isFrozen()
    {
        return $this->status === 'frozen';
    }

    public function isBanned()
    {
        return $this->banned_at;
    }

    public function getAllPermissionsAttribute()
    {
        $permissions = [];

        foreach (Permission::all() as $permission) {
            if ($this->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }

        return $permissions;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    //    public function taxPercentage()
    //    {
    //        return 20;
    //    }

    public function getIsRecentAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffInDays() < 7;
        }

        return false;
    }

    /**
     * Store items added to the cart as a guest
     */
    public function syncGuestCart($cartItems)
    {
        foreach ($cartItems as $cart) {
            switch ($cart['type']) {
                case 'release':
                    $release = Release::findOrFail($cart['id']);
                    if ($release->tracks->count() > 0) { // Users shouldnt be able to buy a release with 0 tracks
                        if (!$this->cart_releases->contains($cart['id'])) {
                            $this->cart_releases()
                                ->save($release, ['download_format' => $cart['format']]);
                        }
                    }

                    break;
                case 'track':
                    $track = Track::findOrFail($cart['id']);
                    if (!$this->cart_tracks->contains($cart['id'])) {
                        $this->cart_tracks()
                            ->save($track, ['download_format' => $cart['format']]);
                    }
                    break;
            }
        }
    }
}
