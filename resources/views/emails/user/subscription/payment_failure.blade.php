@component('mail::message')
# Phase {{ $subscription->subscription_plan->name }} Renewal Failure

We attempted to renew your '{{ $subscription->subscription_plan->name }}' subscription but the payment failed. Your
subscription has been cancelled and we will not attempt to charge you again unless you restart your subscription.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
