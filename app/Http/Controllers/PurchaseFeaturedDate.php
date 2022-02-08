<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\FeaturedReleaseDates;

class PurchaseFeaturedDate extends Controller
{
//    public function store(Request $request)
//    {
//        $total = (count($request->input('dates')) * (int) setting('featured_spot_price')) * 100;
//        $user = User::find($request->user_id);
//
//        $orderId = $user->featuredOrders()->create([
//            'amount' => $total,
//        ]);
//
//        foreach($request->input('dates') as $date) {
//            FeaturedReleaseDates::create([
//                'featured_date' => Carbon::parse($date),
//                'release_id' => $request->input('releaseId'),
//                'order_id' => $orderId,
//            ]);
//        }
//    }
}
