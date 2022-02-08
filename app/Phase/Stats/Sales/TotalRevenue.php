<?php

namespace App\Phase\Stats\Sales;

use Carbon\Carbon;

/**
 * Class TotalRevenue
 *
 * Generate stats showing total revenue of sales for a collection of sellables
 *
 * @package App\Phase\Stats\Sales
 */
class TotalRevenue
{
    protected $user;

    /**
     * Return 2 arrays, one is a list of the last 12 months, and the other the total revenue made for the provided
     * sellables in each of those months
     *
     * @param $sellables
     * @return array
     */
    public function forSellables($sellables)
    {
        $monthlyTotalSales = [];
        $monthNames = [];
        for($i = 0; $i < 12; $i++) {
            $thisMonthSales = 0;
            $month = now()->subMonths($i);
            foreach ($sellables as $sellable) {
                $thisMonthSales += $this->getTotalSellableRevenueForMonth($month, $sellable);
            }
            $monthlyTotalSales[] = $thisMonthSales;
            $monthNames[] = $month->format('F');
        }
        return [
            array_reverse($monthNames),
            array_reverse($monthlyTotalSales),
        ];
    }

    /**
     * Get the total revenue for a specific sellable in a specific month
     *
     * @param Carbon $timeInMonth
     * @param $sellable
     * @return int
     */
    public function getTotalSellableRevenueForMonth(Carbon $timeInMonth, $sellable)
    {
        $mStart = clone $timeInMonth->startOfMonth();
        $mEnd = clone $timeInMonth->endOfMonth();
        $totalSales = 0;

        if ($sellable->created_at >= $mStart && $sellable->created_at <= $mEnd) {
            $totalSales += $sellable->price;
        }

        return $totalSales;
    }
}
