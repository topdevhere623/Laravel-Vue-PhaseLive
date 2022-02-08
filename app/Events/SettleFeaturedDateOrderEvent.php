<?php

namespace App\Events;

use App\FeaturedOrder;
use Illuminate\Foundation\Events\Dispatchable;

class SettleFeaturedDateOrderEvent
{
    use Dispatchable;

    public $order;

    public function __construct(FeaturedOrder $order)
    {
        $this->order = $order;
    }
}
