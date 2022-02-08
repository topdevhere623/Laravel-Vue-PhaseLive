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
## Hey {{ $user->first_name }}, we have received your request to upgrade to an Artist account

<ul>
    <li>User type: {{ \Illuminate\Support\Str::title($user->roles->first()->name) }} </li>
    <li>Status: <span style="color:#f8bd01;font-weight:bold;">Processing</span></li>
</ul>

<h5 style="color:#666666;padding-bottom:20px;margin-bottom:20px">We are in the process of verifying your profile and will update you once this is finished, until then you can access Phase as a standard user.</h5>

@include('emails.partials.artist-icons')

@endcomponent

@endcomponent
