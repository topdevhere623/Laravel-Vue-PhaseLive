<?php

namespace App\Phase\Stats\Sales;

use Carbon\Carbon;

/**
 * Class TotalVolume
 *
 * Generate stats showing total volume of sales for a collection of sellables
 *
 * @package App\Phase\Stats\Sales
 */
class TotalVolume
{
    protected $user;

    /**
     * Return 2 arrays, one is a list of the last 12 months, and the other the total sales volume for the provided
     * sellables in each of those months
     *
     * @param $sellables
     * @return array
     */
    public function forSellables($sellables)
    {
        $monthlyTotalVolume = [];
        $monthNames = [];
        for($i = 0; $i < 12; $i++) {
            $thisMonthVolume = 0;
            $month = now()->subMonths($i);
            foreach ($sellables as $sellable) {
                $thisMonthVolume += $this->getTotalSellableVolumeForMonth($month, $sellable);
            }
            $monthlyTotalVolume[] = $thisMonthVolume;
            $monthNames[] = $month->format('F');
        }
        return [
            array_reverse($monthNames),
            array_reverse($monthlyTotalVolume),
        ];
    }

    /**
     * Get the total sales volume for a specific sellable in a specific month
     *
     * @param Carbon $timeInMonth
     * @param $sellable
     * @return int
     */
    public function getTotalSellableVolumeForMonth(Carbon $timeInMonth, $sellable)
    {
        $mStart = clone $timeInMonth->startOfMonth();
        $mEnd = clone $timeInMonth->endOfMonth();
        $totalVolume = 0;

        if ($sellable->created_at >= $mStart && $sellable->created_at <= $mEnd) {
            $totalVolume++;
        }

        return $totalVolume;
    }
}
