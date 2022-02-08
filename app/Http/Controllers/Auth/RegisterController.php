<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Events\Register;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Mailcoach\Models\Tag;
use App\Http\Controllers\Controller;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;

class RegisterController extends Controller
{
    protected $types = [
        'standard',
        'artist',
        'pro',
    ];

    protected $rules = [
        'all' => [
            'personal.firstname' => 'required|string|max:255',
            'personal.surname' => 'required|string|max:255',
            'personal.email' => 'required|email|unique:users,email|max:255',
            'personal.password' => 'required|string|confirmed',
            'personal.password_confirmation' => 'required|string',

            'interests.genres' => 'required|between:1,4',
            'interests.genres.*.id' => 'required|exists:genres,id',
            'newsletter' => 'nullable',
            'guestCart' => 'nullable',
        ],
        'standard' => [
            'personal.username' => 'required|string|unique:users,name|max:20',
        ],
        'pro' => [
            'artist.username' => 'required|string|unique:users,name|max:20',
            'artist.genres' => 'required|between:1,4',
            'artist.genres.*.id' => 'required|exists:genres,id',

            'social.website' => 'nullable|string|max:255',
            'social.facebook' => 'nullable|string|max:255',
            'social.twitter' => 'nullable|string|max:255',
            'social.soundcloud' => 'nullable|string|max:255',
            'social.youtube' => 'nullable|string|max:255',
        ],
    ];

    public function register(Request $request, $type)
    {
        if (!in_array($type, $this->types)) {
            throw new \Exception('membership type not valid');
        }

        $validated = $request->validate(
            array_merge(
                $this->rules['all'],
                $type === 'standard' ? $this->rules['standard'] : $this->rules['pro']
            )
        );

        return $this->createAccount($validated, $type);
    }

    protected function createAccount(array $data, $type = 'standard')
    {
        $user = User::create([
            'name' => $type === 'standard' ? $data['personal']['username'] : $data['artist']['username'],
            'email' => $data['personal']['email'],
            'first_name' => $data['personal']['firstname'],
            'last_name' => $data['personal']['surname'],
            'path' => $type === 'standard' ? $data['personal']['username'] : $data['artist']['username'],
            'password' => $data['personal']['password'],
        ]);
        $user->save();

        if ($type !== 'standard') {
            $user->social_web = $data['social']['website'];
            $user->social_youtube = $data['social']['youtube'];
            $user->social_facebook = $data['social']['facebook'];
            $user->social_twitter = $data['social']['twitter'];
            $user->save();
        }

        if ($type === 'standard') {
            $user->approved_at = now();
            $user->save();
        }

        if ($type === 'pro') {
            $user->createAsStripeCustomer([
                'name' => $data['personal']['firstname'] . ' ' . $data['personal']['surname'],
            ]);
            $user->trial_ends_at = now()->addDays(30);

            $genreIDs = collect($data['artist']['genres'])->map(function ($item) {
                return $item['id'];
            });

            $user->genres()->sync($genreIDs->all());
            $user->save();
        }

        if (!empty($data['newsletter'])) {
            $emailList = EmailList::where('name', 'General')->first();
            Subscriber::createWithEmail($data['personal']['email'])
                ->withAttributes([
                    'first_name' => $data['personal']['firstname'],
                    'last_name' => $data['personal']['surname']
                ])
                ->skipConfirmation()
                ->subscribeTo($emailList);
            if ($type === 'pro') {
                $emailList = EmailList::where('name', 'Artist Pro')->first();
                Subscriber::createWithEmail($data['personal']['email'])
                    ->withAttributes([
                        'first_name' => $data['personal']['firstname'],
                        'last_name' => $data['personal']['surname']
                    ])
                    ->skipConfirmation()
                    ->subscribeTo($emailList);
            }
            if ($type === 'artist') {
                $emailList = EmailList::where('name', 'Artist')->first();
                Subscriber::createWithEmail($data['personal']['email'])
                    ->withAttributes([
                        'first_name' => $data['personal']['firstname'],
                        'last_name' => $data['personal']['surname']
                    ])
                    ->skipConfirmation()
                    ->subscribeTo($emailList);
            }
        }

        $this->createNotificationSettings($user, $data['newsletter']);

        $user->assignRole([$type]);

        $genreIDs = collect($data['interests']['genres'])->pluck('id');

        $user->interests()->sync($genreIDs->all());

        /** Transfer over the guest cart if applicable */
        if (!is_null($data['guestCart'])) {
            $user->syncGuestCart($data['guestCart']);
        }

        event(new Register($user));

        return $user;
    }

    protected function createNotificationSettings($user, $newsletter)
    {
        $user->notification_setting()->create([
            'activity_follower_on_me_email' => false,
            'activity_share_on_mine_email' => false,
            'activity_post_from_followee_email' => false,
            'activity_like_on_mine_email' => false,
            'activity_comment_on_mine_email' => false,
            'activity_message_email' => false,
            'phase_new_features_email' => false,
            'phase_surveys_feedback_email' => false,
            'phase_tips_offers_email' => false,
            'phase_newsletter_email' => $newsletter,
        ]);

        return $this;
    }
}
