<?php

namespace App\Phase\Stats\Social;

use App\Track;
use App\Release;

use Carbon\Carbon;

/**
 * Class TotalLikes
 *
 * Generate stats showing total likes for a collection of likeables
 *
 * @package App\Phase\Stats\Social
 */
class TotalLikes
{
    protected $user;

    /**
     * Return 2 arrays, one is a list of the last 12 months, and the other the total likes for the provided likeables in
     * each of those months.
     *
     * @param $likeables
     * @return array
     */
    public function forLikeables($likeables)
    {
        $monthlyTotalLikes = [];
        $monthNames = [];
        for($i = 0; $i < 12; $i++) {
            $thisMonthLikes = 0;
            $month = now()->subMonths($i);
            foreach ($likeables as $likeable) {
                $thisMonthLikes += $this->getTotalLikesForMonth($month, $likeable);
            }
            $monthlyTotalLikes[] = $thisMonthLikes;
            $monthNames[] = $month->format('F');
        }
        return [
            array_reverse($monthNames),
            array_reverse($monthlyTotalLikes),
        ];
    }

    /**
     * Get the total likes for a specific likeable in a specific month
     *
     * @param Carbon $timeInMonth
     * @param $likeable
     * @return int
     */
    public function getTotalLikesForMonth(Carbon $timeInMonth, $likeable)
    {
        $mStart = clone $timeInMonth->startOfMonth();
        $mEnd = clone $timeInMonth->endOfMonth();

        return $likeable->likes()
            ->where('created_at', '>=', $mStart)
            ->where('created_at', '<=', $mEnd)
            ->count();
    }
}