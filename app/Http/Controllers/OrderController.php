<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $order;

    public function list(Request $request, $count = 15)
    {
        $orders = Order::where('purchaser_id', $request->user()->id);

        return paginateOrAll($orders, $count);
    }

    public function listWithItems(Request $request, $count = 15)
    {
        $orders = Order::where('purchaser_id', $request->user()->id)
            ->with('tracks')
            ->with('releases');

        return paginateOrAll($orders, $count);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'existing_account' => 'required|boolean'
        ]);

        $user = auth()->user();
        $existing = $data['existing_account'];

        /** If the user is trying to use an existing card but is not a stripe customer we need to throw an error */
        if ($existing && is_null($user->stripe_id)) {
            throw new \Exception('Unable to charge customer');
        }

        $this->order = new Order();
        $request->user()->orders()->save($this->order);
        $this->order->save();

        $this->order->saveItems($data['items']);

        /** If its an existing account then we need to create a charge */
        if ($existing) {
            $request->user()->charge(
                $this->order->fresh()->total,
                $user->defaultPaymentMethod()->id,
                [
                    'metadata' => [
                        'order_id' => $this->order->id,
                    ]
                ]
            );
        }

        /** Remove items from users cart */
        $request->user()->cart_releases()->sync([]);
        $request->user()->cart_tracks()->sync([]);

        return $this->order;
    }
}
