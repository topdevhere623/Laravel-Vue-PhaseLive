@component('mail::message')
<table align="center">
    <tr>
        <td>
            <img src="{{ asset('img/emails/main-logo.png') }}" alt="Phase Logo" width="180">
        </td>
    </tr>
    <tr>
        <td>
            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:19px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:23px;color:#666666;text-align: center;">phase:<span style="color:#ff3366;">admin</span></p>
        </td>
    </tr>
</table>

@component('mail::subcopy')
## Hey {{ $user->first_name }}, we have finished verifying your profile! {{ (($user->roles->count() > 0) && ($user->roles->first()->name === 'artist_pro')) ? ' - Welcome to the PRO club!' : '' }}

<ul>
    @if($user->roles->count() > 0)
    <li>User type: {{ \Illuminate\Support\Str::title($user->roles->first()->name) }} </li>
    @endif
    <li>Status: <span style="color:#a1eee1;font-weight:bold;">Approved</span></li>
</ul>
@if($user->roles->count() > 0)
    @if ($user->roles->first()->name === 'artist')
    You now have all the benefits of an Artist user, visit our FAQs for further information
    @elseif ($user->roles->first()->name === 'artist_pro')
    You now have all the benefits of an Artist PRO user, visit our FAQs for further information
    @endif
@endif

@component('mail::button', ['url' => config('app.url')])
    User Benefits →
@endcomponent

@include('emails.partials.artist-icons')

@endcomponent

@endcomponent
