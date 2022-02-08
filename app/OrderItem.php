<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'item_type',
        'item_id',
        'price',
        'seller_id'
    ];

    public function type()
    {
        return $this->morphTo('item');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class);
    }
}
