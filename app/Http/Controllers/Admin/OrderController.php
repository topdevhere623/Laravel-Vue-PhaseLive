<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, $filter = null)
    {
        switch ($filter) {
            case 'pending':
                $orders = Order::pending();
                break;
            case 'complete':
                $orders = Order::complete();
                break;
            case 'cancelled':
                $orders = Order::cancelled();
                break;
            default:
                $orders = new Order;
                break;
        }

        if ($request->has('search')) {
            $orders = $orders->search($request->search)->paginate(15);
        } else {
            $orders = $orders->paginate(15);
        }

        return view('admin.orders.index')->with([
            'orders' => $orders,
            'filter' => $filter
        ]);
    }

    public function update($status, $id)
    {
        $order = Order::find($id);

        $order->status = $status;

        $order->save();

        return back();
    }
}
