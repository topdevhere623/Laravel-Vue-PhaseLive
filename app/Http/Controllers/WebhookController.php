<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Events\User\PlacedOrder;
use App\Release;
use Illuminate\Support\Facades\Log;
use Stripe\Transfer as StripeTransfer;
use Laravel\Cashier\Events\WebhookHandled;
use Laravel\Cashier\Events\WebhookReceived;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    /**
     * Handle a Stripe webhook call.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle'.Str::studly(str_replace('.', '_', $payload['type']));

        WebhookReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod();
    }

    public function handleChargeSucceeded(array $payload)
    {
        $stripeOrderId = $payload['data']['object']['metadata']['order_id'];
        if ($order = Order::find($stripeOrderId)) {
            $items = $order->items;

            if (count($items) > 0) {
                $items->each(function ($item) use ($order, $payload) {
                    $fee = 1 - ($item->type instanceof Release ? $item->type->royalty_fee : $item->type->release->royalty_fee);

                    if (!is_null($item->seller->stripe_account_id)) {
                        StripeTransfer::create([
                            // Defaults to taking a 20% cut
                            'amount' => $item->price * ($fee ?? 0.8), // NOTE: THIS IS BAD - IT DOESNT ACCOUNT FOR STRIPES FEES (this needs to be fixed when connect is implemented)
                            'currency' => 'gbp',
                            'destination' => $item->seller->stripe_account_id,
                            'transfer_group' => "Order-{$order->id}",
                            'source_transaction' => $payload['data']['object']['id'],
                        ], Cashier::stripeOptions());
                    }
                });
            }

            if ($order->status !== 'complete') {
                $order->status = 'complete';
                $order->gateway = 'stripe';
                $order->gateway_charge = $payload['data']['object']['id'];
                $order->save();
                $order->emptyCart();
                event(new PlacedOrder($order));
            }
        }

        return $this->successMethod();
    }

    /**
     * Handle successful calls on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function successMethod($parameters = [])
    {
        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function missingMethod($parameters = [])
    {
        return new Response;
    }
}
