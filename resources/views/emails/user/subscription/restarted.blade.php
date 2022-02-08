@component('mail::message')
# {{ $subscription->subscription_plan->name }} Restarted

Hey {{ $subscription->user->first_name }},

This email is just to confirm that your subscription to {{ $subscription->subscription_plan->name }} has been restarted.
This means that you were previously subscribed to this plan but cancelled it and it expired, and have now restarted it.
As a result you will be billed &pound;{{ penniesAsPounds($subscription->subscription_plan->monthly_cost) }} monthly
starting today and your next payment is on {{ $subscription->ends_at->format('d/m/Y') }}.

You can cancel your subscription at any time by visiting your account page.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
