<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FeaturedReleaseDates extends Model
{
    protected $guarded = [];

    protected $with = ['release'];

    protected $appends = ['available_dates'];

    protected $dates = [
        'approved_at',
        'declined_at'
    ];

    public function release()
    {
        return $this->belongsTo('App\Release','release_id');
    }

    public function order()
    {
        return $this->belongsTo(FeaturedOrder::class, 'order_id');
    }

    public function getAvailableDatesAttribute()
    {
        $startDate = now()->addDays(2);
        $endDate = now()->addDays(2)->addWeeks(2);
        $dates = $this->getDateRange($startDate, $endDate);

        $availableDates = $this->getFeaturedReleases($startDate, $endDate)->filter(function ($value, $key) {
            return $value->amount >= 6;
        })->keys();

        return $dates->diff($availableDates);
    }

    public function getFeaturedReleases($startDate, $endDate)
    {
        return DB::table('featured_release_dates')
            ->select(DB::raw('featured_date, count(release_id) as amount'))
            ->where('declined_at', '=', null)
            ->groupBy('featured_date')
            ->having('featured_date', '>=', $startDate)
            ->having('featured_date', '<=', $endDate)
            ->get()->keyBy(function ($item) {
                return Carbon::parse($item->featured_date)->format('Y-m-d');
            });
    }

    protected function getDateRange(Carbon $startDate, Carbon $endDate)
    {
        $dates = new Collection();

        for($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        return $dates;
    }

    public function approve()
    {
        $this->approved_at = now();

        $this->save();

        return $this;
    }

    public function decline()
    {
        $this->declined_at = now();

        $this->save();

        return $this;
    }
}
