@component('mail::message')
# {{ $subscription->subscription_plan->name }} Resumed

Hey {{ $subscription->user->first_name }},

This email is just to confirm that your subscription to {{ $subscription->subscription_plan->name }} has been resumed.
This means that your plan was originally cancelled but has been resumed during the grace period (before the subscription
ended). This means that you will be billed &pound;{{ penniesAsPounds($subscription->subscription_plan->monthly_cost) }}
again on {{ $subscription->ends_at->format('d/m/Y') }} which is when you would have originally been billed.

You can cancel your subscription at any time by visiting your account page.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
