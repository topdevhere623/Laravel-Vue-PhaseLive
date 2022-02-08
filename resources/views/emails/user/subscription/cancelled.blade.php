@component('mail::message')
# {{ $subscription->subscription_plan->name }} Cancellation

Hey {{ $subscription->user->first_name }},

This email is just to confirm that your subscription to {{ $subscription->subscription_plan->name }} has been cancelled.
You will no longer be charged for this plan and you will remain subscribed until this month of the subscription expires
on {{ $subscription->ends_at->format('d/m/Y') }}.

You can resume your subscription on your original billing cycle any time between now and
{{ $subscription->ends_at->format('d/m/Y') }}. After that you will need to restart your subscription.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
