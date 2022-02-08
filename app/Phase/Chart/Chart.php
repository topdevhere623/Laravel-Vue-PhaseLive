<?php namespace App\Phase\Chart;

use App\Track;
use App\Release;

/**
 * Class Chart
 *
 * Collect tracks or releases based on their popularity.
 *
 * ISSUE/SUGGESTION: This operation requires every single track or release to be fetched and calculations made on every
 * item. This *will* cause huge performance issues as more items get added and as the entire chart is recalculated on
 * every request. A good idea would be to have a job that runs every day or so that calculates the charts and stores
 * that data in the database so response times are not ridiculously slow.
 *
 * @package App\Phase\Chart
 */
class Chart
{
    private $type;

    /**
     * Chart constructor.
     *
     * @param $typeClass string The class type to get charts for (e.g. Track::class)
     */
    public function __construct($typeClass)
    {
        $this->type = class_basename($typeClass);
    }

    /**
     * @param null $limit 
     *
     * Get every track/release, calculate a popularity score for each item and return them ordered by their score
     *
     * @return Release[]|Track[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get($limit = null)
    {
        switch ($this->type) {
            case 'Track':
                $items = Track::where('status', 'approved')->get();
                break;
            case 'Release':
                $items = Release::released()->with('uploader', 'image', 'tracks')->get();
                break;
        }
        $return = $items->sortByDesc('score')->values();

        return ($limit ? $return->take($limit) : $return);
    }
}
