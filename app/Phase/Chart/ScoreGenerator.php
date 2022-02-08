<?php

namespace App\Phase\Chart;

/**
 * Class ScoreGenerator
 * @package App\Phase\Chart
 *
 * Generates a 'popularity score' for a given track or release.
 *
 * Each order increases an items popularity score significantly. Daily thereafter the items popularity decreases slightly
 * until it is back to what it was before the order was placed.
 *
 * The default values currently decrease an items score by 1% per day after each order is placed. That means that for
 * every order, the effect of that order on the items popularity decreases by 1% for 100 days.
 */
class ScoreGenerator
{
    // How much the items score increases per order
    const ORDER_VALUE = 100;

    // How much the items score increases per like
    const LIKE_VALUE = 30;

    // How much the items score increases per share
    const SHARE_VALUE = 10;

    // How much the items score decreases every day.
    const DAILY_DEVALUE = 1;

    // How many days until the items value returns to what it was before an order was placed
    const VALUE_NEGATE_PERIOD = self::ORDER_VALUE / self::DAILY_DEVALUE;

    /**
     * Generate the score for the item
     *
     * @param $item \App\Track|\App\Release
     * @return float|int
     */
    public static function generate($item)
    {
        $now = now();
        // Only examine orders which have not been negated by time yet.
        $orders = $item->orders()
            ->whereDate('created_at', '>=', (clone $now)
            ->subDays(self::VALUE_NEGATE_PERIOD))
            ->where('status', 'complete');

        $likesScore = $item->likes()->count() * self::LIKE_VALUE;
        $sharesScore = $item->shares()->count() * self::SHARE_VALUE;
        $ordersScore = $orders->count() * self::ORDER_VALUE;

        $score = collect([$likesScore, $sharesScore, $ordersScore])->sum();

        foreach ($orders->get() as $order) {
            // For every day the order is old, subtract the 'daily devalue' value from its score
            $age = $order->created_at->diffInDays($now);
            $score -= $age * self::DAILY_DEVALUE;
        }

        return $score;
    }
}
