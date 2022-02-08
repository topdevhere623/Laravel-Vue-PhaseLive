<?php

namespace App\Http\Controllers;

use App\FeaturedReleaseDates;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\PaymentIntent;

class FeaturedDates extends Controller
{
    public function index(): JsonResponse
    {
        $startDate = now()->addDays(2);
        $endDate = now()->addDays(2)->addWeeks(2);

        return response()->json([
            'availableDates' => (new FeaturedReleaseDates())->available_dates,
            'datesWithAmount' => (new FeaturedReleaseDates())->getFeaturedReleases($startDate, $endDate),
            'pricePerSlot' => setting('featured_spot_price')
        ]);
    }

    public function store(Request $request): void
    {
        $total = (count($request->input('dates')) * (int) setting('featured_spot_price')) * 100;
        $user = User::find($request->input('user_id'));
        $paymentId = $request->has('payment_id') ? $request->input('payment_id') : null;

        $orderId = $user->featuredOrders()->create([
            'amount' => $total,
            'payment_id' => $paymentId,
        ])->id;

        foreach($request->input('dates') as $date) {
            FeaturedReleaseDates::create([
                'featured_date' => Carbon::parse($date),
                'release_id' => $request->input('release_id'),
                'order_id' => $orderId,
            ]);
        }
    }

    public function failedOrderIntent(Request $request)
    {
        $paymentIntent = PaymentIntent::retrieve($request->input('intentId'), Cashier::stripeOptions());

        return response()->json([
            'payment_intent' => $paymentIntent,
        ]);
    }
}
