@component('mail::message')
# New Contact Form Submission
**Name:** {{ $formData['name'] }}<br>
**Email:** {{ $formData['email'] }}

## The message received is as follows:
<hr>
{!! nl2br($formData['message']) !!}
<hr>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
