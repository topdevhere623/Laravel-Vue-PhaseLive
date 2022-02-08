@component('mail::message')
# New Order Received!

Dear Admin,<br>
<br>
A new order has been placed on Phase. The purchase details are outlined below:
<hr>
@include('emails.partials.orderdetails', ['order' => $order])
@endcomponent
