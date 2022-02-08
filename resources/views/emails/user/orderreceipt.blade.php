@component('mail::message')
<table align="center">
    <tr>
        <td>
            <img src="{{ asset('img/emails/main-logo.png') }}" alt="Phase Logo" width="180">
        </td>
    </tr>
</table>

@component('mail::subcopy')
# Purchase Receipt

Dear {{ $order->purchaser->first_name }},<br>
<br>
Thank you for your purchase on Phase. Your purchase details are outlined below:
<hr>
@include('emails.partials.orderdetails', ['order' => $order])

@endcomponent

@endcomponent
