<?php

namespace App\Http\Controllers;

use App\FeaturedOrder;

class FeaturedDatesOrderController extends Controller
{
    public function __invoke($id)
    {
        return FeaturedOrder::find($id)->load('featuredDates');
    }
}
