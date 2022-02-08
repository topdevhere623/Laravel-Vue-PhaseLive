@component('mail::message')
# Welcome to {{ $subscription->subscription_plan->name }}

Hey {{ $subscription->user->first_name }},

This email is just to confirm that your free trial of {{ $subscription->subscription_plan->name }} has started. You
won't be charged for this month but the plan is set to renew automatically on {{ $subscription->ends_at->format('d/m/Y') }}
when you will be charged &pound;{{ penniesAsPounds($subscription->subscription_plan->monthly_cost) }}.

You can cancel your subscription at any time by visiting your account page.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
