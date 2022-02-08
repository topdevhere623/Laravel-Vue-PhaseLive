<?php

namespace App;

/**
 * Class Setting
 *
 * A single key/value pair to represent a site wide setting
 *
 * @package App
 */
class Setting extends PhaseModel
{
    protected $fillable = ['key', 'value'];

    public function scopeByKey($query, $key)
    {
    	return $query->where('key', $key)->first();
    }

    public function scopeByPublicType($query, $type)
    {
        return $query->where('public', $type);
    }
}
