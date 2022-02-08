<?php

namespace App;

use DB;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * An order represents a single payment for goods on the site
 *
 * Class Order
 * @package App
 */
class Order extends PhaseModel
{
    use SearchableTrait;

    protected $fillable = ['sub_total', 'tax', 'total', 'status'];

    protected $with = ['items'];

    protected $classLookup = [
        'release' => Release::class,
        'track' => Track::class,
    ];

    protected $searchable = [
        'columns' => [
            'orders.id' => 10,
            'orders.created_at' => 5,
            'users.name' => 20,
            'users.first_name' => 10,
            'users.last_name' => 10,
        ],
        'joins' => [
            'users' => ['orders.purchaser_id', 'users.id']
        ]
    ];

    public function purchaser()
    {
        return $this->belongsTo('App\User', 'purchaser_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addItem()
    {
        // Add Items
        // Update subtotal/tax/total
    }

    public function setStatusAttribute($status)
    {
        $allowed = ['pending', 'cancelled', 'complete'];
        if(in_array($status, $allowed)) {
            $this->attributes['status'] = $status;
        } else {
            $this->attributes['status'] = 'pending';
        }
    }

    public function scopeComplete($query)
    {
        return $query->where('status', 'complete');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function downloads()
    {
        return $this->hasMany('App\Download');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function saveItems($items)
    {
        foreach($items as $item) {
            $item['format'] = (isset($item['format']) ? $item['format'] : 'mp3');
            $class = $this->classLookup[$item['type']]::find($item['id']);
            $price = $class->price($item['format']);

            $this->sub_total += $price;
            $this->items()->create([
                'order_id' => $this->id,
                'item_id' => $class->id,
                'item_type' => $item['type'],
                'price' => $class->price,
                'seller_id' => $class->uploaded_by
            ]);
            $method = 'createDownloadFor'. ucfirst($item['type']);
            $this->$method($class, $item['format']);
        }
        $this->tax = $this->sub_total * setting('tax_rate');
        $this->total = $this->sub_total + $this->tax;
        $this->save();
    }

    public function emptyCart()
    {
        DB::table('cartables')
            ->where('user_id', $this->purchaser->id)
            ->delete();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function createDownloadForTrack(Track $track, $format)
    {
        $download = new Download([
            'order_id' => $this->id,
            'track_id' => $track->id,
        ]);
        $download->format = $format;
        $download->save();
    }

    private function createDownloadForRelease(Release $release, $format)
    {
        foreach ($release->tracks as $track) {
            $this->createDownloadForTrack($track, $format);
        }
    }
}
