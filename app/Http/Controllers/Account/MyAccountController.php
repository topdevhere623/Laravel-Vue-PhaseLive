<?php

namespace App\Http\Controllers\Account;

use App\Events\User\EmailChanged;
use App\Mail\AccountDowngraded;
use App\Mail\AccountUpgraded;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;
use App\Validators\Account\MyAccountValidator;

class MyAccountController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new MyAccountValidator();
    }

    /**
     * User is updating their email address and/or updating their email subscription preferences
     *
     * @param Request $request
     * @return \App\User $user
     */
    public function postEmail(Request $request)
    {
        $currentEmail = $request->user()->email;

        $this->validator->validateEmail($request);
        if ($this->validator->passes()) {
            event(new EmailChanged($request->user(), $request->address));

            if ($request->address) {
                $request->user()->email = $request->address;
                $request->user()->save();

                EmailList::query()->each(function ($list) use ($currentEmail, $request) {
                    $subscriber = Subscriber::findForEmail($currentEmail, $list);
                    if ($subscriber->isSubscribed()) {
                        $subscriber->unsubscribe();
                        $list->subscribeSkippingConfirmation($request->address);
                    }
                });
            }
        }

        return $request->user();
    }

    /**
     * User is updating their password
     *
     * @param Request $request
     * @return \App\User $user
     */
    public function postPassword(Request $request)
    {
        $this->validator->validatePassword($request);

        if ($this->validator->passes()) {
            $request->user()->password = $request->new;
            $request->user()->save();
        }

        event(new PasswordReset($request->user()));

        return $request->user();
    }

    public function postInfo(Request $request)
    {
        $request->user()->bio = $request->bio;
        $request->user()->phone = $request->phone;
        $request->user()->social_web = $request->web;
        $request->user()->social_youtube = $request->youtube;
        $request->user()->social_twitter = $request->twitter;
        $request->user()->social_facebook = $request->facebook;

        $genreIDs = $request->interests;

        $request->user()->interests()->sync($genreIDs);

        $request->user()->save();

        return $request->user()->fresh();
    }

    /**
     * User is requesting their email notification preferences
     *
     * @param Request $request
     * @return mixed
     */
    public function getNotifications(Request $request)
    {
        $user = $request->user();

        return $user->notification_setting;
    }

    /**
     * User is submitting their email notification preferences
     *
     * @param Request $request
     * @return mixed
     */
    public function postNotifications(Request $request)
    {
        $data = $request->validate([
            '*' => 'boolean',
        ]);

        unset($data['user_id']);

        $user = $request->user();

        foreach ($data as $key => $value) {
            $user->setNotificationSetting($key, $value);
        }

        return $data;
    }

    public function upgrade(Request $request)
    {
        $user = $request->user();

        $user->approved_at = null;
        $user->syncRoles('artist');
        $user->save();

        Mail::to($user->email)->send(new AccountUpgraded($user));

        return $user->fresh();
    }

    public function downgrade(Request $request)
    {
        $user = $request->user();

        $user->syncRoles('standard');

        Mail::to($user->email)->send(new AccountDowngraded($user));

        return $user->fresh();
    }

//    public function update(Request $request)
//    {
//        $braintreeId = $request->user()->braintree_id;
//        $type = $request->input('type');
//        $class = 'Braintree\\' . $type;
//
//        $customer = $this->gateway->customer()->find($braintreeId);
//
//        $accounts = [];
//        foreach ($customer->paymentMethods as $key => $method) {
//            $accounts[get_class($method)] = $method;
//        }
//
//        $account = $accounts[$class];
//
//        $paymentMethod = $this->gateway->paymentMethod()->find($account->token);
//
//        if ($paymentMethod) {
//            $this->gateway->paymentMethod()->update($account->token, [
//                'options' => [
//                    'makeDefault' => true,
//                ]
//            ]);
//        }
//
//        return [
//            'user' => $request->user(),
//            'card' => $paymentMethod
//        ];
//    }
}
