@component('mail::message')
# Phase {{ $subscription->subscription_plan->name }} Renewal Success

Your '{{ $subscription->subscription_plan->name }}' subscription renewal was successful. You will be billed again in one
month.

**Total:** &pound;{{ penniesAsPounds($subscription->subscription_plan->monthly_cost) }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
