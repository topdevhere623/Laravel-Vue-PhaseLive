<?php

namespace App;

/**
 * Class Component
 *
 * A database representation of a Vue component. Used to dynamically create new pages using existing Vue components.
 *
 * @package App
 */
class Component extends PhaseModel
{
    protected $fillable = ['name'];
}
