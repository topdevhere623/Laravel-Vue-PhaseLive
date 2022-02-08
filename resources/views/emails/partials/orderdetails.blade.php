@if($order->items->count())
## Releases
@component('mail::table')
| Name                 | Format                        | Price                                          |
|:-------------------- |:----------------------------- |:---------------------------------------------- |
@foreach($order->items as $item)
| {{ $item->type->name }} | {{ $item->format }} | &pound;{{ penniesAsPounds($item->price) }} |
@endforeach
@endcomponent
@endif

{{--@if(count($order->tracks))--}}
{{--## Tracks--}}
{{--@component('mail::table')--}}
{{--    | Name                | Format                      | Price                                        |--}}
{{--    |:------------------- |:--------------------------- |:-------------------------------------------- |--}}
{{--    @foreach($order->items()->tracks as $track)--}}
{{--    | {{ $track->name }}  | {{ $track->pivot->format }} | &pound;{{ penniesAsPounds($track->pivot->price) }} |--}}
{{--    @endforeach--}}
{{--@endcomponent--}}
{{--@endif--}}
<hr>
<table>
    <tr>
        <td style="font-weight: bold; padding-right: 25px;">Subtotal</td>
        <td>&pound;{{ penniesAsPounds($order->sub_total) }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding-right: 25px;">Tax</td>
        <td>&pound;{{ penniesAsPounds($order->tax) }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding-right: 25px;">Total</td>
        <td>&pound;{{ penniesAsPounds($order->total) }}</td>
    </tr>
</table>
<br>
<br>
Thanks,<br>
{{ config('app.name') }}
