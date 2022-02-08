<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * ALL MODELS EXCEPT USER SHOULD EXTEND THIS MODEL
 *
 * This model simply adds a 'type' attribute to array representations of a model so we can easily determine what 'type'
 * (class) an object is. The 'type' of a model is simply the snake case representation of the base class name (not
 * including the namespace)
 *
 * Class PhaseModel
 * @package App
 */
class PhaseModel extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends[] = 'type';
    }

    function getTypeAttribute()
    {
        return Str::snake(class_basename($this));
    }
}
